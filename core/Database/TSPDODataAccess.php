<?php namespace Core\Database;

use PDO, PDOException;

class TSPDODataAccess implements DataAccessInterface
{
	protected $pdo;
	protected $statement;
	protected $result = array();

	public function __construct()
	{
		try
		{
			$this->pdo = new PDO('mysql:dbname=framework;host=127.0.0.1', 'admin', 'admin');
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e)
		{
			trigger_error('Caught: ' . $e->getMessage());
		}
		
	}

	public function process($sql, $params = array(), $allRows = false)
	{

		$this->prepare($sql);

		!empty($params) ? $this->execute($params) : $this->raw($sql);

		$allRows ? $this->fetchAll() : $this->fetch();
		
	}

	public function statement()
	{
		return $this->statement;
	}

	public function raw($sql)
	{
		$this->statement = $this->pdo->query($sql);
	}

	public function prepare($sql)
	{
		$this->statement = $this->pdo->prepare($sql);
	}

	public function execute($params = array())
	{
		$this->statement->execute($params);
	}

	public function fetch()
	{
		$this->result[] = $this->statement->fetch(PDO::FETCH_ASSOC);
	}

	public function fetchAll()
	{
		$this->result = $this->statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function result()
	{
		return $this->result;
	}
}