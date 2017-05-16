<?php
use \RedBeanPHP\R as R;
class GetSecretsCommand extends Command {
	public function run($model) {
		$pgpid = TeamSyncSession::$current->publicKey;
		$secrets = \TeamSync\DAO\Secret::findAll($pgpid); // presorted

		$out = array(
			'path' => '/',
			'secrets' => array(),
			'folders' => array()
		);

		foreach ($secrets as $s) {
			$p =& $out;
			if ("/" !== dirname($s->filepath)) {
				$path = explode('/', dirname($s->filepath));
				array_shift($path);

				foreach ($path as $c) {
					if (!isset($p['folders'][$c])) {
						$p['folders'][$c] = array(
							'path' => $c,
							'secrets' => array(),
							'folders' => array()
						);
					}
					$p =& $p['folders'][$c];
				}
			}

			array_push($p['secrets'], array(
				'name' => basename($s->filepath),
				'hash' => $s->hashes()
			));
		}

		$this->commandResult->data = $out;
		$this->commandResult->statusCode = 200;
	}
}
