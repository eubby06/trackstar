<?php namespace App\Controllers;

use Core\Controller;

class TestController extends Controller 
{
	
	public function getIndex()
	{
		$userModel = new \App\Models\UserModel($this->db_adapter);
		$users = $userModel->findAll();

		foreach($users as $user)
		{
			echo 'username: ' . $user->username . '<br />';
			$user->username = 'findme2';
			$user->update();
			echo 'username: ' . $user->username . '<br />';
		}

	}

	public function getCreate()
	{
		echo 'display form';
	}
}