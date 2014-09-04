<?php
/**
 * Drupal Nodequeue
 * 
 * @category  	erdiko
 * @package   	drupal
 * @copyright 	Copyright (c) 2014, Arroyo Labs, http://www.arroyolabs.com
 * @author		John Arroyo, john@arroyolabs.com
 */
namespace erdiko\drupal\model;

use \Erdiko;

class Nodequeue extends \erdiko\drupal\Model
{	
	
	/**
	 * Get nodeque by id
	 */
	public function getNodeQueue($id, $backward = FALSE, $from = 0, $count = 20)
	{
		return \nodequeue_load_nodes($id, $backward, $from, $count);
	}
	
	/**
	 * 
	 */
	public function getNodequeueView($id)
	{
		$viewName = 'nodequeue_'.$id;	
		$view = \views_get_view_result($viewName);
		$nodes = array();
		
		foreach($view as $node)
		{
			$nodes[] = $this->getNode($node->nid);
		}
		
		return $nodes;
	}	
	
	/**
	 * 
	 */
	public function getArrayFromNodeQueue($data)
	{
		// get the pertinent info from the NodeQueue object
		$formated = $data;
		
		return $formated;
	}
}