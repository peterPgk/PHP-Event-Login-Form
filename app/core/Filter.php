<?php

namespace Pgk\Core;

/**
 * Class Filter
 *
 * This is the place to put filters, usually methods that cleans, sorts and, well, filters stuff.
 */
class Filter
{
    /**
     * The XSS filter: This simply removes "code" from any data, used to prevent Cross-Site Scripting Attacks
     *
     * @param $value
     * @return mixed
     */
    public static function XSS(&$value)
    {
        if (is_string($value)) {
            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }

        return $value;
    }

	/**
	 * Wrapper over 'filter_var()'
	 *
	 * @param $value
	 * @param string $type
	 * @param bool $validate
	 *
	 * @return mixed
	 */
	public static function clean( $value, $type = 'string', $validate = true ) {
		switch ($type) {

			case 'email':
				$value = filter_var( $value, FILTER_SANITIZE_EMAIL);
				if( $validate ) {
					$value = filter_var( $value, FILTER_VALIDATE_EMAIL );
				}
				break;

			case 'password':
				$value = filter_var( $value, FILTER_SANITIZE_SPECIAL_CHARS);
				break;

			case 'url':
				$value = filter_var( $value, FILTER_SANITIZE_URL);
				if( $validate ) {
					$value = filter_var( $value, FILTER_VALIDATE_URL );
				}
				break;

			case 'string':
			default:
				$value = filter_var( $value, FILTER_SANITIZE_STRING);
				break;

		}
		return $value;
	}
}
