<?php

class RequestChallengeCommand extends Command {
	public function run($model) {
		if (is_null($model)) {
			$this->commandResult->statusCode = 400;
			$this->commandResult->data['message'] = 'Invalid content';
			return;
		}

		// TODO: check for valid key
		if (!isset($model['pgpid']) || is_null($model['pgpid'])) {
			$this->commandResult->statusCode = 422;
			$this->commandResult->data['message'] = 'PGP id invalid';
			return;
		}

		TeamSyncSession::$current->publicKey = $model['pgpid'];
		TeamSyncSession::$current->authenticated = FALSE;
		TeamSyncSession::$current->challenge = session_id();

		$this->commandResult->statusCode = 200;
		$this->commandResult->data['challenge'] = TeamSyncSession::$current->challenge;
		$this->commandResult->data['message'] = '';
	}
}
