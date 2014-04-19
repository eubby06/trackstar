<?php namespace Core\Database;

interface MapperInterface
{
	public function connect();

	public function fetch();

	public function query($sql);
}