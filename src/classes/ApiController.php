<?php

class ApiController {
	protected $container;

	public function __construct($container) {
		$this->container = $container;
	}

	public function requestlogin($request, $response, $args) {
		return $this->invokeCommand($request, $response, $args, 'RequestChallenge');
	}

	public function auth($request, $response, $args) {
		return $this->invokeCommand($request, $response, $args, 'Auth');
	}

	public function getsecrets($request, $response, $args) {
		return $this->invokeCommand($request, $response, $args, 'GetSecrets');
	}

	public function getputsecret($request, $response, $args) {
		switch ($request->getMethod()) {
		case 'GET':
			return $this->invokeCommand($request, $response, $args, 'GetSecret');
		case 'PUT':
			return $this->invokeCommand($request, $response, $args, 'SetSecret');
		}
	}

	private function invokeCommand($request, $response, $args, $commandName) {
		$model = $args;
		$json = json_decode($request->getBody(), TRUE);
		if (is_array($json)) {
			$model = array_merge($model, $json);
		}

		$command = $this->container->get(($commandName . 'Command'));

		$command->run($model);
		$result = $command->getResult();

		return $response->withJson($result->data, $result->statusCode);
	}
}
