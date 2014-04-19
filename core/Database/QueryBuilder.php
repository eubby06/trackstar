<?php namespace Core\Database;

class QueryBuilder
{

	public $action;

	public $aggregate;

	public $columns;

	public $from;

	public $joins;

	public $wheres;

	public $groups;

	public $havings;

	public $orders;

	public $limit;

	public $offset;

	public $unions;

	public $lock;

	public $sql;

	public $grammar;

	public $mapper;


	public function __construct(MysqlGrammar $grammar, PDOMapper $mapper)
	{
		$this->action = 'SELECT';

		$this->grammar = $grammar;
		$this->mapper = $mapper;
	}

	public function delete($table)
	{
		$this->action = 'DELETE';
		$this->table = $table;

		return $this;
	}

	public function select($columns = array('*'))
	{
		$this->action = 'SELECT';
		$this->columns = is_array($columns) ? $columns : func_get_args();

		return $this;
	}

	public function from($table)
	{
		$this->from = $table;

		return $this;
	}

	public function where($column, $operator = null, $value = null)
	{
		if (func_num_args() == 2)
		{
			list($column, $value) = func_get_args();
			$operator = '=';
		}

		$this->wheres[] = compact('column', 'operator', 'value');

		return $this;
	}

	public function order($colum){}

	public function limit($limit, $offset){}

	public function count($table){}

	public function run()
	{
		$this->mapper->query($this->toSql());
		print_r($this->mapper->fetch());
	}

	protected function toSql()
	{
		return $this->grammar->compile($this);
	}
}