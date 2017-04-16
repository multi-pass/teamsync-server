<?php

function path() {
	return realpath(implode(DIRECTORY_SEPARATOR, func_get_args()));
}

// Path Variables (no trailing-slash for directories)
define('ROOT_DIR', dirname(dirname(__FILE__)));
define('DIR_CONFIG', path(ROOT_DIR, 'app', 'config'));
define('DIR_RBMODELS', path(ROOT_DIR, 'src', 'dbo'));


require_once(path(DIR_CONFIG, 'runtime.php'));

// load base classes
require_once(path(ROOT_DIR, 'app', 'class.typehint.php'));
require_once(path(ROOT_DIR, 'app', 'class.Runtime.php'));
