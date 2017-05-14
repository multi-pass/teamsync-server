<?php

abstract class Command {
	public function __construct() {
		$this->commandResult = new CommandResult();
	}

	protected $commandResult = null;

	abstract public function run($model);

	public function getResult() {
		return $this->commandResult;
	}
}
