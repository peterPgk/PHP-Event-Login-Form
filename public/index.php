<?php

/**
 * This is because some deprecated and notice in php7 and above
 * TODO: Temporary
 */
error_reporting( E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

use Illuminate\Database\Capsule\Manager as EloquentManager;
use Pgk\Core\Application;
use Pgk\Core\Config;
use Pgk\Core\Messages;
use Pgk\Core\Session;
use Pgk\Utils\ArrayParser;

/**
 * Autoload
 */
require __DIR__ . '/../vendor/autoload.php';

/**
 * Load configurations
 */
$config = new Config( new ArrayParser() );
$config->load( __DIR__ . '/../app/options.php' );

/**
 * Messages 
 */
$messages = new Messages( new ArrayParser );
$messages->load( __DIR__ . '/../app/messages.php' );

/**
 * Eloquent
 */
$db = new EloquentManager;
$db->addConnection( Config::get( 'db' ) );
$db->setAsGlobal();
$db->bootEloquent();

Session::init();

// Instantiate the app
$app = new Application( compact( 'config', 'messages', 'db' ) );