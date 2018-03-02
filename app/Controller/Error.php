<?php
namespace Pgk\Controller;

use Pgk\Core\Controller;

/**
 * Class Error
 * Must handle errors from here
 *
 * TODO
 */
class Error extends Controller {
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct( $container ) {
        parent::__construct( $container );
    }

	/**
	 * Render 404 page
	 */
    public function error404() {
        header('HTTP/1.0 404 Not Found', true, 404);
        $this->view->render('error/404');
    }
}
