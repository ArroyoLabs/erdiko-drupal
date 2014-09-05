<?php
/**
 * Example Drupal User Controller
 * Contains some ways you can leverage Drupal in erdiko
 *
 * @category 	erdiko
 * @package   	drupal
 * @copyright	Copyright (c) 2014, Arroyo Labs, www.arroyolabs.com
 * @author 		John Arroyo, john@arroyolabs.com
 */
namespace erdiko\drupal\controllers;

/**
 * Example Controller Class
 */
class User extends \erdiko\core\Controller
{
	/** Before */
	public function _before()
	{
		$this->setThemeName('bootstrap');
		$this->prepareTheme();
	}

	/**
	 * Get
	 *
	 * @param mixed $var
	 * @return mixed
	 */
	public function get($var = null)
	{
		// error_log("var: $var");
		if(!empty($var))
		{
			// load action based off of naming conventions
			return $this->_autoaction($var, 'get');

		} else {
			return $this->getIndex();
		}
	}

	/**
	 * Homepage Action (index)
	 */
	public function getIndex()
	{	
		// Add page data
		$this->setTitle('Examples');
		$this->addView('examples/index');
	}

	/**
	 * Drupal login example
	 */
	public function getLogin()
	{
		// @todo http://stackoverflow.com/questions/11995551/drupal-render-login-form-programatically
	}
}