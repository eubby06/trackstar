<?php namespace App\Controllers;

class BlogController extends BaseController
{
	public $user;

	public function __construct()
	{
		parent::__construct();
		$this->user = $this->model('\App\Models\User');
	}

	public function indexAction()
	{

		$users = $this->user->findAll();

		$users->each(function($user)
		{
			echo $user->username;
		});

		$this->view->template('blog.index')
					->with('users', $users)
					->render();
					
	}

	public function viewAction($param)
	{
		echo 'view = ';
		echo $param;
	}
}