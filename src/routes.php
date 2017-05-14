<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response) {
	return $response->withStatus(200)->write('Visit https://github.engineering.zhaw.ch/PSIT3-FS17-ZH-5/teamsync-server');
});

$app->group('/auth', function() {
	$this->post('/requestlogin', ApiController::class.':requestlogin');
	$this->post('/login', ApiController::class.':auth');
})->add(new TeamSyncAuthOptional());

$app->group('/secrets', function() {
	$this->get('', ApiController::class.':getsecrets');
	$this->map(array('GET', 'PUT'), '{path:/.+}', ApiController::class.':getputsecret');
})->add(new TeamSyncAuthRequired());
