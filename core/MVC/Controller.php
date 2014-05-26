<?php namespace Core\MVC;

use Symfony\Component\HttpFoundation\RedirectResponse;
use App;

class Controller
{	
	protected $view;
	protected $objects = array();
	public $input;
	public $session;
	public $container;

	public function __construct()
	{
		$this->container = App::getContainer();

		$this->view = $this->container['view'];
		$this->input = $this->container['input'];
		$this->session = $this->container['session'];
	}

	protected function model($name)
	{
		$id = serialize($name);

		if ( !isset($this->objects[$id]) )
		{
			$this->objects[$id] = new $name();
		}

		return $this->objects[$id];
	}

	protected function redirect($url)
	{
		$response = new RedirectResponse($url);

		$response->send();
	}
}