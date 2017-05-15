<?php
namespace TeamSync;

class OpenPGPHelper {
	public static function getRecipients($pgp_blob) {
		$message = \OpenPGP_Message::parse($pgp_blob);

		$recipients = array();
		foreach ($message as $i => $packet) {
			if ($packet->tag === 1) {
				array_push($recipients, $packet->keyid);
			}
		}

		return $recipients;
	}

	public static function getRecipientsFile($gpg_file_path) {
		return self::getRecipients(file_get_contents($gpg_file_path));
	}
}
