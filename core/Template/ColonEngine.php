<?php namespace Core\Template;

class ColonEngine
{
	public $master;
	public $masterYields = array();
	public $parsedMaster;
	public $templatePaths = array();
	public $templateSections = array();
	public $includes = array();
	public $includesTemplate = array();
	public $parsedTemplates = array();
	public $finalTemplate;
	protected $page;
	protected $compiled;
	protected $compilers = array('Includes','Echos','Openings','Closings','Assignments');


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

	public function setIncludes($includes)
	{
		$this->includes = array_merge($this->includes, $includes);
	}

	public function setTemplate($templatePath)
	{
		$this->templatePaths[] = $templatePath;
		return $this;
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

		// get and set includes
		$masterIncludes = $this->findIncludes($masterContent);
		$contentIncludes = $this->findIncludes($content);
		$this->setIncludes($masterIncludes);
		$this->setIncludes($contentIncludes);
		$this->getIncludesTemplate();

		// get and set template sections
		$templateSections = $this->findSections($content);
		$this->setSections($templateSections);

		// then parse altogether
		$this->_parse();

		return $this->compiled;
	}

	protected function _store()
	{
		// write to file
		$file = PATH_STORAGE . 'compiled.php';

		file_put_contents($file, $this->page);

		$this->compiled = $file;
	}

	protected function _parse()
	{
		$this->_replaceYieldWithSection();
		$this->_compile();
		$this->_store();
	}

	protected function _replaceYieldWithSection()
	{
		$content = $this->getContent($this->master);

		$content = str_replace(array("\r", "\n"), " ", $content);

		$nospaces = preg_replace("/\s+/", " ", $content);

		$callback = function($section, $index) use(&$nospaces)
		{
			$nospaces = preg_replace('/::yield\(\''.$section.'\'\)/', $this->templateSections[$section], $nospaces);
			return $nospaces;
		};

		array_walk($this->masterYields, $callback);

		$this->page = $nospaces;
	}

	protected function _replaceIncludes()
	{
		$content = $this->page;

		$callback = function($include, $index) use(&$content)
		{
			$content = preg_replace('/::include\(\''.$include.'\'\)/', $this->includesTemplate[$include], $content);
			return $content;
		};

		array_walk($this->includes, $callback);

		$this->page = $content;
	}

	// replacing with php tags
	protected function _compile()
	{

		foreach($this->compilers as $compiler)
		{
			$this->{"_replace$compiler"}();
		}
	}

	//replace closing tag
	protected function _replaceEchos()
	{
		$this->page = preg_replace("/::(\\$[a-zA-Z_][a-zA-Z\-\>_0-9]+)/", '<?php echo $1; ?>', $this->page);
	}

	//replace closing tag
	protected function _replaceClosings()
	{
		$this->page = preg_replace("/::(endforeach|endif|endwhile)/", '<?php $1; ?>', $this->page);
	}

	//replace assignment
	protected function _replaceAssignments()
	{
		$this->page = preg_replace("/::([a-zA-Z_][a-z]+\s\=\s\'.+\')/U", '<?php $$1; ?>', $this->page);
	}

	//replace closing tag
	protected function _replaceOpenings()
	{
		$this->page = preg_replace("/::(foreach|if|while|elseif)\((.+\))\)/U", '<?php $1($2): ?>', $this->page);
		$this->page = preg_replace("/::(foreach|if|while|elseif)\((.+)\)/U", '<?php $1($2): ?>', $this->page);
		$this->page = preg_replace("/::(else)/", '<?php $1: ?>', $this->page);
	}

	public function findMaster($content)
	{
		preg_match('/::master\(\'.+\'\)/', $content, $match);

		if ($match) {
			$master = substr(preg_replace('/::master\(\'/', '', $match[0]), 0, -2);

			return $master;		
		}

		return false;
	}

	public function findSections($content)
	{
		$sections = array();

		preg_match_all('/::section\(\'.+\'\)/', $content, $matches);

		$matches = array_shift($matches);

		//get section name
		if($matches)
		{
			foreach($matches as $match)
			{
				$section = substr(preg_replace('/::section\(\'/', '', $match), 0, -2);
				$sections[$section] = $this->getSectionContent($content, $section);
			}
		}

		return $sections;
	}

	public function findYields($content)
	{
		$yields = array();

		preg_match_all('/::yield\(\'.+\'\)/', $content, $matches);

		$matches = array_shift($matches);

		//get yield name
		if($matches)
		{
			foreach($matches as $match)
			{
				$yields[] = substr(preg_replace('/::yield\(\'/', '', $match), 0, -2);
			}
		}

		return $yields;
	}

	public function findIncludes($content)
	{
		$includes = array();

		preg_match_all('/::include\(\'.+\'\)/', $content, $matches);

		$matches = array_shift($matches);

		//get yield name
		if($matches)
		{
			foreach($matches as $match)
			{
				$includes[] = substr(preg_replace('/::include\(\'/', '', $match), 0, -2);
			}
		}

		return $includes;
	}

	public function getSectionContent($content, $section)
	{
		
		$content = str_replace(array("\r", "\n"), " ", $content);

		$nospaces = preg_replace("/\s+/", " ", $content);

		preg_match('/::section\(\''.$section.'\'\)(.+)::end(\s|\W)/U', $nospaces, $matches);

		return isset($matches[1]) ? $matches[1] : false;
	}

	public function getIncludesTemplate()
	{
		foreach($this->includes as $key => $value)
		{
			$this->includesTemplate[$value] = $this->getContent($value);
		}
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