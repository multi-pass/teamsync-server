<?php

class GetSecretCommand extends Command
{
        public function run($model)
        {
                $this->commandResult->statusCode = 500;
		$this->commandResult->data['message'] = 'not implemented';
	}
}
