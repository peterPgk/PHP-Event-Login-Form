<?php

namespace Pgk\Options;

/**
 * Class UserValidation
 *
 * Validate some user fields
 *
 * @package Pgk\Options
 */
trait UserValidation  {

	/**
	 * @var Validation
	 */
	protected $validator;

	/**
	 * Validates the username
	 *
	 * @param $user_name
	 * @param array $rules
	 *
	 * @return bool
	 */
	protected function validate_username( $user_name, $rules = [] ) {

		return $this->validator->check(
			$user_name,
			'username',
			$rules
		);
	}

	/**
	 * Validates the email
	 *
	 * @param $email
	 *
	 * @param array $rules
	 *
	 * @return bool
	 */
	protected function validate_email( $email, $rules = []) {

		return $this->validator->check(
			$email,
			'email',
			$rules
		 );
	}

	/**
	 * Validates the password
	 *
	 * @param $password
	 *
	 * @param array $rules
	 *
	 * @return bool
	 */
	protected function validate_password( $password, $rules = [] ) {
		
		return $this->validator->check(
			$password,
			'password',
			$rules
		 );
	}

}