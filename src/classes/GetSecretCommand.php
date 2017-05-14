<?php
use \RedBeanPHP\R as R;
class GetSecretCommand extends Command
{
        public function run($model)
        {
                $this->commandResult->statusCode = 200;
		$this->commandResult->data = R::getAll( 'SELECT * FROM secret' );
	}
}
