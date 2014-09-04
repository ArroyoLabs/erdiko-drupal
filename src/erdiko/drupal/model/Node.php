<?php
/**
 * Drupal Node
 * 
 * @category  	erdiko
 * @package   	drupal
 * @copyright 	Copyright (c) 2014, Arroyo Labs, http://www.arroyolabs.com
 * @author		John Arroyo, john@arroyolabs.com
 */
namespace erdiko\drupal\model;

use \Erdiko;

class Node extends \erdiko\drupal\Model
{	
	/**
	 * Get node by nid or url key
	 * @param mixed $node, options of $nid or $urlKey
	 */
	public function getNode($node)
	{
		// return \node_view(\node_load($nid), 'teaser');
		// return \entity_load('node', array($nid));

		if(is_numeric($node))
			$nid = $node;
		else
		{
			$normal_path = \drupal_get_normal_path($node);
			$nid = str_ireplace("node/",'',$normal_path);
		}

		$node = \node_load($nid);
		// error_log("nid: $nid");
		// error_log("node: ".print_r($node, true));
		
		return $node;
	}
	
	/**
	 * Get path alias of a drupal node (by $nid)
	 * @param int $nid
	 * @return string $alias
	 */
	function getPathAlias($nid)
	{
	    $path = 'node/'.$nid;
	    // Check for an alias using drupal_lookup_path()
	    if((drupal_lookup_path('alias', $path)!==false))
	        $alias = drupal_lookup_path('alias', $path);

	    return $alias;
	}
}