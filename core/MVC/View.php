<?php namespace Core\MVC;

class View
{	
	public $template;
	public $data;

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
		$this->template  = PATH_VIEW . preg_replace('/[\.]/', '/', $filename) . '.php';

		return $this;
	}

	public function with($var, $data)
	{
		$this->data[$var] = $data;

		return $this;
	}
}