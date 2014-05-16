<?php namespace Core\Database;

use PDO, PDOException;
use Core\App;

class TSPDODataAccess implements DataAccessInterface
{
	protected $pdo;
	protected $statement;
	protected $result = array();

	public function __construct()
	{
		try
		{
			$container = App::getContainer();
			$config = $container['config'];

			$driver = $config['database']['driver'];
			$dbname = $config['database']['dbname'];
			$host = $config['database']['host'];
			$username = $config['database']['username'];
			$password = $config['database']['password'];

			$this->pdo = new PDO(''.$driver.':dbname='.$dbname.';host='.$host.'', ''.$username.'', ''.$password.'');
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

		$explodedSql = explode(' ', $sql);

		if ($explodedSql[0] == 'SELECT') {

			$allRows ? $this->fetchAll() : $this->fetch();
		}
		else {

			$this->result = $this->affectedRows();
		}

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

	public function affectedRows()
	{
		return $this->statement->rowCount();
	}

	public function fetch()
	{
		$this->result = $this->statement->fetch(PDO::FETCH_ASSOC);
	}

	public function fetchAll()
	{

		$this->result = $this->statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function result()
	{
		$result = $this->result;

		$this->result = array();

		return $result;
	}
}