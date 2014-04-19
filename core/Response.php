<?php namespace Core;

// prevent this file from being accessed directly
if (!defined('IN_FRAMEWORK')) exit;

/**
 * Request Class
 */
class Response {

	private $registry = null;

	public function __construct(Registry $registry)
	{
		$this->registry = $registry;
	}
}