<?php namespace Core\Helper;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Input
{
	public $request;

	public function __construct()
	{
		$this->request = SymfonyRequest::createFromGlobals();
	}

	public function get($var)
	{
		return $this->request->get($var);
	}

	public function all()
	{
		return $this->request->request;
	}
}