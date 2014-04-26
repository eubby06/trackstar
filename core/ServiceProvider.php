<?php namespace Core;

use Core\App;
use Core\Database\TSPDOAdapter as Adapter;
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
		$this->container['adapter'] = function($c) {
			return new Adapter();
		};

		$this->container['query'] = function($c) {
			return new Query($c['adapter']);
		};
	}
}