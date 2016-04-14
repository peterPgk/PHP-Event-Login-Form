<?php

namespace Pgk\Events;


use Illuminate\Database\Eloquent\Collection;
use Pgk\Contracts\Event;
use Pgk\Core\Redirect;
use Pgk\Model\User;
use Pgk\Observers\MailPasswordReset;
use Pgk\Utils\UserValidation;
use Pgk\Utils\Validation;

/**
 * Class UserResetPassword
 *
 * When user reset his password
 *
 * @package Pgk\Events
 */
class UserResetPassword extends Event {

	use UserValidation;

	/**
	 * @var Collection
	 */

	public function __construct() {

		parent::__construct();

		$this->validator = new Validation;

		/**
		 * This is not the correct way to send verification message.
		 * Since this verification message is important part of password reset process,
		 * the right way is to send it from 'process' method.
		 * But because the purpose here is to use Events, I will use observer for now.
		 *
		 * But the right way is to move this part in the process itself
		 */
		$this->attach( new MailPasswordReset );
	}

	/**
	 * @return bool
	 */
	protected function process() {

		if( $this->validate( $this->getInput( 'username' ) ) ) {

			/**
			 * Fetch user from database
			 */
			$this->setUser( User::byNameOrEmail( $this->getInput( 'username' ) ) );

			if( ! $this->hasUser() ) {

				$this->setMessage( 'error', 'USER_DOES_NOT_EXIST' );

				$this->fired = false;

				return;
			}

			if( $this->save() ) {

				$this->setMessage( 'success', 'PASSWORD_RESET_MAIL_SUCCESSFUL' );

				$this->fired = true;

				return;
			}

		}

	}

	/**
	 * @param $name
	 *
	 * @return bool
	 */
	protected function validate( $name ) {
		return $this->validate_username(
			$name, array(
				'is_empty' => false,
			)
		);
	}

	/**
	 * @return bool
	 */
	protected function save() {
		//reset token
		$password_reset_token = sha1( uniqid( mt_rand(), true ) );
		//token will be valid through this date
		$password_reset_date = (new \DateTime('now'))->modify('+1day')->format( 'Y-m-d H:i:s' );

		return $this->getUser()->fill( compact( 'password_reset_token', 'password_reset_date' ) )->save();
	}

	/**
	 *
	 */
	public function redirect() {
		Redirect::to( 'login/index' );
	}
}