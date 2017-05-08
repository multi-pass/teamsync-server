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

// Load bootstrap script
require((dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'app'
		 .DIRECTORY_SEPARATOR.'bootstrap.php'));

// Configure autoloader
require(path(DIR_ROOT, 'vendor', 'autoload.php'));
spl_autoload_register(function ($classname) {
	require(path(DIR_ROOT, 'src', 'classes', ($classname . '.php')));
});


function get_settings($file) {
	if (is_file(path(DIR_CONFIG, $file))) {
		include(path(DIR_CONFIG, $file));
		return get_defined_vars();
	} else {
		return FALSE;
	}
}

// Instantiate the app
$app = new \Slim\App(array(
	'settings' => get_settings('config.php'),
	'parameters' => get_settings('parameters.php'),
));

// Set up dependencies
require(path(DIR_ROOT, 'src', 'dependencies.php'));

// Register middleware
require(path(DIR_ROOT, 'src', 'middleware.php'));

// Register routes
require(path(DIR_ROOT, 'src', 'routes.php'));

session_cache_limiter(false);
session_start();

// Run app
$app->run();
