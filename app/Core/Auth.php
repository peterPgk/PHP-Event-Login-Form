<?php

namespace Pgk\Core;

class Auth
{
	/**
	 *
	 */
    public static function authenticated_user()
    {
        if (!Session::user_is_logged()) {
            Session::destroy();

	        Redirect::to('login/index');
        }
    }

	/**
	 * @param $password
	 *
	 * @return mixed
	 */
	public static function get_hash( $password ) {
		return password_hash( $password, PASSWORD_DEFAULT );
	}

	/**
	 * get CSRF token and generate a new one if expired
	 *
	 * @access public
	 * @static static method
	 * @return string
	 */
	public static function makeToken() {
		// token is valid for 1 day
		$max_time    = 60 * 60 * 24;
		$stored_time = Session::get('csrf_token_time');
		$csrf_token  = Session::get('csrf_token');

		if($max_time + $stored_time <= time() || empty($csrf_token)){
			Session::set('csrf_token', md5(uniqid(rand(), true)));
			Session::set('csrf_token_time', time());
		}

		return Session::get('csrf_token');
	}

	/**
	 * checks if CSRF token in session is same as in the form submitted
	 *
	 * @access public
	 * @static static method
	 * @return bool
	 */
	public static function isTokenValid() {
		$token = Request::post('csrf_token');
		return $token === Session::get('csrf_token') && !empty($token);
	}
}
