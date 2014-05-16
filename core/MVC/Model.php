<?php namespace Core\MVC;

use Core\Service\Validator;

class Model extends \Core\Database\TSModelAbstract
{
	public $validator;
	public $rules = array();
	public $attributes = array();

	public function __construct()
	{
		parent::__construct();
		$this->validator = new Validator($this->rules, $this->attributes);
	}
}