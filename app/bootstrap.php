<?php

function path() {
	return realpath(implode(DIRECTORY_SEPARATOR, func_get_args()));
}

// Path Variables (no trailing-slash for directories)
define('DIR_ROOT', dirname(dirname(__FILE__)));
define('DIR_CONFIG', path(DIR_ROOT, 'app', 'config'));
define('DIR_CLASSES', path(DIR_ROOT, 'src', 'classes'));
define('DIR_RBMODELS', path(DIR_ROOT, 'src', 'dbo'));

// load runtime configuration
require_once(path(DIR_CONFIG, 'runtime.php'));

// load base classes
require_once(path(DIR_ROOT, 'app', 'class.typehint.php'));
require_once(path(DIR_ROOT, 'app', 'class.Runtime.php'));
