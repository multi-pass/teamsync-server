<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class TeamsyncAuthOptional
{
	public function __invoke(Request $request, Response $response, $next)
	{
		$this->restoreSession();
		$response = $this->innerInvoke($request, $response, $next);
		$this->storeSession();
		return $response;
	}

	private function restoreSession()
	{
		if(isset($_SESSION['TeamsyncSession']))
		{
			TeamsyncSession::$current = $_SESSION['TeamsyncSession'];
		}
		else
		{
			TeamsyncSession::$current = new TeamsyncSession();
		}
	}

	private function storeSession()
	{
		$_SESSION['TeamsyncSession'] = TeamsyncSession::$current;
	}

	protected function innerInvoke(Request $request, Response $response, $next)
	{
		return $next($request, $response);
	}
}
