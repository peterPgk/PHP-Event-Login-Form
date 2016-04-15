<?php

namespace Pgk\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Pgk\Observers\FlashMessageObserver;
use Pgk\Observers\RedirectToObserver;
use Pgk\Utils\Flash;
use Pgk\Utils\Input;

/**
 * Class Event
 *
 * Base class
 *
 * @package Pgk\Events
 */
abstract class Event implements EventInterface {

	/**
	 * Flash messages
	 */
	use Flash;
	/**
	 * Deals with the user input
	 */
	use Input;


	/**
	 * Registered observers
	 *
	 * @var \SplObjectStorage
	 */
	protected $storage;

	/**
	 * If we fetch user from DB
	 *
	 * @var \Illuminate\Database\Eloquent\Model
	 */
	private $user;

	/**
	 * We can apply some filters over data, before
	 * it can be processed
	 *
	 * @var array
	 */
	protected $filter;

	/**
	 * Is all events are finished well
	 *
	 * @var bool
	 */
	protected $fired = false;

	/**
	 * Keep track for user, we deal with
	 * @var int
	 */
	protected $user_id;
	/**
	 * keep track for filed, we deal with
	 * @var string
	 */
	protected $field;

	/**
	 * Event constructor.
	 */
	public function __construct(  ) {

		$this->storage = new \SplObjectStorage();

		/**
		 * Some cleanup
		 */
		$this->clearMessages();

		return $this;
	}

	/**
	 * Do what needs to be done
	 *
	 * @return mixed
	 */
	abstract protected function process();

	/**
	 * @return mixed
	 */
	abstract public function redirect();


	/**
	 * Attach an SplObserver.
	 * We can filter and fire only proper observers,
	 * depending whether event is finished positive or negative
	 *
	 * @link http://php.net/manual/en/splsubject.attach.php
	 *
	 * @param ObserverInterface $observer
	 * @param string $type - Must be one of the ['successful', 'unsuccessful', 'all']
	 *                      This filters which observer to fire
	 *
	 * @return Event
	 *
	 * The <b>SplObserver</b> to attach.
	 *
	 *
	 * @since 5.1.0
	 *
	 */
	public function attach( ObserverInterface $observer, $type = 'all' ) {
		$this->storage->attach( $observer, $type );
		
		return $this;
	}

	/**
	 * Detach an observer
	 * @link http://php.net/manual/en/splsubject.detach.php
	 *
	 * @param ObserverInterface $observer <p>
	 * The <b>SplObserver</b> to detach.
	 * </p>
	 *
	 * @return Event
	 * @since 5.1.0
	 */
	public function detach( ObserverInterface $observer ) {
		if( $this->storage->contains($observer) ) {
			$this->storage->detach($observer);
		}
		
		return $this;
	}

	/**
	 * Notify an observer
	 * Depending how event is finished,
	 *
	 *
	 * @link http://php.net/manual/en/splsubject.notify.php
	 * @return void
	 * @since 5.1.0
	 */
	public function notify() {

		if($this->storage->count() !== 0 ) {

			foreach ( $this->storage as $observer ) {

				switch ( [$this->storage[$observer], $this->isFired()] ) {

					case ( ['successful', true] ):
						$observer->update( $this );
						break;

					case ( ['unsuccessful', false] ):
						$observer->update( $this );
						break;

					case ['all', true]:
					case ['all', false]:
						$observer->update( $this );
						break;

					default:
						continue;
						break;
				}

			}
		}
	}


	/**
	 * @param null $user_input
	 * @param string $user_id
	 * @param string $field
	 */
	final public function fire( $user_input = null, $user_id = '', $field = '' ) {

		$this->user_id = $user_id;
		$this->field = $field;

		/**
		 * Save input if we have one
		 */
		$this->setInput( $user_input );

		/**
		 * Apply filters if we have
		 */
		$this->applyFilters();

		/**
		 * Do the job
		 */
		$this->process();

		/**
		 * We will fire these observers on each event
		 */
		$this->attach( new FlashMessageObserver );
		$this->attach( new RedirectToObserver );

		/**
		 * Make aware all concerned
		 */
		$this->notify();
	}

	/**
	 * If there have declared filters,
	 * apply them to input data
	 *
	 * TODO
	 *
	 */
	private function applyFilters() {
		if( count( $this->filter ) > 0 ) {
			foreach ( $this->filter as $filter => &$data ) {
				if ( is_callable( $filter ) ) {
					if ( is_array( $data ) ) {
						
						$data = array_map( [$this, 'getInput'], $data );
//						array_walk( $data, [$this, 'getInput'] );
						$data = array_map( $filter, $data );
					}
					else {
						$filter( $data );
					}
				}
			}
		}
	}


	/****************
	 *  API
	 */

	/**
	 * User getter
	 *
	 * @param string $key
	 *
	 * @return null|string|Model
	 */
	public function getUser( $key = '#' ) {

		if ( !property_exists( $this, 'user' ) || ! $this->hasUser() ) {
			return null;
		}

		if( $this->user->{$key} ) {
			return $this->user->{$key};
		}

		return $this->user;
	}

	/**
	 * @param Model|Builder|null $user
	 */
	protected function setUser( $user ) {
		$this->user = $user;
	}

	/**
	 * Check if we successfully find a user
	 *
	 * @return bool
	 */
	public function hasUser() {
		if( $this->user instanceof Builder ) {
			return (bool) $this->user->count() > 0;
		}

		if( $this->user instanceof Model ) {
			return (bool) $this->user->count() > 0;
		}

		return ! is_null( $this->user );
	}

	/**
	 * Is the event finished successfully
	 *
	 * @return boolean
	 */
	final public function isFired() {
		return $this->fired;
	}

	/**
	 * Set actions to apply over input data
	 *
	 * @param array $action
	 */
	public function setFilter( Array $action ) {
		$this->filter[ key($action) ] = reset($action);
	}

	/**
	 * @return int
	 */
	public function getUserId() {
		return $this->user_id;
	}

	/**
	 * Field name
	 *
	 * @return string
	 */
	public function getField() {
		return $this->field;
	}
}