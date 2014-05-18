<?php namespace Core\Database;

use Core\App;

abstract class TSModelAbstract
{
	protected $table;
	public $attributes = array();
	protected $query;
	protected $adapter;
	protected $container;

	public function __construct()
	{
		if (empty($this->table)) {
			trigger_error('Table name must be defined in extending class');
		}

		$this->container 	= App::getContainer();
		$this->query 		= $this->_newQuery();
	}

	public function findById($id)
	{
		$query = $this->_newQuery();

		$row = $query->select('*')
							->from($this->table)
							->where('id','=',$id)
							->get();

		$obj = $this->_createSingleObject($row);

		return $obj;
	}

	public function findAll()
	{
		$query = $this->_newQuery();

		$rows = $query->select('*')
							->from($this->table)
							->getAll();

		$objs = $this->_createMultipleObjects($rows);

		return $objs;
	}

	protected function _createSingleObject($row, $obj = null)
	{
		$obj = $obj ? $obj : new static;

		foreach($row as $key => $value)
		{
			$obj->$key = $value;
		}
		
		return $obj;
	}

	protected function _createMutipleRelationshipModels($rows, $model)
	{
		$objs = array();

		foreach($rows as $row)
		{
			$obj = new $model;
			$objs[] = $this->_createSingleObject($row, $obj);
		}

		$collection = new TSModelCollection($objs);
		
		return $collection;
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

	public function hasOne($model, $foreignKey = null)
	{
		$model = new $model;
		$modelTable = $model->_getTable();

		$field = ($foreignKey) ? $foreignKey : $this->_singularize($modelTable) . '_id';

		$query = $this->_newQuery();

		$row = $query->select('*')
						->from($modelTable)
						->where($field,'=',$this->id)
						->get();

		return $this->_createSingleObject($row, $model);
	}

	public function belongsTo($model, $foreignKey = null)
	{
		$model = new $model;
		$modelTable = $model->_getTable();

		$fk = ($foreignKey) ? $foreignKey : $this->_singularize($modelTable) . '_id';

		$query = $this->_newQuery();

		$row = $query->select('*')
					->from($modelTable)
					->where('id','=',$this->$fk)
					->get();

		return $this->_createSingleObject($row, $model);
	}

	public function hasMany($model, $foreignKey = null)
	{
		$model = new $model;
		$modelTable = $model->_getTable();

		$field = ($foreignKey) ? $foreignKey : $this->_singularize($modelTable) . '_id';

		$query = $this->_newQuery();

		$rows = $query->select('*')
						->from($modelTable)
						->where($field,'=',$this->id)
						->getAll();

		return $this->_createMutipleRelationshipModels($rows, $model);		
	}

	public function belongsToMany($model, $pivot = null)
	{
		$model = new $model;
		$pivot = ($pivot) ? $pivot : $this->_getPivotTable($model, $this);

		$fk = $this->_singularize($this->_getTable()) . '_id';

		$query = $this->_newQuery();

		$rows = $query->select('*')
						->from($pivot)
						->where($fk, '=',$this->id)
						->getAll();

		$objs = array();

		foreach($rows as $row)
		{

			$fk2 = $model->_singularize($model->_getTable()) . '_id';

			$obj = $model->findById($row[$fk2]);

			$obj->pivot = $this->_createPivot($pivot, $fk, $fk2, $row);

			$objs[] = $obj;
		}

		$collection = new TSModelCollection($objs);
		
		return $collection;
	}

	protected function _createPivot($pivot, $fk1, $fk2, $row)
	{
		$pivot = new PivotTable($pivot, $fk1, $fk2, $row);

		return $pivot;
	}

	protected function _getPivotTable($model1, $model2)
	{
		$thisModelTableName = $this->_singularize($model1->_getTable());
		$modelTableName = $this->_singularize($model2->_getTable());

		return implode('_', array($thisModelTableName,$modelTableName));
	}

	protected function _getTable()
	{
		return $this->table;
	}

	protected function _pluralize($string)
	{
		return strtolower($string) . 's';
	}

	protected function _singularize($string)
	{
		return rtrim($string, 's');
	}

	protected function _newQuery()
	{
		return $this->container['query'];
	}

	public function __set($key, $value)
	{
		$this->attributes[$key] = $value;
	}

	public function __get($key)
	{
		if (method_exists($this, $key))
		{
			return $this->$key();
		}

		return $this->attributes[$key];
	}
}