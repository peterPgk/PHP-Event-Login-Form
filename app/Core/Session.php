<?php
namespace Pgk\Core;


use Pgk\Model\User;

/**
 * Session class
 *
 * handles the session stuff. creates session when no one exists, sets and gets values,
 */
class Session
{
    /**
     * starts the session
     */
    public static function init()
    {
        // if no session exist, start the session
	    if (session_status() == PHP_SESSION_NONE) {
		    session_start();
	    }
    }


    /**
     * gets/returns the value of a specific key of the session
     *
     * @param mixed $key
     * @return mixed the key's value or nothing //TODO: pass default value to return
     */
    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            $value = $_SESSION[$key];
        	return Filter::XSS($value);
        }

	    return false;
    }

	/**
	 * @param $key
	 *
	 * @return bool|mixed
	 */
	public static function getUser( $key = '' ) {
		if( isset( $_SESSION['userdata'] ) ) {

			if ( isset( $_SESSION['userdata'][$key] ) ) {
				$value = $_SESSION['userdata'][$key];
				return Filter::XSS($value);
			}

			return $_SESSION['userdata'];
		}

		return false;
	}

	/**
	 * sets a specific value to a specific key of the session
	 *
	 * @param mixed $key key
	 * @param mixed $value value
	 */
	public static function set($key, $value) {
		$_SESSION[$key] = $value;
	}

	/**
	 * @param $key
	 * @param $value
	 */
	public static function setUser( $key, $value ) {
		if ( isset( $_SESSION['userdata'] ) ) {
			$_SESSION['userdata'][$key] = $value;
		}
	}

    /**
     * adds a value as a new array element to the key.
     *
     * @param mixed $key
     * @param mixed $value
     */
    public static function add($key, $value) {
        $_SESSION[$key][] = $value;
    }

    /**
     * deletes the session (= logs the user out)
     */
    public static function destroy() {
        session_destroy();
    }

	/**
	 * Clear session data
	 */
	public static function clear() {
		// remove old and regenerate session ID.
		// It's important to regenerate session on sensitive actions,
		session_regenerate_id(true);
		$_SESSION = array();
	}

    /**
     * checks for session concurrency
     *
     * @access public
     * @static static method
     * @return bool
     * @see http://stackoverflow.com/questions/6126285/php-stop-concurrent-user-logins
     */
    public static function has_concurrent_user() {

        $session_id = session_id();
        $user_id    = static::getUser('user_id');

        if( isset($user_id) && isset($session_id)) {
	        $user_session_id = User::find( $user_id )->session_id;
            return $session_id !== $user_session_id;
        }

        return true;
    }

	/**
	 * Detects if there is another user logged in with the same current user credentials,
	 * If so, then logout.
	 */
	public static function check_concurrency(){
		return ( static::user_is_logged() && static::has_concurrent_user() );
	}

    /**
     * Checks if the user is logged in or not
     *
     * @return bool user's login status
     */
    public static function user_is_logged() {
        return isset( $_SESSION['userdata'] ) && count($_SESSION['userdata']) > 0;
    }

	/**
	 * @return bool
	 */
	public static function user_is_valid() {
		if( isset( $_SESSION['user_credential'] ) && count($_SESSION['user_credential']) > 0 ) {
			
			return ! is_null(User::byNameAndCode( $_SESSION['user_credential']['username'], $_SESSION['user_credential']['password_reset_token'] ));
		}
		
		return false;
	}
}
