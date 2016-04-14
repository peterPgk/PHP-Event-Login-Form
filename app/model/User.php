<?php
namespace Pgk\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * User Model
 * All user actions with database
 */
class User extends Model
{

	protected $primaryKey = 'user_id';

	protected $fillable = [
		'session_id',
		'username',
		'password',
		'email',
		'last_login',
		'password_reset_date',
		'password_reset_token'
	];

	/**
	 * Check if given value already exists in database
	 *
	 * @param $field
	 * @param $value
	 *
	 * @return bool
	 */
	public static function valueExists( $field, $value ) {
		return static::where( $field, $value )->get()->count() !== 0;
	}

	/**
	 * Finds a user through username or email
	 *
	 * @param $query \Illuminate\Database\Eloquent\Builder
	 * @param $name
	 *
	 * @return \Illuminate\Database\Eloquent\Model|null
	 */
	public function scopeByNameOrEmail( $query, $name ) {

		return $query->where( 'username', $name )->orWhere( 'email', $name )->first();

		
		
//		return $t;
	}


	/**
	 * Find a user with username and verification code
	 *
	 * @param $query \Illuminate\Database\Eloquent\Builder
	 * @param $name string
	 * @param $code string
	 *
	 * @return \Illuminate\Database\Eloquent\Model|null
	 */
	public function scopeByNameAndCode( $query, $name, $code ) {

		return $query->where( 'username', $name )->where( 'password_reset_token', $code )->first();
	}

}
