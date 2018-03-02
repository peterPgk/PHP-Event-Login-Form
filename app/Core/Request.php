<?php

namespace Pgk\Core;

/**
 * Class Request
 * @package Pgk\Core
 */
class Request {

	/**
	 * Get and sanitize post
	 *
	 * @param mixed $key key
	 * @param string $clean marker for optional cleaning of the var
	 * @return mixed the key's value or nothing
	 */
	public static function post($key, $clean = '')
	{
		switch ($clean) {
			case 'url':
				$filter = FILTER_SANITIZE_URL;
				break;

			case 'email':
				$filter = FILTER_SANITIZE_EMAIL;
				break;

			case 'string':
			case 'password':
			default:
				$filter = FILTER_SANITIZE_STRING;
				break;
		}

		$parts = explode('.', $key);
		$input = $_POST;

		foreach ( $parts as $part ) {
			if( isset( $input[$part] ) && is_array( $input[$part] ) ) {
				$input = $input[$part];
				continue;
			}

			return filter_var( $input[$part], $filter );
		}

		//This does not work when I put variables manually - inAJAX calls ???
//		filter_input( INPUT_POST, 'username', FILTER_SANITIZE_STRING );

		return $input;
	}

	/**
	 * gets/returns the value of a specific key of the GET super-global
	 * @param mixed $key key
	 * @return mixed the key's value or nothing
	 */
	public static function get($key)
	{

//		return filter_var( INPUT_GET, $key, FILTER_SANITIZE_ENCODED );
		if (isset($_GET[$key])) {
			return $_GET[$key];
		}
		return false;
	}

	/**
	 * @param $key
	 *
	 * @return string
	 */
	public static function postRaw( $key ) {
		if( isset( $_POST ) ) {

			$parts = explode('.', $key);
			$input = $_POST;

			foreach ( $parts as $part ) {
				if( isset( $input[$part] ) && is_array( $input[$part] ) ) {
					$input = $input[$part];
					continue;
				}

				return $input[$part];
			}

			return $input;
		}

		return '';
	}
}
