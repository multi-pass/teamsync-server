<?php

class AuthCommand extends Command {
	public function run($model) {
		if (is_null(TeamsyncSession::$current->challenge)) {
			$this->commandResult->statusCode = 422;
			$this->commandResult->data['message'] = 'invalid content';
			return;
		}

		if (is_null($model)) {
			$this->commandResult->statusCode = 400;
			$this->commandResult->data['message'] = 'invalid content';
			return;
		}

		if (is_null($model['challenge'])) {
			$this->commandResult->statusCode = 422;
			$this->commandResult->data['message'] = 'challenge missing/empty';
			return;
		}

		// TODO: decode challenge
		/* if ($model['challenge'] != TeamsyncSession::$current->challenge) {
			$this->commandResult->statusCode = 401;
			$this->commandResult->data['message'] = 'challenge verification failed';
			return;
		} */

		TeamsyncSession::$current->authenticated = TRUE;
		TeamsyncSession::$current->challenge = NULL;

		$this->commandResult->statusCode = 200;
		$this->commandResult->data['message'] = '';
	}
}
