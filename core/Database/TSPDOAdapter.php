<?php namespace Core\Database;

use PDO, PDOException;

class TSPDOAdapter implements AdapterInterface
{
	protected $pdo;

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

	public function query($sql, $params = array(), $allRows = true)
	{
		$result;

		if (empty($params)) 
		{
			$statement = $this->pdo->query($sql);
		}
		else
		{

			$statement = $this->pdo->prepare($sql);
			$statement->execute($params);			
		}

		if($allRows) 
		{
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
			$result = $statement->fetch(PDO::FETCH_ASSOC);
		}

		return $result;
	}

	public function execute($sql, $params = array())
	{

		$statement = $this->pdo->prepare($sql);
		$statement->execute($params);

		return; 
	}

}