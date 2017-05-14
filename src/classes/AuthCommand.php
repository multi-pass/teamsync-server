<?php

class AuthCommand extends Command
{
	public function run($model)
	{
		if (TeamsyncSession::$current->challenge == null)
		{
			$this->commandResult->statusCode = 422;
			$this->commandResult->data['message'] = 'invalid content';
			return;
		}

		if ($model == null)
		{
			$this->commandResult->statusCode = 400;
			$this->commandResult->data['message'] = 'invalid content';
			return;
		}

		if ($model['challenge'] == null)
		{
			$this->commandResult->statusCode = 422;
			$this->commandResult->data['message'] = 'challenge missing/empty';
			return;
		}

		//ToDo decode challenge
/*		if ($model['challenge'] != TeamsyncSession::$current->challenge)
		{
			$this->commandResult->statusCode = 401;
			$this->commandResult->data['message'] = 'challenge verification failed';
			return;
		}*/


		TeamsyncSession::$current->authenticated = TRUE;
		TeamsyncSession::$current->challenge = null;

		$this->commandResult->statusCode = 200;
		$this->commandResult->data['message'] = '';
	}
}
