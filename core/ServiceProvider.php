<?php namespace Core;

use Core\App;
use Core\Database\TSPDODataAccess as DataAccess;
use Core\Database\TSSQLQuery as Query;

class ServiceProvider
{
	protected $container;

	public function __construct()
	{
		$this->container = App::getContainer();
	}
	public function run()
	{
		$this->register();
	}

	protected function register()
	{
		$this->container['dataAccess'] = function($c) {
			return new DataAccess();
		};
	}
}