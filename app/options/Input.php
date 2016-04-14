<?php

namespace Pgk\Options;


trait Input {

	protected $input;

	/**
	 * @param mixed $input
	 *
	 * @return Input
	 */
	public function setInput( $input ) {
		$this->input = $input;

		return $this;
	}

	public function getInput($key, $clean = '') {
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
		$input = $this->input;

		foreach ( $parts as $part ) {
			if( isset( $input[$part] ) && is_array( $input[$part] ) ) {
				$input = $input[$part];
				continue;
			}

			return filter_var( $input[$part], $filter );
		}

		return '';
	}
}