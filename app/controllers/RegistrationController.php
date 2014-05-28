<?php namespace App\Controllers;

class RegistrationController extends BaseController
{

	public function __construct()
	{
		parent::__construct();
		$this->user = $this->model('\App\Models\User');
	}

	public function getIndex()
	{
		echo 'success';
	}

	public function getRegister()
	{
		$this->view->template('registration.form')->render();
	}

	public function postRegister()
	{
		$data = array(
			'firstname' => $this->input->get('firstname'),
			'lastname' 	=> $this->input->get('lastname'),
			'email' 	=> $this->input->get('email'),
			'username' 	=> $this->input->get('username'),
			'password' 	=> $this->input->get('password')
		);

		if($this->user->validate($data))
		{
			$user = $this->user->create($data);

			$this->session->setFlash('success', 'User has been created.');		
			$this->redirect('/');
		}
		else
		{
			$this->session->setError($this->user->validator->errors());
			$this->redirect('register');
		}
	}
}