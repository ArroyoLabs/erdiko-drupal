<?php
/**
 * Drupal User
 * 
 * @category  	erdiko
 * @package   	drupal
 * @copyright 	Copyright (c) 2014, Arroyo Labs, http://www.arroyolabs.com
 * @author		John Arroyo, john@arroyolabs.com
 */
namespace erdiko\drupal\models;

use \Erdiko;

class User extends \erdiko\drupal\Model
{	
	protected $_userData;
	protected $_userId = 0;

	const ROLE_ADMINISTRATOR = 3;
	const ROLE_AUTHENTICATED_USER = 2;

	public function setUserData($userData)
	{
		$this->_userData = $userData;
	}

	public function getUserData()
	{
		return $this->_userData;
	}

	public function setUserId($userId)
	{
		$this->_userId = $userId;
	}

	public function getUserId()
	{
		$userId = 0;

		if($this->_userId != 0)
			$userId = $this->_userId;
		elseif($_SESSION['user_id'] > 0)
			$userId = $_SESSION['user_id'];		

		return $userId;
	}

	/**
	 * Render user profile via drupal's theming engine
	 */
	public function renderProfile($user)
	{
		return \drupal_render(\user_view($user));
	}
	
	protected function getUserErrorMessage($errorMessage)
	{
		$userError="";
		switch($errorMessage)
		{
			case(preg_match("/1062/",$errorMessage)?true:false):
				$userError = "Provided email address is already in use.";
				break;
			default:
				$userError = $errorMessage;
		}
		return $userError;
	}

	/**
	 * Create new user
	 * @param array $form
	 */
	public function createUser($form)
	{
		// @todo additional form validate

		// Prepare user data to write to drupal
		$userinfo = array(
      		'init' => $form['email'],
      		'mail' => $form['email'],
      		'pass' => $form['password'],
      		'field_gender' => array(LANGUAGE_NONE =>
			 	array(0 =>
					array('value' => $form['gender']) ) ),
      		'roles' => array(2 => 'authenticated user'),
      		'language' => 'en',
      		'status' => 1
    	);
    	
    	// determine username
    	if(isset($form['name']))
    		$userinfo['name'] = $this->_convertUserName($form['name']);
    	else
    		$userinfo['name'] = $this->_emailToUserName($form['email']);

    	// Save measurements to the db
    	if($_SESSION['user_measurements'])
    	{
    		$userinfo['field_height'] = array(LANGUAGE_NONE =>
				array(0 =>
					array('value' => $_SESSION['user_measurements']['height']) ) );
    		$userinfo['field_weight'] = array(LANGUAGE_NONE =>
				array(0 =>
					array('value' => $_SESSION['user_measurements']['weight']) ) );
    		$userinfo['field_waist'] = array(LANGUAGE_NONE =>
				array(0 =>
					array('value' => $_SESSION['user_measurements']['waist']) ) );
    	}
		
		$success = 0;
		$e = null;

        if(strlen($userinfo['pass']) < 4 || strlen($userinfo['pass'])>12) {
            $account =  array('errorInfo' => "Password's length should be from 4 to 12");
        } else {

            try {

                $account = \user_save(null, $userinfo);

                // see if successful
                if(!empty($account->uid))
                {
                    if(is_numeric($account->uid))
                    {
                        $success = 1;

                        $this->setUserData($account);
                        $this->setUserId($account->uid);
                    }
                }
            } catch (\Exception $e) {
                error_log("e: ".print_r($e, true));
            }
        }

    	$data = array(
    		'success' => $success
    		);

    	// prepare response 
    	// @todo redo to send back flag and load additional data into model object
    	if($success) {
    		$data['user'] = $account;
    	} else {
    		$data['user'] = null;
    		$data['error'] = array();
    		if($e == null)
    			$data['error']['message'] = $this->getUserErrorMessage($account['errorInfo']);
    		else
    			$data['error']['message'] = $this->getUserErrorMessage($e->getMessage());	
    	}

    	return $data;
	}

	/** Check if the string is a valid email */
	public function isEmail($email)
	{
		return filter_var( $email, FILTER_VALIDATE_EMAIL );
	}

	/**
	 * Sanitize username
	 * @todo finsih imeplementing this function
	 */
	protected function _convertUserName($name)
	{
		return trim($name);
	}

	/**
	 *
	 */
	protected function _emailToUserName($email)
	{
		$username = preg_replace('/[^\x{80}-\x{F7} a-z0-9@_.\'-]/i', '-', trim($email));
		return $username;
	}

	/**
	 * get drupal username from email address (users:name)
	 * @param string $email
	 * @return string $name
	 */
	public function getUserName($email)
	{
 		$query = \db_select('users', 'u');
 		$name = $query->fields('u', array('name'))
 			->condition('u.mail', $email)
 			->execute()
 			->fetchField();

 		// error_log("result: ".print_r($name, true));

  		if($name) {
    		return $name;
  		} else {
    		return null;
  		}
  	}

  	public function getUser($userId)
	{
		try {
			if($userObj = \user_load($userId)) {
      			$this->setUserData($userObj);
      			$this->setUserId($userObj->uid);
      		} else {
      			$this->setError("No user found with id $userId.");
      		}
    	} catch (\Exception $e) {
    		$this->setError($e->getMessage());
    	}
	}

	public function createSession()
	{
		session_start();
		$_SESSION['user_object'] 		= $this->getUserData();
		$_SESSION['user_id']     		= $this->getUserId();
	}

	/**
	 * Login
	 * User can login via username or email
	 * @param string $email, username or email adddress
	 * @return bool $success
	 */
	public function login($email, $password)
	{
		$sucess = 0;

		if( $this->isEmail($email) )
			$username = $this->getUserName($email);
		else
			$username = $email;

		if(\user_authenticate($username, $password)) {
  			$userObj = \user_load_by_name($username);
  			$this->setUserData($userObj);
  			$this->setUserId($userObj->uid);
  			$formState = array();
  			$formState['uid'] = $userObj->uid;      
  			\user_login_submit(array(), $formState);
  			$sucess = 1;
  		} else {
  			throw new \Exception("login failed, bad username or password.");
  		}

    	return $sucess;
	}

	public function updateUser($user)
	{
		
	}

  	public function logout()
  	{
  		// \user_logout(); // drupal logout
  		return session_destroy(); // destroy Erdiko session
  	}

	public static function getIdentity()
	{
    	$identity = array();

        if(!empty($_SESSION['user_object'])) {
    	    $identity = array("user_id" => $_SESSION['user_id'], "user_object" => $_SESSION['user_object']);
        }

        return $identity;
	}
  	
	public function getAllUsers($page = 0, $pagesize = null)
	{
		$sql = "SELECT u.uid as uid, us.id as id, us.user_id as user_id 
			FROM users u
			on user_id = uid
			where uid > 0
			order by uid";

		if($pagesize != null)
			$sql += " LIMIT $page, $pagesize";

		$query = \db_query($sql);
		$collection = $query->fetchAll();

		return $collection;
	}

	// Example of how to save drupal custom fields
    public function saveMeasurementsToDrupal($userId, $measurements)
    {
    	try {
    		// Save measurements to the db
    		if($measurements)
    		{
    			$userinfo['field_height'] = array(LANGUAGE_NONE =>
					array(0 =>
						array('value' => $measurements['height']) ) );
    			$userinfo['field_weight'] = array(LANGUAGE_NONE =>
					array(0 =>
						array('value' => $measurements['weight']) ) );
    			$userinfo['field_waist'] = array(LANGUAGE_NONE =>
					array(0 =>
						array('value' => $measurements['waist']) ) );
    		}

    		$user = \user_save((object) array('uid' => $userId), $userinfo);
    		return $user;

    	} catch (\Exception $e) {
    		$this->setError($e->getMessage());
    		// error_log("drupal error: ".$e->getMessage());
    	}
    }
}
