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
		$pgpid = TeamSyncSession::$current->publicKey;

		$bean = \TeamSync\DAO\Secret::findByPath($secret_path, $pgpid);

		if (!is_null($bean)) {
			$this->commandResult->data = array(
				'path' => $bean->filepath,
				'hash' => $bean->hashes(),
				'payload' => $bean->blob
			);
			$this->commandResult->statusCode = 200;
		} else {
			$this->commandResult->statusCode = 404;
		}
	}
}
