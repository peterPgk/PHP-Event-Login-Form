<?php
namespace Pgk\Contracts;

/**
 * Interface EventInterface
 *
 * @package Pgk\Contracts
 */
interface EventInterface{

	/**
	 * @param ObserverInterface $observer
	 * @param $type string - We can notify observers depends of how event is finished,
	 *                      e.g. if event finished positive, negative or all.
	 *
	 * @return EventInterface
	 */
	public function attach( ObserverInterface $observer, $type );

	/**
	 * @param ObserverInterface $observer
	 *
	 * @return EventInterface
	 */
	public function detach( ObserverInterface $observer );

	/**
	 * @return mixed
	 */
	public function notify();
}