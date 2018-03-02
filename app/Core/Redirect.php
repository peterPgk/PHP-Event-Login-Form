<?php
namespace Pgk\Core;

/**
 * Class Redirect
 *
 * Simple abstraction for redirecting the user to a certain page
 */
class Redirect
{
	/**
	 * To the homepage
	 */
	public static function home()
	{
		header("location: " . Config::get('url'));
	}

	/**
	 * To the defined page
	 *
	 * @param $path
	 * @param array $data
	 */
	public static function to( $path, array $data = array() )
	{
		if( Ajax::isAjaxRequest() ) {
			(new View)->render($path, $data);
			die();
		}

		header("location: " . Config::get('url') . $path);
		exit();
	}
}