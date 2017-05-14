<?php

class RequestChallengeCommand extends Command {
	public function run($model) {
		if (is_null($model)) {
			$this->commandResult->statusCode = 400;
			$this->commandResult->data['message'] = 'Invalid content';
			return;
		}

		if ($model['name'] == null)
		{
			$this->commandResult->statusCode = 422;
			$this->commandResult->data['message'] = 'name missing/empty';
			return;
		}
		if ($model['publicKey'] == null) //ToDo check for valid key
		{
			$this->commandResult->statusCode = 422;
			$this->commandResult->data['message'] = 'public key invalid';
			return;
		}

		TeamSyncSession::$current->publicKey = $model['pgpid'];
		TeamSyncSession::$current->authenticated = FALSE;
		TeamSyncSession::$current->challenge = session_id();
		TeamsyncSession::$current->name = $model['name'];
		
		$this->commandResult->statusCode = 200;
		$this->commandResult->data['challenge'] = TeamSyncSession::$current->challenge;
		$this->commandResult->data['message'] = '';
	}
}
