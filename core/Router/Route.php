<?php namespace Core\Router;

class Route
{
	public static $gets = array();
	public static $posts = array();

	public static function get($uri, $controllerAction)
	{
		list($controller, $action) = explode('@', $controllerAction);

		if( array_key_exists(strtolower($uri), self::$gets) )
		{
			trigger_error('You cannot declare route more than once!');
		}

		self::$gets[self::renameParams($uri)] = array(
			'controller' => $controller,
			'action' 	=> $action
		);
	}

	public static function post($uri, $controllerAction)
	{
		list($controller, $action) = explode('@', $controllerAction);

		if( array_key_exists(strtolower($uri), self::$posts))
		{
			trigger_error('You cannnot declare route more than once!');
		}

		self::$posts[self::renameParams($uri)] = array(
			'controller' => $controller,
			'action' 	=> $action
		);
	}

	public static function renameParams($uri)
	{
		return preg_replace("/\{\w+\}/", 'param', $uri);
	}
}