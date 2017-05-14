<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class TeamSyncAuthOptional {
	public function __invoke(Request $request, Response $response, $next) {
		$this->restoreSession();
		$response = $this->innerInvoke($request, $response, $next);
		$this->storeSession();
		return $response;
	}

	private function restoreSession() {
		if (isset($_SESSION['TeamSyncSession'])) {
			TeamSyncSession::$current = $_SESSION['TeamSyncSession'];
		} else {
			TeamSyncSession::$current = new TeamSyncSession();
		}
	}

	private function storeSession() {
		$_SESSION['TeamSyncSession'] = TeamSyncSession::$current;
	}

	protected function innerInvoke(Request $request, Response $response, $next) {
		return $next($request, $response);
	}
}
