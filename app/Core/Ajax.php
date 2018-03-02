<?php

namespace Pgk\Core;

/**
 * Class Ajax
 * @package Pgk\Core
 */
class Ajax {

	private $_post;

	/**
	 * Ajax constructor.
	 */
	public function  __construct() {
		//TODO: Sanitize post values
		//TODO: use filter_input_array
		parse_str($_POST['form_data'], $this->_post);
	}

	/**
	 * Check if we have Ajax request
	 * @return bool
	 */
	public static function isAjaxRequest() {
		/**
		 * Not all servers support 'HTTP_X_REQUESTED_WITH', so to be shure we
		 * put our own marker 'call' for test
		 */
		return (filter_input( INPUT_POST, 'is_ajax', FILTER_SANITIZE_STRING ) || strtolower( filter_input( INPUT_SERVER, 'HTTP_X_REQUESTED_WITH' ) ) === 'xmlhttprequest' );
	}

	/**
	 * Process AJAX data and put it into POST superglobal
	 */
	public static function handle() {
		//if this is AJAX request, post sended data to POST superglobal and then continue
		if( self::isAjaxRequest() ) {
			parse_str($_POST['form_data'], $form_data);
			$_POST = array_merge( $_POST, $form_data );
		}

		return;
	}
}