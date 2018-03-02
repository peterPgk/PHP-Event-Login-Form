<?php

namespace Pgk\Utils;


use Pgk\Contracts\ParserInterface;

class JsonParser implements ParserInterface {

	public function parse( $file ) {
		return json_encode(file_get_contents( $file ), true);
	}
}