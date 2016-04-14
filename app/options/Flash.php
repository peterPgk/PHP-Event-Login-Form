<?php

namespace Pgk\Options;


use Pgk\Core\Messages;
use Pgk\Core\Session;

trait Flash {


	protected $messages = [];

	protected $message_types = ['error', 'success', 'info'];

	/**************
	 * Messages api
	 */

	/**
	 *
	 */
	protected function clearMessages() {
		$this->messages = [];
	}

	/**
	 * @param $type
	 * @param $message
	 */
	public function setMessage( $type, $message ) {
		if ( in_array($type, $this->message_types) ) {
			$this->messages[$type] = Messages::get( strtoupper( $message ) );
		}
	}

	public function flash() {
		if( count( $this->messages ) !== 0 ) {
			foreach ( $this->messages as $key => $value ) {
				Session::add( 'feedback', [$key => $value] );
			}
		}
	}

}