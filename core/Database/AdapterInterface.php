<?php namespace Core\Database;

interface AdapterInterface
{
	public function execute($sql, $params = array());
}