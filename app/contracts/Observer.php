<?php

namespace Pgk\Contracts;


use Pgk\Utils\Flash;
use SplSubject;

abstract class Observer implements \SplObserver {

	use Flash;

	/**
	 * Receive update from subject
	 * @link http://php.net/manual/en/splobserver.update.php
	 *
	 * @param SplSubject $subject <p>
	 * The <b>SplSubject</b> notifying the observer of an update.
	 * </p>
	 *
	 * @return void
	 * @since 5.1.0
	 */
	abstract public function update( SplSubject $subject );

}