<?php namespace Core\Database;

use Core\App;
use Core\Database\TSSQLQuery as Query;
use Core\Database\TSPDODataAccess as DataAccess;

class PivotTable
{
	public $attributes = array();
	public $fk1Key;
	public $fk2Key;
	public $fk1Value;
	public $fk2Value;
	public $table;
	public $container;

	public function __construct($pivot, $fk1Key, $fk2Key, $row)
	{
		if(!$pivot) trigger_error('pivot table name is required.');
		if(!$fk1Key) trigger_error('fk1 is required.');
		if(!$fk2Key) trigger_error('fk2 is required.');

		$this->container 	= App::getContainer();

		$this->table = $pivot;
		$this->fk1Key = $fk1Key;
		$this->fk2Key = $fk2Key;

		if($row) 
		{
			foreach($row as $key => $value)
			{
				if($this->fk1Key == $key)
				{
					$this->fk1Value = $value;
				}
				else if($this->fk2Key == $key)
				{
					$this->fk2Value = $value;
				}
				else
				{
					$this->$key = $value;
				}
			}
		}
	}

	public function save()
	{
		$query = $this->_newQuery();

		$res = $query->update($this->table)
					->set($this->attributes)
					->where($this->fk1Key,'=',$this->fk1Value)
					->where($this->fk2Key,'=',$this->fk2Value)
					->execute();

		return $res;
	}

	public function __set($key, $value)
	{
		return $this->attributes[$key] = $value;
	}

	public function __get($key)
	{
		return $this->attributes[$key];
	}

	protected function _newQuery()
	{
		return new Query($this->container['dataAccess']);
	}


}