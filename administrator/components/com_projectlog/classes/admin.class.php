<?php
/*
 * Copyright (c) 2021.
 * Лощилов Владимир Геннадьевич
 * https://www.instagram.com/loshchilovvladimir
 * mailto://irkvlad@hotmail.com
 */

 
defined('_JEXEC') or die('Restricted access');

class projectlogAdmin {

	function _getversion()
	{
		$xmlfile = JPATH_COMPONENT_ADMINISTRATOR.DS.'projectlog.xml';
		if (file_exists($xmlfile)) {
			$xmlDoc = new JSimpleXML();
			$xmlDoc->loadFile($xmlfile);
			return $xmlDoc->document->version[0]->_data;
		}
	}
	
	function footer( )
	{		
		echo '<div align="center"><a href="http://www.thethinkery.net" target="_blank">Project Log v.';
		echo projectlogAdmin::_getversion();		
		echo ' by The Thinkery LLC</a></div>';
	}
}

?>