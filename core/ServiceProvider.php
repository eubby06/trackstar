<?php namespace Core;

use Core\App;
use Core\Router\Request;
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
		include PATH_APP . DS . 'route.php';
		$this->register();
	}

	protected function register()
	{
		$this->container['dataAccess'] = function($c) {
			return new DataAccess();
		};

		$this->container['query'] = $this->container->factory(function ($c) {
		    return new Query($this->container['dataAccess']);
		});

		$this->container['request'] = function($c) {
			return new Request();
		};

		$this->container['config'] = function($c) {
			include_once PATH_CONFIG . 'app.php';

			return $config;
		};
	}
}