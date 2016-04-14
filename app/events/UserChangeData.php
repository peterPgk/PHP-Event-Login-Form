<?php

namespace Pgk\Events;

use Pgk\Core\Redirect;
use Pgk\Core\Session;
use Pgk\Model\User;
use Pgk\Options\UserValidation;
use Pgk\Options\Validation;


/**
 * Class UserChangeData
 *
 * User changes his credentials
 *
 * @package Pgk\Events
 */
class UserChangeData extends Event {

	use UserValidation;

	/**
	 * UserLoginEvent constructor.
	 */
	public function __construct() {

		$this->validator = new Validation;

		parent::__construct();
	}

	/**
	 * Process user input
	 */
	protected function process() {

		$this->setUser( User::find( $this->user_id ) );
		
		/**
		 *
		 */
		if( ! $this->hasUser() ) {
			$this->setMessage( 'error', 'USER_DOES_NOT_EXIST' );

			$this->fired = false;

			return;
		}

		/**
		 * Check passwords
		 */
		if( ! password_verify( $this->getInput('password'), $this->getUser('password') ) ) {
			$this->setMessage( 'error', 'PASSWORD_CURRENT_INCORRECT' );

			$this->fired = false;

			return;
		}

		$new_value = $this->getInput('new');
		$repeat_value = $this->getInput('repeat');

		if( $this->validate( $new_value, $repeat_value ) ) {
			if( $this->save( $new_value ) ) {
				//TODO
				Session::setUser( $this->field, $new_value );

				$this->setMessage( 'success', "{$this->field}_CHANGE_SUCCESSFUL" );

				$this->fired = true;

				return;
			}
		}
	}

	/**
	 * @param $new_value
	 * @param $repeat_value
	 *
	 * @return bool
	 */
	private function validate( $new_value, $repeat_value ) {

		switch ($this->field) {
			case 'email':
				return $this->validate_email(
					$new_value, array(
						'is_empty' => false,
						'repeat' => $repeat_value,
						'same' => $this->getUser( 'email' ),
						'exists' => 'email',
						'filter' => FILTER_VALIDATE_EMAIL,
					)
				);
				break;

			case 'username':
				return $this->validate_username(
					$new_value, array(
						'is_empty' => false,
						'repeat' => $repeat_value,
						'same' => $this->getUser( 'username' ),
						'exists' => 'username',
						'match' => '/^[a-zA-Z0-9]{2,64}$/',
					)
				);
				break;

			case 'password':
				return $this->validate_password(
					$new_value, array(
						'is_empty' => false,
						'repeat' => $repeat_value,
						'min' => 6,
					)
				);
				break;

			default:
				return false;
				break;

		}
	}


	/**
	 * Change the value
	 *
	 * @param $new_value
	 *
	 * @return bool
	 */
	protected function save( $new_value ) {

		$user = $this->getUser();

		$user->{$this->field} = $new_value;

		return $user->save();
	}

	/**
	 *
	 */
	public function redirect() {
		Redirect::to('user/edit_'. $this->field );
	}
}