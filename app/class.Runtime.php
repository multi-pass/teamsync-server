<?php
class Runtime {
	public static function redirect($to_url) {
		if (empty($to_url)) { return; }
		if (!headers_sent()) {
			header('Location: '.$to_url);
		} else {
			// Try HTML redirect if header change doesn't work
			echo '<meta http-equiv="refresh" content="0; url='.$to_url.'" />Sie werden weitergeleitet. Falls Sie nicht weitergeleitet wurden, klicken Sie <a href="'.$to_url.'">hier</a>';
		}
		exit;
	}

	public static function importClass($className, $subfolder = '') {
		$classPath = DIR_CLASSES.'/'.$subfolder.'/class.'.ucfirst($className).'.php';

		if (file_exists($classPath)) {
			require_once($classPath);
			return TRUE;
		}

		return FALSE;
	}

	const P_LOGGEDIN = 'p_loggedin';
	const P_ADMIN = 'p_admin';

	public static function checkPermission($required_permissions) {
		if (!is_array($required_permissions)) {
			$required_permissions = array($required_permissions);
		}

		$have_permissions = TRUE; // assume that all users are nice at first :)

		// Check logged_in permission
		if (in_array(self::P_LOGGEDIN, $required_permissions, TRUE)) {
			if (isset($_SESSION['logged_in'])
				&& isset($_SESSION['logged_in_user_id'])
				&& !is_null($_SESSION['logged_in_user_id'])) {

				if ($_SESSION['logged_in'] !== TRUE) {
					$have_permissions = FALSE;
				}

				if (!SQLUsers::exists($_SESSION['logged_in_user_id'])) {
					$have_permissions = FALSE;
				}
			} else {
				$have_permissions = FALSE;
			}
		}

		// Check is_admin permission
		if (in_array(self::P_ADMIN, $required_permissions, FALSE)) {
			$have_permissions = (self::checkPermission(self::P_LOGGEDIN)
								 && self::loggedInUser()->isAdmin());
		}

		return $have_permissions;
	}

	public static function htmlSanitize($text) {
		return htmlentities($text, @(ENT_COMPAT | ENT_HTML5), 'UTF-8', FALSE);
	}
}
