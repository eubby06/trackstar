<?php namespace App\Controllers;

class RegistrationController extends BaseController
{

	public function __construct()
	{
		parent::__construct();
		//$this->user = $this->model('\App\Models\User');
	}

	public function formAction()
	{
		$this->view->template('registration.form')->render();
	}
}