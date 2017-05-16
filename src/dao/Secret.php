<?php

namespace TeamSync\DAO;
use \RedBeanPHP\R as R;

class Secret extends \RedBeanPHP\SimpleModel {

	/**
	 * Get all secrets stored at a given path.
	 * There may be multiple secrets stored at the same location as long as the
	 * intersection of the recipients is empty.
	 *
	 * @param string $path
	 * @return array of beans that represent a secret at the given path
	 */
	public static function findAllByPath($path) {
		return R::findAll('secret', ' filepath = ? ', array($path));
	}

	/**
	 * Get secret stored at a given path for user with $pgpid.
	 *
	 * @param string $path
	 * @param string $pgpid
	 * @return bean that represent a secret at the given path for user with $pgpid
	 */
	public static function findByPath($path, $pgpid) {
		if (!self::tableExists()) { return NULL; }
		$sql = 'SELECT `secret`.* FROM `secret` '
			  .'NATURAL JOIN `recipient_secret` '
			  .'NATURAL JOIN `recipient` '
			  .'WHERE `secret`.`filepath` = :path '
			  .'AND RIGHT(`recipient`.`pgpid`, LEAST(LENGTH(`recipient`.`pgpid`), :idlen)) '
			  .'    = RIGHT(:pgpid, LEAST(LENGTH(`recipient`.`pgpid`), :idlen)) '
			  .'LIMIT 1';

		$secrets = R::findMulti('secret', $sql, array(
			':path' => $path,
			':pgpid' => $pgpid,
			':idlen' => strlen($pgpid)
		))['secret'];

		return (count($secrets) > 0 ? reset($secrets) : NULL);
	}

	/**
	 * Get all secrets stored for user with $pgpid.
	 *
	 * @param string $pgpid
	 * @return array of beans that represents all secrets for user with $pgpid
	 */
	public static function findAll($pgpid) {
		if (!self::tableExists()) { return array(); }

		$sql = 'SELECT `secret`.* FROM `secret` '
			  .'NATURAL JOIN `recipient_secret` '
			  .'NATURAL JOIN `recipient` '
			  .'WHERE RIGHT(`recipient`.`pgpid`, LEAST(LENGTH(`recipient`.`pgpid`), :idlen)) '
			  .'    = RIGHT(:pgpid, LEAST(LENGTH(`recipient`.`pgpid`), :idlen))'
			  .'ORDER BY `secret`.`filepath` ASC';

		$rows = R::getAll($sql, array(
			':pgpid' => $pgpid,
			':idlen' => strlen($pgpid)
		));
		return R::convertToBeans('secret', $rows);

		return R::findMulti('secret', $sql, array(
			':pgpid' => $pgpid,
			':idlen' => strlen($pgpid)
		))['secret'];
	}

	private static function tableExists() {
		return (0 < R::getCell('SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_NAME = "secret"'));


	}


	public function hashes() {
		$hashes = array_filter($this->bean->export(), function ($key) {
			return (0 === strpos($key, 'hash_'));
		}, ARRAY_FILTER_USE_KEY);

		$hash_algos = array_map(function ($key) {
			return preg_replace('/^hash_/i', '', $key);
		}, array_keys($hashes));
		$hash_values = array_values($hashes);
		return array_combine($hash_algos, $hash_values);
	}

	public function recipients() {
		$recipients = array();
		foreach ($this->bean->ownRecipientsList as $rec) {
			array_push($recipients, $rec->pgpid);
		}
		return $recipients;
	}
}
