<?php namespace App\Controllers;

class BlogController extends BaseController
{
	public $user;

	public function __construct()
	{
		parent::__construct();
		$this->user = $this->model('\App\Models\User');
	}

	public function createAction()
	{
		$users = $this->user->findAll();

		$this->view->template('blog.index')
					->with('users', $users)
					->render();
		
	}

	public function storeAction()
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