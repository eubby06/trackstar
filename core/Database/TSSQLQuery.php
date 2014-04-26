<?php namespace Core\Database;

class TSSQLQuery {

	protected $mode;
	protected $columns = '*';
	protected $table;
	protected $where = array();
	protected $params = array();
	protected $data = array();
	protected $set = array();
	protected $orderBy;
	protected $whereLike;
	protected $whereBetween;
	protected $whereIn = array();
	protected $db;

	public function __construct(AdapterInterface $adapter)
	{
		$this->db = $adapter;
	}

	public function select($column = 'all')
	{
		$this->mode = "select";

		if ($column !== 'all')
		{
			$this->columns = func_get_args();
		}

		return $this;
	}

	public function insert($table)
	{
		$this->mode = "insert";
		$this->table = $table;

		return $this;
	}

	public function update($table)
	{
		$this->mode = "update";
		$this->table = $table;

		return $this;
	}

	public function delete($table)
	{
		$this->mode = "delete";
		$this->table = $table;

		return $this;
	}

	public function set(array $data)
	{
		$this->set = $data;
		return $this;
	}

	public function data(array $data)
	{
		$this->data = $data;
		return $this;
	}

	public function from($table)
	{
		$this->table = $table;

		return $this;
	}

	public function where($column,$operator,$value)
	{
		$this->where['column'][] = $column;
		$this->where['operator'][] = $operator;
		$this->where['value'][] = $value;

		return $this;
	}

	public function orderBy($column)
	{
		$this->orderBy = $column;

		return $this;
	}

	public function whereLike($column, $char, $pos = '')
	{
		$this->whereLike['column'][] = $column;
		$this->whereLike['char'][] = $char;
		$this->whereLike['pos'][] = $pos;

		return $this;
	}

	public function whereIn($column, $values)
	{
		$this->whereIn[$column] = $values;

		return $this;
	}

	public function whereBetween($column, $min, $max)
	{
		$this->whereBetween['column'] = $column;
		$this->whereBetween['min'] = $min;
		$this->whereBetween['max'] = $max;

		return $this;
	}

	public function execute()
	{
		$sql = $this->compile();
		
		$result = $this->db->execute($sql, $this->params);

		return $result;
	}

	public function get()
	{
		$sql = $this->compile();
		
		$result = $this->db->query($sql, $this->params, false);

		return $result;
	}

	public function getAll()
	{
		$sql = $this->compile();
		
		$result = $this->db->query($sql, $this->params, true);

		return $result;
	}

	public function compile()
	{
		$sql = '';

		switch(strtolower($this->mode))
		{
			case 'select':
				$sql = 'SELECT ';
				$sql .= $this->compileColumns();
				$sql .= $this->compileFrom();
				$sql .= $this->compileWhere();
				$sql .= $this->compileWhereLike();
				$sql .= $this->compileWhereIn();
				$sql .= $this->compileWhereBetween();
				$sql .= $this->compileOrderBy();
			break;

			case 'insert':
				$sql = 'INSERT INTO ';
				$sql .= $this->table . ' ';
				$sql .= $this->compileData();
			break;	

			case 'update':
				$sql = 'UPDATE ';
				$sql .= $this->table . ' ';
				$sql .= $this->compileSet();
				$sql .= $this->compileWhere();
			break;	

			case 'delete':
				$sql = 'DELETE FROM ';
				$sql .= $this->table . ' ';
				$sql .= $this->compileWhere();
			break;	
		}
		
		return $sql;
	}

	public function compileSet()
	{
		$sql = '';

		if(empty($this->set))
		{
			trigger_error('updating with an empty data');
		}
		
		foreach($this->set as $field => $value)
		{
			$sql .= 'SET ' . $field . ' = ' . ':' . $field . ' ';
			$this->params[':' . $field] = $value;
		}

		return $sql;
	}

	public function compileData()
	{
		$sql = '';

		if(empty($this->data))
		{
			trigger_error('inserting an empty data');
		}

		$fields = array_keys($this->data);
		$values = array_values($this->data);

		$sql .= '(';
		$sql .= implode(', ', $fields);
		$sql .= ')';

		$sql .= ' VALUES (';
		$sql .= ':' . implode(', :', $fields);
		$sql .= ')';
		
		foreach($this->data as $field => $value)
		{
			$this->params[':' . $field] = $value;
		}

		return $sql;
	}

	public function compileWhereLike()
	{
		$sql = '';
		$char = '';
		$whereNum = count($this->whereLike['column']);
		$whereLike = $this->whereLike;

		if($whereNum > 1)
		{
			$sql .= 'WHERE ';
			for($i = 0; $i < $whereNum; $i++)
			{
				$sql .= $whereLike['column'][$i] . ' LIKE :' . $whereLike['column'][$i];

				if ($whereLike['pos'][$i] == 'first')
				{
					$char = $whereLike['char'][$i] . '%';
				}
				else if ($whereLike['pos'][$i] == 'last')
				{
					$char = '%' . $whereLike['char'][$i];
				}
				else if ($whereLike['pos'][$i] == 'middle')
				{
					$char = '%' . $whereLike['char'][$i] . '%';
				}
				else
				{
					$char = $whereLike['char'][$i];
				}

				$this->params[':' . $whereLike['column'][$i]] = $char;
			}
		}
		else if($whereNum == 1)
		{
			$sql .= 'WHERE ';
			$sql .= $whereLike['column'][0] . ' LIKE :' . $whereLike['column'][0];

			if ($whereLike['pos'][0] == 'first')
			{
				$char = $whereLike['char'][0] . '%';
			}
			else if ($whereLike['pos'][0] == 'last')
			{
				$char = '%' . $whereLike['char'][0];
			}
			else if ($whereLike['pos'][0] == 'middle')
			{
				$char = '%' . $whereLike['char'][0] . '%';
			}
			else
			{
				$char = $whereLike['char'][0];
			}

			$this->params[':' . $whereLike['column'][0]] = $char;	
		}

		return $sql;
	}

	public function compileWhere()
	{
		$sql = '';

		if(!empty($this->where))
		{
			$whereNum = count($this->where['column']);
			$where = $this->where;

			if($whereNum > 1)
			{
				$sql .= 'WHERE ';
				for($i = 0; $i < $whereNum; $i++)
				{
					$sql .= $where['column'][$i] . ' ' . $where['operator'][$i] . ' :' . $where['column'][$i] . ' AND ';
					$this->params[$where['column'][$i]] = $where['value'][$i];		
				}

				$sql = rtrim($sql, ' AND :');
			}
			else if($whereNum == 1)
			{
				$sql .= 'WHERE ';
				$sql .= $where['column'][0] . ' ' . $where['operator'][0] . ' :' . $where['column'][0];
				$this->params[':' . $where['column'][0]] = $where['value'][0];		
			}
		}

		//check if there is OR where
		return $sql;
	}

	public function compileWhereBetween()
	{
		$sql = '';
		$whereBetween = $this->whereBetween;

		if(!empty($whereBetween))
		{
			$sql .= 'WHERE ';
			$sql .= $whereBetween['column'] . ' BETWEEN ';
			$sql .= $whereBetween['min'] . ' AND ';
			$sql .= $whereBetween['max'];
		}

		return $sql;
	}

	public function compileWhereIn()
	{
		$sql = '';
		$whereIn = $this->whereIn;
		$field = array_keys($whereIn);

		if(count($whereIn))
		{
			$sql .= 'WHERE ';
			$sql .= $field[0] . ' IN (';

			if(is_array($whereIn[$field[0]]))
			{
				$sql .= "'" . implode("', '", $whereIn[$field[0]]) . "'";
			}
			else
			{
				$sql .= "'" . $whereIn[$field[0]] . "'";
			}

			$sql .= ')';
		}

		return $sql;
	}

	public function compileFrom()
	{
		$sql = 'FROM ' . $this->table . ' ';

		return $sql;
	}

	public function compileColumns()
	{
		if (is_array($this->columns)) 
		{
			$sql = implode(', ', $this->columns) . ' ';
		}
		else
		{
			$sql = '* ';
		}

		return $sql;
	}

	public function compileOrderBy()
	{
		$sql = '';

		if(!empty($this->orderBy))
		{
			$sql = ' ORDER BY ' . $this->orderBy;
		}

		return $sql;
	}
}