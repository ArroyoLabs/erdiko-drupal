<?php
/**
 * Drupal bootstrap
 * Assumes Drupal is installed in the vendor folder in the /lib/drupal folder.
 * 
 * @category  	erdiko
 * @package   	drupal
 * @copyright 	Copyright (c) 2014, Arroyo Labs, http://www.arroyolabs.com
 * @author		John Arroyo, john@arroyolabs.com
 */

/*
// Prevent this from running under a webserver (for unit testing only)
if (array_key_exists('REQUEST_METHOD', $_SERVER)) 
{
	echo 'This page is not accessible from a browser.';
	exit(1);
}
*/

// Set the working directory and required Drupal 7 server variables
define('DRUPAL_ROOT', dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))).'/lib/drupal');
chdir(DRUPAL_ROOT);

$_SERVER['REQUEST_METHOD'] = 'get'; // @todo do a check for method first
$_SERVER['REMOTE_ADDR'] = '127.0.0.1'; // @todo do a check for address

require_once DRUPAL_ROOT.'/includes/bootstrap.inc';

drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
