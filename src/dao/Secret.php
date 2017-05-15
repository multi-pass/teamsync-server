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
		// TODO: Check for PGP id
		return R::findOne('secret', ' filepath = ? ', array($path));
	}

	/**
	 * Get all secrets stored for user with $pgpid.
	 *
	 * @param string $pgpid
	 * @return array of beans that represents all secrets for user with $pgpid
	 */
	public static function findAll($pgpid) {
		return R::findAll('secret');
	}

	/**
	 * Get a list of all secrets stored for user with $pgpid.
	 *
	 * @param string $pgpid
	 * @return array of string that represents all secrets for user with $pgpid
	 */
	public static function listAll($pgpid) {
		return R::getCol('SELECT filepath FROM secret');
	}

}
