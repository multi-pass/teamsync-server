<?php

namespace TeamSync\DAO;
use \RedBeanPHP\R as R;

class Recipient extends \RedBeanPHP\SimpleModel {

	/**
	 * Get recipient bean for a given PGP fingerprint.
	 *
	 * @param string $fingerprint
	 * @return bean that represents a user with $fingerprint
	 */
	public static function forFingerprint($fingerprint) {
		$rec = NULL;
		if (!($rec = R::findOne('recipient', ' fingerprint = ? ', array($pgpid)))) {
			$rec = R::dispense('recipient');
			$rec->fingerprint = $fingerprint;
		}

		return $rec;
	}

	/**
	 * Get recipient bean for a given PGP key id.
	 *
	 * @param string $pgpid
	 * @return bean that represents a user with $pgpid
	 */
	public static function forKey($pgpid) {
		$rec = R::findOne('recipient',
						  ' RIGHT(pgpid, LENGTH(:pgpid)) = :pgpid ',
						  array(':pgpid' => $pgpid));

		if (is_null($rec)) {
			$rec = R::dispense('recipient');
			$rec->pgpid = $pgpid;
		}

		return $rec;
	}


	public function hasAccessToSecret(\RedBeanPHP\OODBBean $secret) {
		array_push($secret->sharedRecipientList, $this->bean);
	}

}
