<?php

namespace Pgk\Events;

use Pgk\Core\Auth;

/**
 * Class UserChangePassword
 *
 * User changes his password
 *
 * @package Pgk\Events
 *
 */
class UserChangePassword extends UserChangeData {

	protected function save( $new_value ) {
		$this->getUser()->{$this->field} = Auth::get_hash($new_value);

		return $this->getUser()->save();
	}

}