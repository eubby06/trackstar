<?php namespace Core\Service;

use Core\App;
use Core\Database\TSSQLQuery as Query;
use Core\Database\TSPDODataAccess as DataAccess;

class Validator
{
	public $rules = array();
	public $attributes = array();
	public $errors = array();

	public function __construct($rules = array(), $attributes = array())
	{
		$this->rules = array_merge($this->rules, $rules);
		$this->attributes = array_merge($this->attributes, $attributes);
	}

	public function validate()
	{
		$callback = function($value, $field){

			$rule = $this->rules[$field];
			$rules = explode('|', $rule);

			foreach($rules as $rule)
			{
				if(strpos($rule, ':') !== false) {

					list($newrule, $optval) = explode(':', $rule);

					$this->$newrule($value, $field, $optval);

				} else {

					$this->$rule($value, $field);
				}
			}
		
		};

		array_walk($this->attributes, $callback);
	}

	public function passes()
	{
		if(count($this->errors) > 0)
		{
			return false;
		}

		return true;
	}

	public function fails()
	{
		if(count($this->errors) == 0)
		{
			return true;
		}

		return false;
	}

	public function errors()
	{
		return $this->errors;
	}

	protected function required($value, $field)
	{
		if ( $value == '' || is_null($value) || empty($value) ) {
			
			$this->errors[$field] = 'This field is required';

			return false;
		}
	}

	protected function numeric($value, $field)
	{
		if (!is_numeric($value)) {
			$this->errors[$field] = 'This field must be numeric';
			return false;
		}
	}

	protected function max($value, $field, $max)
	{

		if(strlen($value) > $max) {
			$this->errors[$field] = 'This field should not exceed ' . $max . ' characters.';
			return false;
		}
	}

	protected function min($value, $field, $min)
	{
		if(strlen($value) < $min)
		{
			$this->errors[$field] = 'This field should contain at least ' . $min . ' characters.';
			return false;		
		}
	}

	protected function unique($value, $field, $table)
	{
		$container 	= App::getContainer();
		$query = new Query($container['dataAccess']);

		$record = $query->select($field)
					->from($table)
					->where($field,'=',$value)
					->get();

		if(!empty($record)) {
			$this->errors[$field] = 'This field must be unique.';
			return false;	
		}
	}

	protected function email($value, $field)
	{
		if( !filter_var($value, FILTER_VALIDATE_EMAIL)) {
			$this->errors[$field] = 'This email is not a valid email address.';
			return false;	
		}
	}

}