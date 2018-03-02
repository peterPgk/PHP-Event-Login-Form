<?php

namespace Pgk\Observers;


use Pgk\Contracts\Event;
use Pgk\Contracts\Observer;

/**
 * Class FlashMessageObserver
 * @package Pgk\Observers
 */
class FlashMessageObserver extends Observer {

	/**
	 * @param Event $subject
	 */
	public function update( Event $subject ) {
		$subject->flash();
}}