<?php

class TeamSyncSession {
	public static $current = NULL;

	public $name = 'anonymous';
	public $challenge = NULL;
	public $publicKey = NULL;
	public $authenticated = FALSE;
}
