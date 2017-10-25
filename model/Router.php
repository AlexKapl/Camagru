<?php

class Router
{
	private $_routes;

	public function __construct() {
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
		foreach ($this->_routes as $uri_route => $path) {
			if (preg_match("~$uri_route~", $uri)) {
				$res = explode('/', preg_replace("~$uri_route~", $path, $uri));
				$res[0] = ROOT . "/controller/" . $res[0] . ".php";
				return ($res);
//				return (['controller' => ROOT . "/controller/" . $res[0] . ".php",
//				return (ROOT . "/controller/" . $path . ".php");
			}
		}
		return NULL;
	}

	public function __destruct() {
		// TODO: Implement __destruct() method.
	}
}
