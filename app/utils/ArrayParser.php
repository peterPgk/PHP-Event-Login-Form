<?php

namespace Pgk\Utils;


use Pgk\Contracts\ParserInterface;

class ArrayParser implements ParserInterface {

	public function parse( $file ) {
		return require $file;
	}
}