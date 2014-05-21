<?php namespace Core\Template;

class ColonEngine
{
	public $master;
	public $masterYields = array();
	public $parsedMaster;
	public $templatePaths = array();
	public $templateSections = array();
	public $parsedTemplates = array();
	public $finalTemplate;
	protected $page;
	protected $compiled;


	public function setMaster($masterPath)
	{
		$this->master = $masterPath;
		return $this;
	}

	public function setYields($yields)
	{
		$this->masterYields = $yields;
	}

	public function setSections($sections)
	{
		$this->templateSections = $sections;
	}

	public function setTemplate($templatePath)
	{
		$this->templatePaths[] = $templatePath;
		return $this;
	}

	public function parseSection($section)
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
		$this->setMaster($ceMaster);

		// get and set master sections
		$masterContent = $this->getContent($ceMaster);
		$ceMasterYields = $this->findYields($masterContent);
		$this->setYields($ceMasterYields);

		// get and set template sections
		$templateSections = $this->findSections($content);
		$this->setSections($templateSections);

		// then parse altogether
		$this->_parse();

		return $this->compiled;
	}

	protected function _compile()
	{
		// write to file
		$file = PATH_VIEW . 'compiled.php';

		file_put_contents($file, $this->page);

		$this->compiled = $file;
	}

	protected function _parse()
	{
		$this->_replaceYieldWithSection();
		$this->_replaceWithPHPTags();
		$this->_finalizeTemplate();
		$this->_compile();
	}

	protected function _replaceYieldWithSection()
	{
		$content = $this->getContent($this->master);

		$content = str_replace(array("\r", "\n"), " ", $content);

		$nospaces = preg_replace("/\s+/", " ", $content);

		$callback = function($section, $index) use(&$nospaces)
		{
			$nospaces = preg_replace('/:yield:\(\''.$section.'\'\)/', $this->templateSections[$section], $nospaces);
			return $nospaces;
		};

		array_walk($this->masterYields, $callback);

		$this->page = $nospaces;
	}

	protected function _replaceWithPHPTags()
	{
		//replace opening tag
		$this->page = preg_replace('/:c:/', '<?=', $this->page);

		//replace closing tag
		$this->page = preg_replace('/:e:/', '?>', $this->page);

		//replace closing tag
		$this->page = preg_replace('/:e:/', '?>', $this->page);

		//replace endforeach
		$this->page = preg_replace('/::endforeach/', '<?php endforeach; ?>', $this->page);

		//for foreach control
		preg_match_all('/::foreach\((.+)\)/U', $this->page, $foreach);

		$insideForeach = $foreach[1];

		$numberOfForeach = count($foreach[1]);
		$currentTemplate = $this->page;

		$callback = function($each, $index) use(&$currentTemplate) {

			$currentTemplate = str_replace('::foreach('.$each.')', '<?php foreach('.$each.') : ?>', $currentTemplate);

			return $currentTemplate;
		};

		array_walk($insideForeach, $callback);

		$this->page = $currentTemplate;
	}

	protected function _finalizeTemplate()
	{

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

		preg_match_all('/:section:\(\'.+\'\)/', $content, $matches);

		$matches = array_shift($matches);

		//get section name
		if($matches)
		{
			foreach($matches as $match)
			{
				$section = substr(preg_replace('/:section:\(\'/', '', $match), 0, -2);
				$sections[$section] = $this->getSectionContent($content, $section);
			}
		}

		return $sections;
	}

	public function findYields($content)
	{
		$yields = array();

		preg_match_all('/:yield:\(\'.+\'\)/', $content, $matches);

		$matches = array_shift($matches);

		//get yield name
		if($matches)
		{
			foreach($matches as $match)
			{
				$yields[] = substr(preg_replace('/:yield:\(\'/', '', $match), 0, -2);
			}
		}

		return $yields;
	}

	public function getSectionContent($content, $section)
	{
		
		$content = str_replace(array("\r", "\n"), " ", $content);

		$nospaces = preg_replace("/\s+/", " ", $content);

		preg_match('/:section:\(\''.$section.'\'\)(.+):end:(.|\s|\z)/U', $nospaces, $matches);

		return isset($matches[1]) ? $matches[1] : false;
	}

	public function getContent($templatePath)
	{
		// return content
		if( file_exists($templatePath) )
		{
			$content = file_get_contents($templatePath);
			return $content;
		}
		else
		{
			$file  = PATH_VIEW . preg_replace('/[\.]/', '/', $templatePath) . '.ce.php';

			if( file_exists($file) )
			{
				$content = file_get_contents($file);
				return $content;
			}

			trigger_error('This file does not exist!');
		}
		
	}
}