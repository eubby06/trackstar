<?php namespace Core\Helper;

use Symfony\Component\HttpFoundation\Session\Session as SymfonySession;

class Session
{
	public $session;

	public function __construct(SymfonySession $session)
	{
		$this->session = $session;
	}

	public function setFlash($name, $value)
	{
		$this->session->getFlashBag()->add($name, $value);
	}

	public function getFlash($name)
	{
		$response = '';

		foreach ($this->session->getFlashBag()->get($name, array()) as $message) {
				
			    $response = '<div class="flash-warning">'.$message.'</div>';
			}

		$this->session->getFlashBag()->clear();
		return $response;
	}

	public function setError($errors)
	{
		$this->session->getFlashBag()->add('errors', $errors);
	}

	public function getErrors()
	{
		$response = '<ul>';

		foreach ($this->session->getFlashBag()->get('errors', array()) as $errors) {
				
			    foreach($errors as $error)
			    {
			    	$response .= '<li class="flash-warning">'.$error.'</li>';
			    }
			}

		$response .= '</ul>';
				
		$this->session->getFlashBag()->clear();
		return $response;
	}

	public function has($key)
	{
		if($this->session->getFlashBag()->has($key))
		{
			return true;
		}

		return false;
	}

	public function __get($key)
	{
		if($this->has($key))
		{
			if($key == 'errors')
			{
				return $this->getErrors();
			}
			else
			{
				return $this->getFlash($key);
			}
		}
	}
}