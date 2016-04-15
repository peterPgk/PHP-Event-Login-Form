<?php

namespace Pgk\Utils;


use Pgk\Contracts\ParserInterface;

/**
 * Trait Parser
 *
 * Basic implementation of strategy pattern
 *
 * @package Pgk\Utils
 */
trait Parser {
	private static $parsed;
	/**
	 * @var ParserInterface
	 */
	protected $parser;

	/**
	 * Config constructor.
	 *
	 * @param ParserInterface $parser
	 */
	public function __construct( ParserInterface $parser ) {
		$this->setParser($parser);
	}

	/**
	 * @param $path
	 *
	 * @return string
	 */
	public static function get( $path ) {
		return static::_get( $path );
	}

	/**
	 * @param null $path
	 *
	 * @return string
	 */
	public function _get( $path = null ) {

		if( $path ) {
			$config = self::$parsed;
			$path = explode('.', $path);

			foreach ( $path as $bit ) {
				if( isset($config[$bit]) ) {
					$config = $config[$bit];
				}
			}

			return $config;
		}

		return '';
	}

	/**
	 * @param ParserInterface $parser
	 */
	public function setParser( ParserInterface $parser ) {
		$this->parser = $parser;
	}

	/**
	 * @param $file
	 */
	public function load( $file ) {
		if ( file_exists( realpath( $file) ) ){
			self::$parsed = $this->parser->parse( $file );
		}
	}


	/**
	 * Because we have many get:: methods
	 * @param $a
	 * @param $b
	 *
	 * @return string
	 */
	public static function __callStatic( $a, $b ) {
		$method = '_' . $a;

		if ( is_callable( array('static', $method) ) ) {
			return self::$method( reset($b) );
		}

		return '';
	}
}