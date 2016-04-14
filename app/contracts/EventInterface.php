<?php
namespace Pgk\Contracts;


interface EventInterface{

	public function attach(  );
	public function detach();
	public function notify();
}