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
	 * Test url variable routing 
	 */
	public function getReset($var1 = null, $var2 = null, $var3 = null)
	{
		$var = [$var1, $var2, $var3];
		//$content = "<pre>".print_r($var, true)."</pre>";
		
		$drupal = new \erdiko\drupal\models\User;
		\module_load_include('inc', 'user', 'user.pages');
		
		//global $user;
		$account = \user_load($var1);
  		$output = \drupal_render(\drupal_get_form('user_profile_form', $account));
		
		$this->setContent($output);
		
	}


	public function postReset()
	{
		$drupal = new \erdiko\drupal\models\User;

		$account = \user_load_by_mail($_POST['mail']);
		$edit = array();

		if($_POST['pass']['pass1'] == $_POST['pass']['pass2'])
		{
			$edit['pass'] = $_POST['pass']['pass1'];
			\user_save($account, $edit);
			$this->setContent('Your password was successfully changed.');
		}
		else
		{
			$this->setContent('The password and confirmation password do not match.');
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
	public function getPasswordReset()
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
	public function postPasswordReset()
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


