<?php

namespace Pgk\Core;

use Pgk\Controller\Error;
use Pgk\Events\UserChangeData;
use Pgk\Events\UserLogout;
use Pgk\Observers\MailUserChangeData;

/**
 * Class Application
 *
 * The App :)
 *
 */
class Application
{
	/**
	 * @var array|Container
	 */
	private $_container;

	/** @var array URL parameters, will be passed to used controller-method */
	private $parameters = array();

	/** @var string */
	private $controller;

	/** @var string  */
	private $action;

	/**
	 * Start the application,
	 * analyze URL elements,
	 * call according controller/method
	 * or relocate to fallback location
	 *
	 * @param $initial_options
	 *
	 */
	public function __construct( $initial_options ) {
		
		$this->_container = new Container( $initial_options );

		$this->controller = Config::get( 'default.controller' );
		$this->action     = Config::get( 'default.action' );

		/**
		 *
		 * Push some events to the container
		 */
		$this->_container->set('logout_event', new UserLogout);

		$user_change_data_event = new UserChangeData;
		$user_change_data_event->attach(new MailUserChangeData);

		$this->_container->set( 'change_data_event', $user_change_data_event );

		/**
		 * Extract actions
		 */
		$this->parse_url();

		//Check if this is ajax call, and if so, we prepare post data to the next step
		Ajax::handle();
		
		$class = '\Pgk\Controller\\' . ucfirst($this->controller);
		if ( class_exists( $class, true ) ) {

			// load this file and create this controller
			$controller = new $class( $this->_container );

			if ( method_exists( $controller, $this->action ) ) {
				call_user_func_array( array( $controller, $this->action ), $this->parameters );
				exit();
			}
		}

		$controller = new Error( $this->_container );
		$controller->error404();
	}

	/**
	 * Get and split the URL, extract controller and
	 * action to instantiate
	 */
	private function parse_url() {
		if ($url = Request::get('url')) {

			// split URL
			$url = filter_var( trim( $url, '/' ), FILTER_SANITIZE_URL );

			list( $this->controller, $this->action, $this->parameters[0], $this->parameters[1] ) = explode( '/', $url );
		}

		$this->controller ?: Config::get( 'default.controller' );
		$this->action     ?: Config::get( 'default.action' );
	}
}
