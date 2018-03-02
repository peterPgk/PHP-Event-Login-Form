<?php

namespace Pgk\Events;


use Pgk\Contracts\Event;
use Pgk\Core\Auth;
use Pgk\Core\Redirect;
use Pgk\Core\Session;
use Pgk\Model\User;
use Pgk\Utils\UserValidation;
use Pgk\Utils\Validation;

/**
 * Class UserResetPasswordChange
 *
 * Changes user password after follow
 * reset password procedure, after verification
 * process is passed
 *
 * @package Pgk\Events
 */
class UserResetPasswordChange extends Event {

	use UserValidation;


	public function __construct() {

		parent::__construct();

		$this->validator = new Validation;

		return $this;
	}

	/**
	 * @return bool
	 */
	protected function process() {
		
		if( Session::user_is_valid() ) {

			//TODO: Get user from the Session::get('user_credential')
			$this->setUser( User::find( $this->getUserId() ) );

			if( ! $this->hasUser() ) {
				$this->setMessage( 'error', 'USER_DOES_NOT_EXIST' );

				$this->fired = false;

				return;
			}

			if( $this->validate( $this->getInput( 'new' ), $this->getInput( 'repeat' ) ) ) {

				if( $this->save() ) {

					Session::clear();

					$this->setMessage( 'success', 'PASSWORD_CHANGE_SUCCESSFUL' );

					$this->fired = true;

					return;
				}

				$this->setMessage( 'error', 'PASSWORD_CHANGE_SUCCESSFUL' );
			}
		}
		else {
			$this->setMessage( 'error', 'PASSWORD_VERIFICATION_PROCESS_FAILED' );
		}
	}

	/**
	 * Validate reset code and time
	 */
	protected function validate( $new, $repeated ) {

		return $this->validate_password(
			$new, array(
				'is_empty' => false,
				'repeat' => $repeated,
				'min' => 6,
			)
		);
	}

	/**
	 * @return bool
	 */
	protected function save() {

		return $this->getUser()->fill( [
			'password' => Auth::get_hash( $this->getInput( 'new' ) ),
			'password_reset_date' => null,
			'password_reset_token' => null
		] )->save();
	}
	

	/**
	 * 
	 */
	public function redirect() {
		Redirect::to( 'login/index' );
	}
}