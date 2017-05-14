<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class TeamSyncAuthRequired extends TeamsyncAuthOptional {
	protected function innerInvoke(Request $request, Response $response, $next) {
		if (TeamSyncSession::$current->authenticated) {
			return $next($request, $response);
		}
		return $response->withStatus(401, 'Authentication Required');
	}
}
