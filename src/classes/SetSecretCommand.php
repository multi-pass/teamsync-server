<?php
use \RedBeanPHP\R as R;

class SetSecretCommand extends Command {
	public function run($model) {
		if (is_null($model)) {
			$this->commandResult->statusCode = 400;
			$this->commandResult->data['message'] = 'Invalid content';
			return;
		}

		$path = $model['path'];
		if (is_null($path)) {
			$this->commandResult->statusCode = 422;
			$this->commandResult->data['message'] = 'path missing';
			return;
		}
		$payload = (!empty($model['payload']) ? $model['payload'] : NULL);

		$sec = R::findOne('secret', ' filepath = ? ', array($path));
		if (is_null($sec)) {
			$sec = R::dispense('secret');
			$sec->filepath = $path;
			$this->commandResult->data['message'] = "Secret Created: $path";
		} else {
			$this->commandResult->data['message'] = "Secret Updated: $path";
		}

		$sec->blob = $payload;
		R::store($sec);

		// Recipient Bean erstellen
/*		$rec = R::dispense('recipient');
		$rec->publicKey = TeamsyncSession::$current->publicKey;

		// Relation hinzufügen
		array_push($sec->sharedRecipientList, $rec);

		// Werte in DB schreiben
		R::storeAll([$sec,$rec]);
*/

		$this->commandResult->statusCode = 200;
	}
}
