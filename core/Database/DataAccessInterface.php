<?php namespace Core\Database;

interface DataAccessInterface
{
	public function process($sql, $params = array(), $allRows = false);

	public function statement();

	public function raw($sql);

	public function prepare($sql);

	public function execute($params = array());

	public function fetch();

	public function fetchAll();
}