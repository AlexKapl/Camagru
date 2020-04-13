<?php

require_once(ROOT . '/model/MessageTrait.php');
require_once(ROOT . '/model/User.php');

abstract class BaseController
{
	use MessageTrait;

	protected $db;
	protected $view;

	function __construct($class, $db, $args=NULL)
	{
		$this->db = $db;
		$name = str_replace('Controller', 'View', get_class($class));
		require_once(ROOT . "/view/$name.php");
		$this->view = $args ? new $name($args) : new $name();
	}

	abstract public function handleRequest();
}
