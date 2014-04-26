<?php namespace Core\Database;

use Core\App;

abstract class TSModelAbstract
{
	protected $table;
	public $attributes = array();
	protected $query;
	protected $adapter;

	public function __construct()
	{
		if (empty($this->table)) {
			trigger_error('Table name must be defined in extending class');
		}

		$container 		= App::getContainer();
		$this->query 	= $container['query'];
	}

	public function findById($id)
	{
		$row = $this->query->select('*')
							->from($this->table)
							->where('id','=',$id)
							->get();

		$obj = $this->_createObject($row);

		return $obj;
	}

	public function findAll()
	{
		$rows = $this->query->select('*')
							->from($this->table)
							->getAll();

		$objs = $this->_createObject($rows);

		return $objs;
	}

	protected function _createObject($row)
	{
		$obj = null;

		if(count($row) > 1)
		{
			$obj = $this->_createMultipleObjects($row);
		}
		else
		{
			$obj = $this->_createSingleObject($row);
		}

		return $obj;
	}

	protected function _createSingleObject($row)
	{

		$obj = new static;

		foreach($row as $key => $value)
		{
			$obj->$key = $value;
		}
		
		return $obj;
	}

	protected function _createMultipleObjects($rows)
	{
		$objs = array();

		foreach($rows as $row)
		{
			$objs[] = $this->_createSingleObject($row);
		}

		$collection = new TSModelCollection($objs);
		
		return $collection;
	}

	public function __set($key, $value)
	{
		$this->attributes[$key] = $value;
	}

	public function __get($key)
	{
		return $this->attributes[$key];
	}
}