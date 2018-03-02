<?php
namespace Pgk\Controller;

use Pgk\Core\Auth;
use Pgk\Core\Controller;
use Pgk\Core\Request;
use Pgk\Core\Session;
use Pgk\Events\UserChangePassword;


/**
 * UserController
 * Controls everything that is user-related
 *
 */
class User extends Controller
{
    public function __construct( $container ) {

        parent::__construct( $container );
	    //Only available for logged users
        Auth::authenticated_user();
    }

    /**
     * Show user's profile
     */
    public function index() {
        $this->view->render('user/index', array(
            'username' => Session::getUser('username'),
            'email' => Session::getUser('email'),
        ));
    }

    /**
     * Show edit username page
     */
    public function edit_username() {
        $this->view->render('user/edit_username');
    }

    /**
     * Handles user name edit post action
     */
    public function post_edit_username() {
        if ( !Auth::isTokenValid() ) {
	        $this->_container->get( 'logout_event' )
		        ->fire( null, Session::getUser('user_id') );
        }

	    $this->_container->get( 'change_data_event' )
		    ->fire( Request::post( 'username' ), Session::getUser( 'user_id' ), 'username' );
    }

    /**
     * Show edit user email page
     */
    public function edit_email() {
        $this->view->render('user/edit_email');
    }

    /**
     * Handles edit user email POST action
     */
    public function post_edit_email() {
	    $this->_container->get( 'change_data_event' )
		    ->fire( Request::post( 'email' ), Session::getUser( 'user_id' ), 'email' );
    }


    /**
     * Password Change Page
     */
    public function edit_password() {
        $this->view->render('user/edit_password');
    }

    /**
     * Password Change Action
     */
    public function post_edit_password() {

	    $change_password = new UserChangePassword;
	    //TODO: Middleware for hashing passwords before put them to this event
//	    $change_event->setFilter( [ 'Pgk\Core\Auth::get_hash' => ['new', 'repeat', 'password']] );
	    $change_password->fire( Request::post( 'password' ), Session::getUser( 'user_id' ), 'password'  );
    }
}
