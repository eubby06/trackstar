<?php namespace Core;

// prevent this file from being accessed directly
if (!defined('IN_FRAMEWORK')) exit;

/**
 * Router Class
 */
class Router {

	private $registry 			= null;

	private $requestObj 		= null;

	// value of the route Route::get('value', function(){})
	private $routeValue			= null;

	private static $getRoutes 	= array();

	private static $postRoutes	= array();


	public function __construct($registry)
	{
		$this->registry = $registry;
		$this->requestObj = $registry->getObject('CoreRequest');
	}

	public static function get($url, $callback)
	{
		if (isset(self::$getRoutes[strtolower($url)])) die('could not redeclare route!');
		
		self::$getRoutes[$url] = $callback;
	}

	public function match()
	{
		$path_info = strtolower($this->requestObj->getPathInfo());
		$routeValue = null;
		$match = false;

		foreach(self::$getRoutes as $key => $value)
		{
			if (rtrim($path_info, '/') == ltrim(strtolower($key), '/'))
			{
				$routeValue = $value;
				$match = true;

				break;
			}
		}

		$this->routeValue = $routeValue;
		return $match;
	}

	public function dispatch()
	{
		// if route matches
		if ($this->match())
		{
			if (is_callable($this->routeValue) && !is_null($this->routeValue))
			{
				call_user_func($this->routeValue);
			}
			else if(!is_null($this->routeValue))
			{
				list($controller, $method) = explode('@', $this->routeValue);
			}
		}
		else
		{
			throw new \Exception('There is no route match.');
		}

		$controller = $controller ? $controller : null;
		$method 	= $method ? $method : null;
		$params 	= $this->requestObj->getParams();

		try
		{
			$controllerObj = new $controller();

			if (method_exists($controllerObj, $method))
			{
				if(count($params))
				{
					call_user_func(array($controllerObj, $method), $params);
				}
				else
				{
					call_user_func(array($controllerObj, $method));
				}
				
			}
			
		}
		catch(\Exception $err)
		{
			die('Caught exception: ' . $err->getMessage());
		}
		
	}
}