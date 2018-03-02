<?php

namespace Pgk\Contracts;

/**
 * Interface ObserverInterface
 *
 * Basically we can use \SplObserver, but in this case
 * we want to type hinting our Event class
 *
 * @package Pgk\Contracts
 */
interface ObserverInterface {
	public function update( Event $subject );
}