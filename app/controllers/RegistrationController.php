<?php namespace App\Controllers;

class RegistrationController extends BaseController
{

	public function __construct()
	{
		parent::__construct();
		$this->user = $this->model('\App\Models\User');
	}

	public function getRegister()
	{
		$this->view->template('registration.form')->render();
	}

	public function postRegister()
	{
		$username = $this->input->get('username');
		$password = $this->input->get('password');

		$data = array(
			'username' => $username,
			'password' => $password
			);

		if($this->user->validate($data))
		{
			$user = $this->user->create($data);

			$this->session->setFlash('success', 'User has been created.');		
		}
		else
		{
			$this->session->setError($this->user->validator->errors());
		}

		$this->redirect('create');
	}
}