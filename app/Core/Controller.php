<?php
namespace Pgk\Core;

/**
 * Class Controller
 *
 * Base controller
 *
 * @package Pgk\Core
 */
abstract class Controller
{
    /**
     * @var View view The view object
     */
    public $view;

	/**
	 * @var Container
	 */
	protected $_container;

	/**
	 * Controller constructor.
	 *
	 * @param $container
	 */
    function __construct( $container )
    {
	    $this->_container = $container;
        $this->view = new View();

        if ( Session::check_concurrency() ) {
	        $this->_container->get( 'logout_event' )->fire( null, Session::getUser('user_id') );
        }
    }
}
