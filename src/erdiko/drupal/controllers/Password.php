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
class Password extends \erdiko\core\Controller
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
	 * Post
	 *
	 * @param mixed $var
	 * @return mixed
	 */
	public function post($var = null)
	{
		// error_log("var: $var");
		if(!empty($var))
		{
			// load action based off of naming conventions
			return $this->_autoaction($var, 'post');

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
	 * Drupal get login example
	 */
	public function getReset()
	{
	
		$drupal = new \erdiko\drupal\Model;

		\module_load_include('inc', 'user', 'user.pages');
		$elements = \drupal_get_form('user_pass');
		$form = \drupal_render($elements);

		$this->setContent($form);

	}

	/**
	 * Drupal get login example
	 */
	public function postReset()
	{
		//var_dump($_POST);
		$drupal = new \erdiko\drupal\Model;

		// Load required include files for requesting user's password
		  \module_load_include('inc', 'user', 'user.pages');
		 
		  // Fill form_state.
		  $form_state['values']['name'] = $_POST['name'];
		  $form_state['values']['op'] = 'E-mail new password';
		 
		  // Execute the register form.
		  \drupal_form_submit('user_pass', $form_state);
		 
		  if ($errors = form_get_errors()) {
		    // The supplied name is neither a username nor an email address.
		    return service_error(implode(" ", $errors), 406, array('form_errors' => $errors));
		  }
		  else {
		    // Requesting new password has been successful.
		    $this->setContent('Email sent');

		  }

	}

}


