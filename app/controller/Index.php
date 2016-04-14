<?php
namespace Pgk\Controller;

use Pgk\Core\Controller;
use Pgk\Core\Redirect;
use Pgk\Core\Session;

/**
 * Class Index
 * 
 * @package Pgk\Controller
 */
class Index extends Controller
{
    public function __construct( $container ) {
        parent::__construct( $container );
    }

    /**
     * Default action
     */
    public function index() {

	    if (! Session::user_is_logged() ) {
		    Redirect::to('login/index');
	    }
        $this->view->render('index/index');
    }
}
