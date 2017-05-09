<?php
// DIC configuration

$container = $app->getContainer();

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
