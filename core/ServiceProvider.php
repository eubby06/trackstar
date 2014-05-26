<?php namespace Core;

use Core\App;
use Core\Router\Request;
use Core\Database\TSPDODataAccess as DataAccess;
use Core\Database\TSSQLQuery as Query;
use Core\Helper\Input;
use Core\Helper\Html;
use Core\Helper\Session;
use Core\MVC\View;
use Core\Template\ColonEngine;
use Symfony\Component\HttpFoundation\Session\Session as SymfonySession;


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
		$this->aliases();
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

		$this->container['input'] = function($c) {
			return new Input();
		};

		$this->container['session'] = function($c) {

			$symfonySession = new SymfonySession();

			return new Session($symfonySession);
		};
		
		$this->container['colon.engine'] = function($c) {
			return new ColonEngine();
		};

		$this->container['view'] = function($c) {
			return new View($c);
		};

		$this->container['config'] = function($c) {
			include_once PATH_CONFIG . 'app.php';

			return $config;
		};
	}

	protected function aliases()
	{
		class_alias('\\Core\\App', 'App');
		class_alias('\\Core\\Helper\\Html', 'HTML');
		class_alias('\\Core\\Helper\\Form', 'FORM');
	}
}