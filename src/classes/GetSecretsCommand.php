<?php
use \RedBeanPHP\R as R;
class GetSecretsCommand extends Command {
	public function run($model) {
		$this->commandResult->data = R::getAll('SELECT * FROM secret');
		$this->commandResult->statusCode = 200;
	}
}
