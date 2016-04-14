<?php

namespace Pgk\Options;

use Pgk\Model\User;

class Validation {

	use Flash;


	protected $valid = true;

	/**
	 * @param $value
	 * @param $field_name
	 * @param $rules
	 *
	 * @return bool
	 */
	public function check( $value, $field_name, $rules ) {

		foreach ( $rules as $rule => $data ) {

			if( is_callable( [ $this, $rule] ) ) {
				$this->valid = $this->{$rule}( $value, $data, $field_name );
			}

			if ( !$this->valid ) {
				$this->flash();
				break;
			}

		}

		return $this->valid;
	}

	/**
	 * Check if field is empty
	 *
	 * @param $value
	 *
	 * @return bool
	 */
	private function is_empty( $value, $data, $field_name ) {
		if( empty( trim( $value ) ) ) {
			$this->setMessage( 'error', "{$field_name}_FIELD_EMPTY" );
			return false;
		}

		return true;
	}

	/**
	 * Checks if this value already exists in database
	 *
	 * @param $value
	 * @param $field
	 *
	 * @return bool
	 */
	private function exists( $value, $field, $field_name ) {

		if( User::valueExists( $field, $value ) ) {
			$this->setMessage( 'error', "{$field_name}_ALREADY_TAKEN" );
			return false;
		}

		return true;
	}

	/**
	 * Check pattern
	 *
	 * @param $value
	 * @param $pattern
	 * @param $field_name
	 *
	 * @return bool
	 */
	private function match( $value, $pattern, $field_name ) {
		if (  !preg_match( $pattern, $value ) ) {
			$this->setMessage( 'error', "{$field_name}_DOES_NOT_FIT_PATTERN" );
			return false;
		}
		return true;
	}

	/**
	 * @param $value
	 * @param $repeat_value
	 * @param $field_name
	 *
	 * @return bool
	 */
	private function repeat( $value, $repeat_value, $field_name ) {
		if ( trim($value) !== trim( $repeat_value ) ) {
			$this->setMessage( 'error', "{$field_name}_REPEAT_WRONG" );
			return false;
		}

		return true;
	}

	/**
	 * @param $value
	 * @param $check_value
	 * @param $field_name
	 *
	 * @return bool
	 */
	private function same( $value, $check_value, $field_name ) {
		if ( trim($value) === trim( $check_value ) ) {
			$this->setMessage( 'error', "{$field_name}_SAME_AS_OLD_ONE" );
			return false;
		}

		return true;
	}

	/**
	 * @param $value
	 * @param $filter
	 * @param $field_value
	 *
	 * @return bool
	 */
	private function filter( $value, $filter, $field_value ) {
		if (!filter_var($value, $filter)) {
			$this->setMessage( 'error', "{$field_value}_DOES_NOT_FIT_PATTERN" );
			return false;
		}

		return true;
	}

	/**
	 * @param $value
	 * @param $length
	 * @param $field_value
	 *
	 * @return bool
	 */
	private function min( $value, $length, $field_value ) {
		if ( strlen( trim( $value ) ) < $length) {
			$this->setMessage( 'error', "{$field_value}_TOO_SHORT" );
			return false;
		}

		return true;
	}

	/**
	 * @param $value
	 * @param $length
	 * @param $field_value
	 *
	 * @return bool
	 */
	private function max( $value, $length, $field_value ) {
		if ( strlen( trim( $value ) ) > $length) {
			$this->setMessage( 'error', "{$field_value}_TOO_LONG" );
			return false;
		}

		return true;
	}


	private function expired( $date, $nill, $field_name ) {
		if ( new \DateTime() > new \DateTime( $date ) ) {
			$this->setMessage( 'error', "{$field_name}_EXPIRED" );
			return false;
		}

		return true;
	}
}