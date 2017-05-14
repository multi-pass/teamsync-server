<?php
use \RedBeanPHP\R as R;
class GetSecretCommand extends Command {
	public function run($model) {
		if (empty($model['path'])) {
			$this->commandResult->statusCode = 422;
			$this->commandResult->data['message'] = 'Path missing';
			return;
		}

		$secret_path = $model['path'];

		$bean = R::findOne('secret', ' WHERE filepath = ?', array($secret_path));

		if (!is_null($bean)) {
			$this->commandResult->data = $bean;
			$this->commandResult->statusCode = 200;
		} else {
			$this->commandResult->statusCode = 404;
		}
	}
}
