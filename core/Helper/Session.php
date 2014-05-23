<?php namespace Core\Helper;

use Symfony\Component\HttpFoundation\Session\Session as SymfonySession;

class Session
{
	public $session;

	public function __construct()
	{
		$this->session = new SymfonySession();
		$this->session->start();
	}

	public function setFlash($name, $value)
	{
		$this->session->getFlashBag()->add($name, $value);
	}

	public function getFlash($name)
	{
		foreach ($this->session->getFlashBag()->get($name, array()) as $message) {
			    return '<div class="flash-warning">'.$message.'</div>';
			}
	}
}