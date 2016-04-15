<?php
namespace Pgk\Controller;

use Pgk\Core\Auth;
use Pgk\Core\Controller;
use Pgk\Core\Redirect;
use Pgk\Core\Request;
use Pgk\Core\Session;
use Pgk\Events\UserResetPassword;
use Pgk\Events\UserLogin;
use Pgk\Events\UserResetPasswordChange;
use Pgk\Events\UserResetPasswordVerify;

/**
 * LoginController
 * 
 * Controls everything that is authentication-related
 */
class Login extends Controller
{

    public function __construct( $container ) {
        parent::__construct( $container );
    }

    /**
     * Prints login form
     */
    public function index() {
        // if user is logged in redirect to main-page,
        if ( Session::user_is_logged() ) {
            Redirect::home();
        }
        else {
	        //if not show the login page
            $this->view->render('login/index');
        }
    }

    /**
     * Handles login action
     */
    public function login() {

        // check if csrf token is valid
        if (!Auth::isTokenValid()) {
	        $this->_container->get( 'logout_event' )
		        ->fire( null, Session::getUser('user_id') );
        }

	    /**
	     * Attach observers to login action
	     */
	    (new UserLogin)
		    ->fire( Request::post( 'user' ) );
    }

    /**
     * The logout action
     */
    public function logout() {
	    $this->_container->get( 'logout_event' )
		    ->fire( null, Session::getUser( 'user_id' ) );
    }

    /**
     * Shows the password-reset page
     */
    public function reset() {
        $this->view->render('login/reset');
    }

    /**
     * Handles password reset post action
     */
    public function post_reset() {
	    (new UserResetPassword)
		    ->fire( Request::post('reset'), '', 'username' );
    }

    /**
     * Verify the verification token from password reset form
     *
     * @param string $username username
     * @param string $code verification token
     */
    public function handle_reset($code, $username) {
	    (new UserResetPasswordVerify)
		    ->fire( compact( 'username', 'code' ) );
    }

	/**
	 * Here the user can change his password after verification
	 * process is
	 */
	public function change_password() {
		$this->view->render('login/change_password');
	}

    /**
     * Set the new password
     */
    public function post_change_password() {
		(new UserResetPasswordChange)
			->fire( Request::post( 'password' ), $_SESSION['user_credential']['user_id'], 'password' );
    }
}
