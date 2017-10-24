<?php

class Router
{
	private $_routes;
	private $_db;

	public function __construct($db) {
		$this->_db = $db;
		$this->_routes = include(ROOT . '/config/routes.php');
	}

	/*
	 *	Returns requested uri from server
	 *	or FALSE if invalid request
	 */
	private function _getURI() {
		if (!empty($_SERVER['REQUEST_URI'])) {
			$uri = $_SERVER['REQUEST_URI'];
			if ($uri === '/')
				$uri = 'login';
			else
				$uri = trim($uri, '/');
			return $uri;
		} else
			return (FALSE);
	}

	public function route() {
		$uri = $this->_getURI();
		$uri = 'login';
		foreach ($this->_routes as $uri_route => $path) {
			if (preg_match("~$uri_route~", $uri)) {
				include (ROOT . "/controller/" . $path . ".php");
				return ;
			}
		}
		echo "OMFG\n";
	}

	public function __destruct() {
		// TODO: Implement __destruct() method.
	}
}
