<?php namespace Core;

class Controller
{
	protected $db_adapter;

	public function __construct()
	{
		$registry = \Core\Registry::singleton();

		$this->db_adapter = $registry->getObject('DBAdapter');
	}
}