<?php namespace Core\Helper;

class Html
{
	public $markup;
	public $html;
	public $head;
	public $title;
	public $body = array();

	public function start()
	{
		$this->htmlStart = '<html>' . PHP_EOL;
		$this->htmlEnd = '</html>';

		return $this;
	}

	public function title($title)
	{
		$this->head = '<head><title>' . $title . '</title></head>';
		return $this;
	}

	public function body($callback)
	{
		$div = new Div();

		$this->body = '<body>' . $callback($div) . '</body>';
		return $this;
	}

	public function render()
	{
		echo $this->htmlStart;

		echo $this->head;

		echo $this->body;

		echo $this->htmlEnd;
	}
}

class Div
{
	public $class;

	public function name($class)
	{
		$this->class = $class;
		return $this;
	}

	public function render()
	{
		return '<div class="' . $this->class . '"></div>';
	}
}