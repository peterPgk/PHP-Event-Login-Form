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
		'smtp_host' => 'smtp_host',
		'smtp_auth' => true,
		'smtp_username' => 'your@user.name',
		'smtp_password' => 'your_password',
		'smtp_port' => 465,
		'smtp_encryption' => 'ssl',

		'email_from' => 'your@email.from',
		'name_from' => 'your_name_from',
	],
	/**
	 * Configuration for: Base URL
	*/
	'url' => 'http://' . $_SERVER['HTTP_HOST'] . str_replace('public', '', dirname($_SERVER['SCRIPT_NAME'])),
	'template_path' => __DIR__ . '/view/',
	'controller_path' => __DIR__ . '/controller/'
];