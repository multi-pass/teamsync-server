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
	public static function findByPath($path) {
		return R::findAll('secret', ' filepath = ? ', array($path));
	}

}
