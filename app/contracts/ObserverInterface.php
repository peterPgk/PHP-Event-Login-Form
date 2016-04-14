<?php

namespace Pgk\Contracts;


interface ObserverInterface {
	public function update( EventInterface $subject );
}