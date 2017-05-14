<?php

class ApiController {
	protected $container;

	public function __construct($container) {
		$this->container = $container;
	}

	public function requestlogin($request, $response, $args) {
		return $this->invokeCommand($request, $response, 'RequestChallenge');
	}

	public function auth($request, $response, $args) {
		return $this->invokeCommand($request, $response, 'Auth');
	}

	public function getsecrets($request, $response, $args) {
		return $this->invokeCommand($request, $response, 'GetSecret');
	}

	public function putsecret($request, $response, $args) {
		return $this->invokeCommand($request, $response, 'SetSecret');
	}

	private function invokeCommand($request, $response, $commandName) {
		$json = json_decode($request->getBody(), TRUE);
		$model = ($json ? $json : array());

		$command = $this->container->get(($commandName . 'Command'));

		$command->run($model);
		$result = $command->getResult();

		return $response->withJson($result->data, $result->statusCode);
	}
}
