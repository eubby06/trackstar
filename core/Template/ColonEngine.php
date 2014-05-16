<?php namespace Core\Template;

class ColonEngine
{
	public $masterPath;
	public $parsedMaster;
	public $templatePaths = array();
	public $parsedTemplates = array();
	public $finalTemplate;

	public function setMaster($masterPath)
	{
		$this->master = $masterPath;
		return $this;
	}

	public function setTemplate($templatePath)
	{
		$this->templatePaths[] = $templatePath;
		return $this;
	}

	public function parseTemplate($template)
	{
		// get content

		// start parsing
	}

	public function parse($file)
	{
		// scan and get associated templates
		$content = $this->getContent($file);

		// get and set master
		$ceMaster = $this->findMaster($content);

		print_r($ceMaster);

		// set partial templates

		// then parse altogether

		$callback = function($value, $key) {

			$this->parseTemplate($value);

		};

		array_walk($this->templatePaths, $callback);

		// return the parsed template
	}

	public function findMaster($content)
	{
		return preg_match('/main/', $content);
	}

	public function getContent($templatePath)
	{
		// return content
		if( file_exists($templatePath) )
		{
			$content = file_get_contents($templatePath);
			return $content;
		}

		trigger_error('This file does not exist!');
	}
}