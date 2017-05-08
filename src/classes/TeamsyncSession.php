<?php

class TeamsyncSession
{
	public static $current = null;

	public $name = 'anonymous';
	public $challenge = null;
	public $publicKey = null;
	public $authenticated = FALSE;
}
