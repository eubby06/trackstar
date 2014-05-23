<?php namespace Core\MVC;

use Core\Helper\Input;
use Core\Helper\Session;

class Controller
{	
	protected $view;
	protected $objects = array();
	public $input;
	public $session;

	public function __construct()
	{
		$this->view = new View();
		$this->input = new Input();
		$this->session = new Session();
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
}