<?php namespace Core\Database;

class MysqlGrammar
{

	protected $selectComponents = array(
		'action',
		'aggregate',
		'columns',
		'from',
		'joins',
		'wheres',
		'groups',
		'havings',
		'orders',
		'limit',
		'offset',
		'unions',
		'lock',
	);

	public function compile(QueryBuilder $query)
	{
		return $this->concatenate($this->compileSelectComponents($query));
	}

	public function compileSelectComponents(QueryBuilder $query)
	{
		$sql = array();

		foreach($this->selectComponents as $component)
		{
			if(!is_null($query->$component))
			{
				$method = 'compile'.ucfirst($component);
				$sql[$component] = $this->$method($query->$component);
			}
		}	

		return $sql;
	}

	public function compileColumns($component)
	{
		return implode(', ', $component);
	}

	public function compileAction($component)
	{
		return $component;
	}

	public function compileFrom($component)
	{
		return 'from '.$component;
	}

	public function compileWheres($component)
	{
		$sql = 'where ';

		foreach($component as $where)
		{
			$where['value'] = "'" . $where['value'] . "'";
			$sql .= implode(' ', $where);
		}

		return $sql;
	}

	public function concatenate($sql)
	{
		return implode(' ', $sql);
	}
}