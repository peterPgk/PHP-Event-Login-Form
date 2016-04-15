<?php
namespace Pgk\Controller;

use Pgk\Core\Controller;
use Pgk\Core\Redirect;
use Pgk\Core\Request;
use Pgk\Core\Session;
use Pgk\Events\UserRegister;
use Pgk\Observers\MailNewUser;


/**
 * Class Register
 *
 * Handle register new user
 *
 * @package Pgk\Controller
 */
class Register extends Controller
{

    public function __construct( $container ) {
        parent::__construct( $container );
    }

    /**
     * Show the registration form
     */
    public function index() {
        if ( Session::user_is_logged() ) {
            Redirect::home();
        } else {
            $this->view->render('register/index');
        }
    }

    /**
     * Handles register post action
     */
    public function register() {
	    
	    (new UserRegister())
		    ->attach( new MailNewUser, 'successful' )
		    ->fire( Request::post( 'user' ) );

    }
}
