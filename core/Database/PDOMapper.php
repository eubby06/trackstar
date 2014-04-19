<?php namespace Core\Database;

use PDO, PDOException;

class PDOMapper implements MapperInterface
{
	protected static $PDO;

	protected $query;

	public $registry;

	public function __construct(\Core\Registry $registry)
	{
		$this->registry = $registry;
		$this->connect();
	}

	public function connect()
	{
		if(!isset(self::$PDO))
		{
			$dsn = $this->registry->getSetting('DSN');

			if (is_null($dsn))
			{
				throw new PDOException('No DSN');
			}

			$dbname 	= $dsn['dbname'];
			$username	= $dsn['username'];
			$password 	= $dsn['password'];

			self::$PDO = new PDO("mysql:dbname={$dbname}", "{$username}", "{$password}");
			self::$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	}

	public function query($sql)
	{
		$this->query = self::$PDO->query($sql);
	}

	public function fetch()
	{
		return $this->query->fetch(PDO::FETCH_ASSOC);
	}
}