<?php
if (PHP_SAPI === 'cli-server') {
	// To help the built-in PHP dev server, check if the request was actually
	// for something which should probably be served as a static file
	$url  = parse_url($_SERVER['REQUEST_URI']);
	$file = (__DIR__ . $url['path']);
	if (is_file($file)) {
		return FALSE;
	}
}

require((dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'app'
		 .DIRECTORY_SEPARATOR.'bootstrap.php'));
require(path(ROOT_DIR, 'vendor', 'autoload.php'));

session_start();

// Instantiate the app
$settings = require(path(ROOT_DIR, 'src', 'settings.php'));
$app = new \Slim\App($settings);

// Set up dependencies
require(path(ROOT_DIR, 'src', 'dependencies.php'));

// Register middleware
require(path(ROOT_DIR, 'src', 'middleware.php'));

// Register routes
require(path(ROOT_DIR, 'src', 'routes.php'));

// Run app
$app->run();
