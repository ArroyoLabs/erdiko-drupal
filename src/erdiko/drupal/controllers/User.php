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
		$drupalUser = $user->user_load($var); // user_load(uid) returns the complete array
		$content = $user->renderProfile($drupalUser);

		$content .= "<pre>".print_r($drupalUser, true)."</pre>"; // this is the raw drupal user data

		$this->setTitle($drupalUser->name);
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
		$this->setTitle('User Examples');
		// $this->addView('examples/index');
		$content = $this->getView('user_index', null, dirname(__DIR__));
		$this->setContent($content);
	}

	/**
	 * Drupal get login example
	 */
	public function getLogin()
	{
		$drupal = new \erdiko\drupal\Model;

		$elements = $drupal->drupal_get_form("user_login"); 
		$form = \drupal_render($elements);

		$this->setContent($form);
	}

	/**
	 * Drupal get login2 example (bootstrap form)
	 */
	public function getLogin2()
	{
		$drupal = new \erdiko\drupal\Model;
		$elements = $drupal->drupal_get_form("user_login");
		$content = $this->getView('login', array('build_id' => $elements['#build_id']), dirname(__DIR__));

		$this->setContent($content);
		// $this->setContent( "<pre>".print_r($elements, true)."<pre>");
	}

	/**
	 * Drupal get login example
	 */
	public function postLogin()
	{
		$drupal = new \erdiko\drupal\Model;

		/*
		if(\user_load_by_name($_POST['name']) == FALSE)
		{
			if(\user_load_by_mail($_POST['name']) == FALSE)
			{
				$content = \form_set_error('name', t('This username does not exist'));
				$content = $content.'This username does not exist';
			}
		}
		*/

		if(strpos($_POST['name'], '@') === FALSE )
		{
			$user = \user_load_by_name($_POST['name']);

			if($user)
			{
				$success = \user_authenticate($_POST['name'], $_POST['pass']);

				if($success)
				{
					$content = 'Login successful. Welcome '. $_POST['name'];
				}
				else $content = 'Incorrect password.';
			}
			else $content = 'User does not exist.';
		}
		else $content = 'Please enter your user name, not email.';

		if(strpos($content, 'Login successful') === FALSE)
		{
			$elements = $drupal->drupal_get_form("user_login"); 
			$form = \drupal_render($elements);
			$this->setContent($content.' '.$form);
		}
		else $this->setContent($content);

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

		 // Fill form_state.
		  $form_state['values']['name'] = $_POST['name'];
		  $form_state['values']['op'] = 'E-mail new password';
		 
		  // Execute the register form.
		  \drupal_form_submit('user_pass', $form_state);


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
	public function getAll()
	{
		$user = new \erdiko\drupal\models\User;
		$content = "";

		// $content = $user->getAllUsers();

		// @todo update getAllUsers function in User.php
		$query = \db_select('users', 'u');
	    $query->fields('u', array('name', 'uid'));
	    $result = $query->execute();

	    while($record = $result->fetchAssoc()) {
	         $content .= "<p><a href=\"/user/{$record['uid']}\">{$record['name']}</a></p>";
	    }

	    $this->setTitle('All Users');
		$this->setContent($content);
	}

	/**
	 * Drupal logout example
	 */
	public function getLogout()
	{
		$drupal = new \erdiko\drupal\models\User;
		$drupal->logout();

		$this->setContent("You have been logged out.");
	}

}


