<?php

class RequestChallengeCommand extends Command
{
	public function run($model)
	{
		if ($model == null)
		{
			$this->commandResult->statusCode = 400;
			$this->commandResult->data['message'] = 'invalid content';
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

		TeamsyncSession::$current->name = $model['name'];
		TeamsyncSession::$current->publicKey = $model['publicKey'];
		TeamsyncSession::$current->authenticated = FALSE;
		TeamsyncSession::$current->challenge = session_id();
		
		$this->commandResult->statusCode = 200;
		$this->commandResult->data['challenge'] = TeamsyncSession::$current->challenge;
		$this->commandResult->data['message'] = '';
	}
}
