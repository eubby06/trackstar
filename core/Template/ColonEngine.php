<?php namespace Core\Template;

class ColonEngine
{
	public $masterPath;
	public $masterSections = array();
	public $parsedMaster;
	public $templatePaths = array();
	public $templateSections = array();
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
print_r($content);
		// get and set master
		$ceMaster = $this->findMaster($content);
		$this->setMaster($ceMaster);

		// get and set master sections
		
		// get and set template sections
		$ceSections = $this->findSections($content);
		$templateSections = $ceSections;

		// then parse altogether

		$callback = function($value, $key) {

			$this->parseTemplate($value);

		};

		array_walk($this->templatePaths, $callback);

		// return the parsed template
	}

	public function findMaster($content)
	{
		preg_match('/:master:\(\'.+\'\)/', $content, $match);

		if ($match) {
			$master = substr(preg_replace('/:master:\(\'/', '', $match[0]), 0, -2);

			return $master;		
		}

		return false;
	}

	public function findSections($content)
	{
		$sections = array();

		preg_match('/:section:\(\'.+\'\)/', $content, $matches);

		//get section name
		if($matches)
		{
			foreach($matches as $match)
			{
				$sections[] = substr(preg_replace('/:section:\(\'/', '', $match), 0, -2);
			}
		}

		return $sections;
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