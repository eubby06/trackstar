<?php namespace Core\MVC;

class View
{	
	public $template;
	public $data;
	public $parser;
	public $container;

	public function __construct($container)
	{
		$this->parser = $container['colon.engine'];
		$this->container = $container;
	}

	public function render()
	{
		if(file_exists($this->template))
		{
			if($this->data)
			{
				foreach($this->data as $key => $value)
				{
					$$key = $value;
				}			
			}
			
			$session = $this->container['session'];

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