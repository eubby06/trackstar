<?php

class Autoloader 
{
	public static function load( $namespace_class )
	{

		$file_path = str_replace('\\', DS, $namespace_class);

		$extensions = explode(',', spl_autoload_extensions());

		array_walk($extensions, function($ext) use($file_path)
		{
			$file = PATH_ROOT . $file_path . $ext;

			if(!file_exists($file))
			{
				throw new \Exception('File not found sucker!!!');
			}
			else
			{
				include_once($file);
			}
			
		});
	}
}