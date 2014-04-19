<?php namespace Core;

// prevent this file from being accessed directly
if (!defined('IN_FRAMEWORK')) exit;

/**
 * Request Class
 */
class Request {

	private $registry = null;

	public $url_elements;
	public $verb;
	public $format;
	public $path_info;
	public $parameters;

	public function __construct(Registry $registry)
	{

		$this->registry = $registry;

		$this->verb = $_SERVER['REQUEST_METHOD'];
		$this->path_info = ltrim($_SERVER['PATH_INFO'], '/');
		$this->url_elements = explode('/', $this->path_info);

		$this->parseIncomingParams();

		//initialize json as default format
		$this->format = 'json';
		
		if(isset($this->parameters['format']))
		{
			$this->format = $this->parameters['format'];
		}
	}

	public function parseIncomingParams()
	{
		$parameters = array();

		// first of all, pull the GET vars
		if(isset($_SERVER['QUERY_STRING'])) 
		{
			parse_str($_SERVER['QUERY_STRING'], $parameters);
		}

		//now how about PUT/POST bodies, these override what we got from GET
		$body = file_get_contents("php://input");
		$content_type = false;

		if(isset($_SERVER['CONTENT_TYPE']))
		{
			$content_type = $_SERVER['CONTENT_TYPE'];
		}

		switch($content_type)
		{
			case "application/json":
				$body_params = json_decode($body);

				if($body_params) 
				{
					foreach($body_params as $param_name => $param_value)
					{
						$parameters[$param_name] = $param_value;
					}
				}
				$this->format = "json";
				break;

			case "application/x-www-form-urlencoded":
				parse_str($body, $postvars);
				foreach($postvars as $field => $value)
				{
					$parameters[$field] = $value;
				}
				$this->format = "html";
				break;

			default:
				// parse other formats
				break;
		}

		$this->parameters = $parameters;
	}

	public function getPathInfo()
	{
		return $this->path_info ? $this->path_info : null;
	}

	public function getVerb()
	{
		return $this->verb;
	}

	public function getController()
	{
		return isset($this->url_elements[0]) ? $this->url_elements[0] : 'index';
	}

	public function getMethod()
	{
		return isset($this->url_elements[1]) ? $this->url_elements[1] : 'index';
	}

	public function getParams()
	{
		return array_slice($this->url_elements, 2);
	}
}