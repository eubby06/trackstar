<?php namespace Core\MVC;

use Core\Template\ColonEngine;

class View
{	
	public $template;
	public $data;
	public $parser;

	public function __construct()
	{
		$this->parser = new ColonEngine();
	}

	public function render()
	{

		if(file_exists($this->template))
		{
			foreach($this->data as $key => $value)
			{
				$$key = $value;
			}

			include $this->template;
		}
	}

	public function template($filename)
	{
		if ( $this->isCE($filename) ) {

			$file  = PATH_VIEW . preg_replace('/[\.]/', '/', $filename) . '.ce.php';

			$this->template = $this->parser->parse($file);

		} else {

			$this->template  = PATH_VIEW . preg_replace('/[\.]/', '/', $filename) . '.php';
		}

		return $this;
	}

	public function with($var, $data)
	{
		$this->data[$var] = $data;

		return $this;
	}

	// check if the file is ColonEngine Template
	public function isCE($filename)
	{
		$file  = PATH_VIEW . preg_replace('/[\.]/', '/', $filename) . '.php';

		if (file_exists($file)) {
			return false;
		}

		return true;
	}
}