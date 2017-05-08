<?php

class ApiController
{
	protected $container;

	public function __construct($container)
	{
		$this->container = $container;
	}

	public function requestlogin($request, $response, $args)
	{
		return $this->invokeCommand($request->getParsedBody(), $response, 'RequestChallenge');
	}

	public function auth($request, $response, $args)
	{
		return $this->invokeCommand($request->getParsedBody(), $response, 'Auth');
	}

	public function getsecrets($request, $response, $args)
	{
		return $this->invokeCommand($request->getParsedBody(), $response, 'GetSecret');
	}

	public function putsecret($request, $response, $args)
	{
		$path = $request->getAttribute('path');
		$model = array('path' => $path);
		return $this->invokeCommand($model, $response, 'SetSecret');
	}

	private function invokeCommand($model, $response, $commandName)
	{
		$command = $this->container->get($commandName . 'Command');

		$command->run($model);
		$result = $command->getResult();

		return $response->withJson($result->data, $result->statusCode);
	}
}
