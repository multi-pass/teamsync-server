<?php

namespace TeamSync\DAO;
use \RedBeanPHP\R as R;

class Recipient extends \RedBeanPHP\SimpleModel {

	/**
	 * Get recipient bean for a given PGP-id.
	 *
	 * @param string $pgpid
	 * @return bean that represents a user with $pgpid
	 */
	public static function forKey($pgpid) {
		$rec = NULL;
		if (!($rec = R::findOne('recipient', ' `pgpid` = ? ', array($pgpid)))) {
			$rec = R::dispense('recipient');
			$rec->pgpid = $pgpid;
		}

		return $rec;
	}


	public function hasAccessToSecret(\RedBeanPHP\OODBBean $secret) {
		array_push($secret->sharedRecipientList, $this->bean);
	}

}
