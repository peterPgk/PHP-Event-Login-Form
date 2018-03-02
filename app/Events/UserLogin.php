<?php

namespace Pgk\Events;

use Pgk\Contracts\Event;
use Pgk\Core\Redirect;
use Pgk\Core\Session;
use Pgk\Model\User;

/**
 * Class UserLogin
 *
 * Fires when user tries to login 
 *
 * @package Pgk\Events
 */
class UserLogin extends Event {

	/**
	 * UserLoginEvent constructor.
	 */
	public function __construct() {
		
		parent::__construct();

		return $this;
	}

	/**
	 *
	 */
	protected function process() {

		$this->setUser( User::byNameOrEmail( $this->getInput( 'name' ) ) );

		if ( $this->validate() ) {

			$this->saveToSession();

			$this->save();
		}
	}

	

	/**
	 * @return bool
	 */
	private function validate() {

		if ( $this->hasUser() && password_verify( $this->getInput( 'password' ), $this->getUser( 'password' ) ) ) {

			$this->fired = true;

			return true;
		}

		$this->setMessage( 'error', 'USERNAME_OR_PASSWORD_WRONG' );

		$this->fired = false;

		return false;
	}

	/**
	 * Update database with some info
	 */
	private function save() {

		$this->getUser()->fill( [
			'last_login' => date('Y-m-d H:i:s'),
			'session_id' => session_id()
		] )->save();
	}

	/**
	 * Push logged user into session
	 */
	private function saveToSession() {

		Session::clear();
		Session::set( 'userdata', $this->getUser()->toArray() );
	}

	/**
	 *
	 */
	public function redirect() {

		if( $this->isFired() ) {
			Redirect::to( 'index/index' );
		}
		else {
			Redirect::to('login/index');
		}
	}
}