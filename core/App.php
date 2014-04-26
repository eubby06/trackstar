<?php namespace Core;

use Core\Container\Pimple as Container;

class App
{
	public static $container = null;

	public static function getContainer()
	{
		if(is_null(self::$container))
		{
			self::$container = new Container();
		}

		return self::$container;
	}
}