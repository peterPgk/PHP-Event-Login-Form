<?php

namespace Pgk\Events;


use Illuminate\Database\Eloquent\Collection;
use Pgk\Contracts\Event;
use Pgk\Core\Redirect;
use Pgk\Core\Session;
use Pgk\Model\User;
use Pgk\Utils\Validation;

/**
 * Class UserResetPasswordVerify
 *
 * Verification process when user
 * reset his password
 *
 * @package Pgk\Events
 */
class UserResetPasswordVerify extends Event {

	private $validator;

	/**
	 * @var Collection
	 */

	public function __construct() {

		$this->validator = new Validation;

		parent::__construct();
	}

	/**
	 * @return bool
	 */
	protected function process() {

		$this->setUser( User::byNameAndCode( $this->getInput( 'username' ), $this->getInput( 'code' ) ) );

		if( ! $this->hasUser() ) {
			$this->setMessage( 'error', 'PASSWORD_RESET_COMBINATION_FAIL' );

			$this->fired = false;

			return;
		}

		if( $this->validate( $this->getUser( 'password_reset_date' ) ) ) {

			Session::set( 'user_credential', $this->getUser()->toArray() );

			$this->fired = true;

			return;
		}

	}

	/**
	 * Validate reset code and time
	 */
	protected function validate( $date ) {

		return $this->validator->check(  $date, 'reset_date', [
			'expired' => true
		] );
	}
	

	/**
	 * 
	 */
	public function redirect() {

		if( $this->isFired() ) {
			Redirect::to( 'login/change_password' );
			exit();
		}

		Redirect::to( 'login/index' );
	}
}