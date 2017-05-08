<?php
// DIC configuration

$container = $app->getContainer();

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
