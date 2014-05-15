<?php namespace Core\MVC;

class Controller
{	
	protected $view;
	protected $objects = array();

	public function __construct()
	{
		$this->view = new View();
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