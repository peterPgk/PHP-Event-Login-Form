<?php

namespace Pgk\Observers;

use Pgk\Contracts\Event;
use Pgk\Contracts\Observer;
use SplSubject;

/**
 * Class UserLoginUnsuccessful
 *
 * Clear db when user change its data successfully
 *
 * Only for exercise
 *
 * @package Pgk\Observers
 */
class UserChangeDataSuccessfully extends Observer {

	/**
	 * Receive update from subject
	 * @link http://php.net/manual/en/splobserver.update.php
	 *
	 * @param Event $subject <p>
	 * The <b>SplSubject</b> notifying the observer of an update.
	 * </p>
	 *
	 * @return void
	 * @since 5.1.0
	 */
	public function update( Event $subject ) {
		$subject->getUser()->fill(['password_fails' => 0])->save();
	}
}