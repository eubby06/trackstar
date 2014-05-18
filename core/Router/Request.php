<?php namespace Core\Router;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Core\Router\Route;

class Request
{
	public $request;
	public $segments = array();
	public $controller;
	public $action;

	public function __construct()
	{
		$this->request = SymfonyRequest::createFromGlobals();
		$this->segments = $this->path();

	}

	public function controller()
	{
		return $this->controller;
	}

	public function method()
	{
		return $this->action;
	}

	public function params()
	{
		return $this->request->getQueryString();
	}

	public function id()
	{
		return $this->segment(2);
	}

	public function segment($num)
	{
		return isset($this->segments[$num]) ? $this->segments[$num] : null;
	}

	public function path()
	{
		$path = trim($this->request->getPathInfo(), '/');
		return explode('/', $path);
	}

	public function getPathInfo()
	{
		$uri = trim($this->request->getPathInfo(), '/');

		return ($uri == '') ? '/' : $uri;
	}

	public function checkParamsInRoute()
	{
		// check if id in uri, and only process when there is one
		if ($this->id())
		{
			$controller = $this->segment(0);
			$method = $this->segment(1);

			// generate new uri with replaced param eg. view/{id} to view/param
			$newUri = implode('/', array($controller,$method,'param'));

			// trigger error if still there's no match found
			if( !array_key_exists($newUri, Route::$gets) )
			{
				trigger_error('There is no route set up for this request!');
			}

			// when found, then get controller and method
			$route 	= Route::$gets[$newUri];
			$this->controller = $route['controller'];
			$this->action = $route['action'];

			return true;
		}

		// if there's no id or 3rd segment in uri, then return false
		return false;
	}

	public function checkRoute()
	{
		// check if there is route set up for the request
		if( !array_key_exists($this->getPathInfo(), Route::$gets) )
		{
			// if there no route, try param route check
			if(!$this->checkParamsInRoute())
			{
				// trigger error when route isn't found
				trigger_error('There is no route set up for this request!');
			}
		}
		else
		{
			// if there is route, then get controller and action
			$route 	= Route::$gets[$this->getPathInfo()];
			$this->controller = $route['controller'];
			$this->action = $route['action'];
		}
	}

	public function dispatch()
	{
		// check if route has been set for this request
		$this->checkRoute();

		//create controller object
		$controllerClass = $this->controller();
		$controller = new $controllerClass();

		//get controller method
		$method = $this->method();
		$params = $this->id() ? array($this->id()) : array($this->params());

		// call class method with params
		call_user_func_array(array($controller, $method), $params);
	}
}