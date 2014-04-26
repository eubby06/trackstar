<?php namespace Core\Database;

use IteratorAggregate, Countable, ArrayIterator;

class TSModelCollection implements IteratorAggregate, Countable
{
	public $entities = array();

	public function __construct(array $entities)
	{
		if (!empty($entities))
		{
			$this->entities = $entities;
		}
	}

	public function add($entity)
	{
		$this->entities[] = $entity;
	}

	public function count()
	{
		return count($this->entities);
	}

	public function getIterator()
	{
		return new ArrayIterator($this->entities);
	}

	public function filter($callback)
	{
		return new self(array_filter($this->entities, $callback));
	}

	public function sortBy($column, $descending = false, $options = SORT_REGULAR)
	{

		$result = array();
		$newResult = array();

		foreach($this->entities as $key => $obj)
		{
			$result[$key] = $obj->$column;
		}

		if($descending)
		{
			arsort($result, $options);
		}
		else
		{
			asort($result, $options);
		}

		foreach($result as $key => $value)
		{
			$newResult[] = $this->entities[$key];
		}

		$this->entities = $newResult;

		return $this;
	}

	public function each($callback)
	{
		if(is_callable($callback))
		{
			array_map($callback, $this->entities);
		}

		return $this;
	}
}