<?php

return [

	'default' => [
		'controller' => 'index',
		'action' => 'index'
	],
	'view' => [

	],
	'db' => [
		'driver'    => 'mysql',
		'host'      => '127.0.0.1',
		'database'  => 'event_login',
		'username'  => 'root',
		'password'  => '',
		'port'      => '3306',
		'charset'   => 'utf8',
	],
	'email' => [
		'mailer' => 'phpmailer',
		'smtp' => true,
		'smtp_host' => 'smtp.gmail.com',
		'smtp_auth' => true,
		'smtp_username' => 'peter.pgk@gmail.com',
		'smtp_password' => 'Amg*#885547-com',
		'smtp_port' => 465,
		'smtp_encryption' => 'ssl',

		'email_from' => 'peter.pgk@gmail.com',
		'name_from' => 'SAVEA ADMIN',
	],
	/**
	 * Configuration for: Base URL
	*/
	'url' => 'http://' . $_SERVER['HTTP_HOST'] . str_replace('public', '', dirname($_SERVER['SCRIPT_NAME'])),
	'template_path' => __DIR__ . '/view/',
	'controller_path' => __DIR__ . '/controller/'
];