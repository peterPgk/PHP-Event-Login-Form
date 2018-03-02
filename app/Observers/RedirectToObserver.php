<?php

namespace Pgk\Observers;


use Pgk\Contracts\Event;
use Pgk\Contracts\Observer;

class RedirectToObserver extends Observer {

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
		$subject->redirect();
}}