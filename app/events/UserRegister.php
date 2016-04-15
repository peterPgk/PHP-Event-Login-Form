<?php

namespace Pgk\Events;

use Pgk\Contracts\Event;
use Pgk\Core\Auth;
use Pgk\Core\Redirect;
use Pgk\Model\User;
use Pgk\Utils\UserValidation;
use Pgk\Utils\Validation;

/**
 * Class UserRegister
 *
 * Registering new user event
 *
 * @package Pgk\Events
 */
class UserRegister extends Event {
	
	use UserValidation;


	public function __construct() {

		parent::__construct();

		$this->validator = new Validation;

		return $this;
	}

	/**
	 * Implementing process action
	 */
	protected function process() {

		if ( $this->validate_user_data() ) {

			if( $this->save() ) {
				$this->setMessage( 'success', 'ACCOUNT_CREATED_SUCCESSFULLY' );
				
				$this->fired = true;
				return;
			}
			else {
				$this->setMessage( 'error', 'DATABASE_SAVE_ERROR' );

				$this->fired = false;
				return;
			}
		}
	}


	/**
	 * Validate user input
	 *
	 * @return bool
	 */
	public function validate_user_data() {
		if (
			$this->validate_username(
				$this->getInput( 'name', 'string' ), array(
					'is_empty' => false,
					'exists' => 'username',
					'match' => '/^[a-zA-Z0-9]{2,64}$/'
				)
			)

		    && $this->validate_email( 
				$this->getInput( 'email', 'email' ), array(
					'is_empty' => false,
					'repeat' => $this->getInput('email_repeat', 'email'),
					'exists' => 'email',
					'filter' => FILTER_VALIDATE_EMAIL
				)
			)

	        && $this->validate_password( 
				$this->getInput( 'password', 'password' ), array(
					'is_empty' => false,
					'repeat' => $this->getInput( 'password_repeat', 'password' ),
					'min' => 6
				)
			)
		)
		{
			$this->fired =  true;
			return true;
		}

		return false;
	}
	

	/**
	 * Saving user to the database
	 */
	private function save() {

		try {
			$user = User::create([
				'username' => $this->getInput( 'name' ),
				'password' => Auth::get_hash( $this->getInput( 'password' ) ),
				'email'    => $this->getInput( 'email' )
			]);

			$this->setUser( $user );

			return true;
		}
		catch(\Exception $e){

			return false;
		}
	}

	/**
	 * Implement redirection
	 */
	public function redirect() {

		if( $this->isFired() ) {
			Redirect::to( 'login/index' );
		}
		else {
			Redirect::to('register/index');
		}
	}
}