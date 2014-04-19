<?php namespace Core;

if (!defined('IN_FRAMEWORK')) exit;

class Registry 
{

	private static $_objects = array();

	private static $_settings = array();

	private static $_instance = null;


	private function __construct() {}

	public static function singleton() 
	{

		if (is_null(self::$_instance)) 
		{

			$obj = __CLASS__;
			self::$_instance = new $obj;
		}

		return self::$_instance;

	}

	public function __clone() 
	{

		trigger_error('Cloning the registry is not permitted.');
	}

	public function storeObject( $object, $key ) 
	{

		self::$_objects[ $key ] = is_object($object) ? $object : new $object( self::$_instance );
	}

	public function getObject( $key )
	{

		if(is_object(self::$_objects[ $key ]))
		{
			return self::$_objects[ $key ];
		}
	}

	public function storeSettings( $setting, $key )
	{
		self::$_settings[ $key ] = $setting;
 	}

 	public function getSetting( $key )
 	{
 		if (isset(self::$_settings[ $key ]))
 		{
 			return self::$_settings[ $key ];
 		}
 	}
}