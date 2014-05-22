<?php namespace Core\Helper;

class Html
{
	public static function script($path)
	{
		return '<script type="text/javascript" src="' . str_replace('.', '/', $path) . '.js"> </script>';
	}

	public static function style($path)
	{
		return '<link rel="stylesheet" href="' . str_replace('.', '/', $path) . '.css" >';
	}
}
