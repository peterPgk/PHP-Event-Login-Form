<?php

namespace Pgk\Events;

use Pgk\Contracts\Event;
use Pgk\Core\Redirect;
use Pgk\Core\Session;
use Pgk\Model\User;

/**
 * Class UserLogout
 *
 * Logout from the system
 *
 * @package Pgk\Events
 */
class UserLogout extends Event {


	/**
	 * UserLoginEvent constructor.
	 *
	 */
	public function __construct( ) {
		parent::__construct( );
	}

	/**
	 *
	 */
	public function redirect() {
		Redirect::home();
	}

	protected function process() {

		Session::destroy();
		User::find( $this->user_id )->update( ['last_login' => date('Y-m-d H:i:s'), 'session_id' => session_id() ] );
	}
}