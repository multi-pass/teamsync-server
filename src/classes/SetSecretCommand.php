<?php
use \RedBeanPHP\R as R;

class SetSecretCommand extends Command {
	public function run($model) {
		if (is_null($model)) {
			$this->commandResult->statusCode = 400;
			$this->commandResult->data['message'] = 'Invalid content';
			return;
		}

		if (!isset($model['path']) || is_null($model['path'])) {
			$this->commandResult->statusCode = 422;
			$this->commandResult->data['message'] = 'Path missing';
			return;
		}
		$path = $model['path'];

		$pgpid = TeamSyncSession::$current->publicKey;

		$payload_b64 = (!empty($model['payload']) ? $model['payload'] : NULL);
		$payload = base64_decode($payload_b64);

		// Calculate hashes
		$payload_hash = array(
			'sha256' => hash('sha256', $payload),
			'ripemd160' => hash('ripemd160', $payload),
			'sha1' => hash('sha1', $payload)
		);

		if (isset($model['hash']) && is_array($model['hash'])) {
			foreach (array_intersect($payload_hash, $model['hash']) as $dgst_algo) {
				if ($payload_hash[$dgst_algo] !== $model['hash'][$dgst_algo]){
					$this->commandResult->data['message'] = 'Hash validation failed';
					$this->CommandResult->statusCode = 400;
					return;
				}
			}
		}

		$sec = \TeamSync\DAO\Secret::findByPath($path, $pgpid);
		if (is_null($sec)) {
			$sec = R::dispense('secret');
			$sec->filepath = $path;
			$this->commandResult->data['message'] = "Secret Created: ${path}";
		} else {
			$this->commandResult->data['message'] = "Secret Updated: ${path}";
		}

		// Update fields of secret
		$sec->blob = $payload_b64;

		$my_pgpid = TeamSyncSession::$current->publicKey;
		$me = \TeamSync\DAO\Recipient::forKey($my_pgpid);
		$me->hasAccessToSecret($sec);

		foreach ($payload_hash as $dgst_algo => $dgst) {
			$sec->{'hash_'.$dgst_algo} = $dgst;
		}

		// Recipient Bean erstellen
		$this->commandResult->data['recipients'] = array($my_pgpid);

		$recipients = \TeamSync\OpenPGPHelper::getRecipients($payload);
		foreach ($recipients as $recipient_pgpid) {
			array_push($this->commandResult->data['recipients'], $recipient_pgpid);

			$rec = \TeamSync\DAO\Recipient::forKey($recipient_pgpid);
			$rec->hasAccessToSecret($sec);
			R::store($rec);
		}
		$recipients = array_unique($recipients);

		$id = R::store($sec);

		$this->commandResult->statusCode = (0 < $id ? 200 : 500);
	}
}
