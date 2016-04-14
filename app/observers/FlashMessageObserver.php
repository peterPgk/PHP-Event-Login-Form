<?php

namespace Pgk\Observers;


use Pgk\Contracts\Observer;
use SplSubject;

/**
 * Class FlashMessageObserver
 * @package Pgk\Observers
 */
class FlashMessageObserver extends Observer {

	/**
	 * @param SplSubject $subject
	 */
	public function update( SplSubject $subject ) {
		$subject->flash();
}}