<?php
use \RedBeanPHP\R as R;
class GetSecretsCommand extends Command {
	public function run($model) {
		$pgpid = TeamSyncSession::$current->publicKey;
		$secrets = \TeamSync\DAO\Secret::listAll($pgpid);
		sort($secrets);

		$out = array(
			'path' => '/',
			'secrets' => array(),
			'folders' => array()
		);

		foreach ($secrets as $s) {
			$p =& $out;
			if ("/" !== dirname($s)) {
				$path = explode('/', dirname($s));
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

			$sec = \TeamSync\DAO\Secret::findByPath($s, $pgpid);
			array_push($p['secrets'], array(
				'name' => basename($sec->filepath),
				'hash' => array(
					'sha256' => $sec->hash
				)
			));
		}

		$this->commandResult->data = $out;
		$this->commandResult->statusCode = 200;
	}
}
