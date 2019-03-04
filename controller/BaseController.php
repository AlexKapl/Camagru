<?php

abstract class BaseController
{
	protected $view = "";

	function __construct($class)
	{
		$name = str_replace('Controller', 'View', get_class($class));
		require_once(ROOT . "/view/$name.php");
		$this->view = new $name();
	}

	abstract public function handleRequest();
}
