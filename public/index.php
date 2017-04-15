<?php
if (PHP_SAPI === 'cli-server') {
	// To help the built-in PHP dev server, check if the request was actually for
	// something which should probably be served as a static file
	$url  = parse_url($_SERVER['REQUEST_URI']);
	$file = (__DIR__ . $url['path']);
	if (is_file($file)) {
		return FALSE;
	}
}

define('BASE_PATH', dirname(__DIR__));

require(BASE_PATH . '/vendor/autoload.php');

session_start();

// Instantiate the app
$settings = require(BASE_PATH . '/src/settings.php');
$app = new \Slim\App($settings);

// Set up dependencies
require(BASE_PATH . '/src/dependencies.php');

// Register middleware
require(BASE_PATH . '/src/middleware.php');

// Register routes
require(BASE_PATH . '/src/routes.php');

// Run app
$app->run();
