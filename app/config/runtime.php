<?php

define('DEBUG_MODE', TRUE);

if (DEBUG_MODE) {
	// development settings
	ini_set('display_errors', TRUE);
	error_reporting(E_ALL);
} else {
	// production settings
	ini_set('display_errors', FALSE);
	error_reporting(0);
}

date_default_timezone_set('UTC');
