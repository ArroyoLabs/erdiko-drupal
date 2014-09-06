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
			if(is_numeric($var))
				return $this->getUserProfile($var);
			// load action based off of naming conventions
			return $this->_autoaction($var, 'get');

		} else {
			return $this->getIndex();
		}
	}

	/**
	 * Get User Profile
	 *
	 * @param mixed $var
	 * @return mixed
	 */
	public function getUserProfile($var)
	{
		$user = new \erdiko\drupal\models\User;

		$profile = $user->user_load($var); // user_load(uid) returns the complete array
		$content = \drupal_render($user->user_view($profile));
		$content .= "<pre>".print_r($profile, true)."</pre>";

		$this->setContent( $content );
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
	public function getLogin()
	{
		// @todo http://stackoverflow.com/questions/11995551/drupal-render-login-form-programatically
		
		$drupal = new \erdiko\drupal\Model;

		$elements = $drupal->drupal_get_form("user_login"); 
		$form = \drupal_render($elements);

		$this->setContent($form);

	}

	/**
	 * Drupal get login example
	 */
	public function postLogin()
	{
		$drupal = new \erdiko\drupal\Model;

		$elements = $drupal->drupal_get_form("user_login"); 
		$form = \drupal_render($elements);

		$this->setContent($form);
	}

	/**
	 * Drupal get Register example
	 */
	public function getRegister()
	{
		$user = new \erdiko\drupal\models\User;
		
		//Create user Programmatically
		/*
		$form = array(
		    "name" => "testUser4",
		    "password" => "testtest",
		    "email" => "test@test.com",
		    "password" => "testtest",
		);

		$content = $user->createUser($form);
		$content .= "<pre>".print_r($elements, true)."</pre>";
		*/
		
		//Using Form
		$elements = $user->drupal_get_form("user_register_form"); 
		$form = \drupal_render($elements);

		$this->setContent($form);
	}

	public function postRegister()
	{
		$user = new \erdiko\drupal\models\User;

		if(\user_load_by_name($_POST['name']))
		{
			echo ("User exists!!");
		}
		else
		{
			$account = user_save('', $_POST);
		}

		$content .= "<pre>".print_r($_POST, true)."</pre>";

		$this->setContent($content);
	}

	/**
	 * Drupal delete users example
	 *
	 * This function is commented out because it is too dangerous
	 */
	/*
	public function getDeleteUser()
	{
		$user = new \erdiko\drupal\models\User;

		$nid = '3';
		\user_delete($nid);

		$this->setContent($content);
	}
	*/

	/**
	 * Drupal get all users example
	 */
	public function getAllUser()
	{
		$user = new \erdiko\drupal\models\User;

		$content = $user->getAllUsers();

		$this->setContent($content);
	}

	/**
	 * Drupal get all users example
	 */
	public function postAllUser()
	{
		//$user = new \erdiko\drupal\models\User;

		//$content = $user->getAllUsers();

		$this->setContent("Hello");
	}


	/**
	 * Drupal logout example
	 */
	public function getLogout()
	{
		$drupal = new \erdiko\drupal\models\User;
		$drupal->logout();
	}

}


