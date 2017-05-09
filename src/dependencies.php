<?php
// DIC configuration

$container = $app->getContainer();

use \RedBeanPHP\R as R;
$container['db'] = function ($container) {
	$dbconf = $container['parameters']['database'];

	$db_type = ($dbconf['type'] ? $dbconf['type'] : 'mysql');
	$db_host = ($dbconf['host'] ? $dbconf['host'] : '127.0.0.1');
	$db_name = ($dbconf['dbname'] ? $dbconf['dbname'] : 'teamsync');

	R::setup(($db_type.':host='.$db_host.'; dbname='.$db_name),
			 $dbconf['user'],
			 $dbconf['password']);

	// Load custom model formatter
	// RedBean_ModelHelper::setModelFormatter(new ModelFormatter);

	// Leave fluid mode
	R::freeze(TRUE);
};

$settings = $container->get('settings');
$template_path = $settings['renderer']['template_path'];
$container['renderer'] = new \Slim\Views\PhpRenderer($template_path);

$container['AuthCommand'] = function ($container)
{
	return new AuthCommand();
};
$container['RequestChallengeCommand'] = function ($container)
{
	return new RequestChallengeCommand();
};
$container['SetSecretCommand'] = function ($container)
{
	return new SetSecretCommand();
};
$container['GetSecretCommand'] = function ($container)
{
	return new GetSecretCommand();
};
