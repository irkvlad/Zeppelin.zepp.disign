<?php

/**
 * @version		$Id: installer.php 9764 2007-12-30 07:48:11Z ircmaxell $
 * @package		Joomla
 * @subpackage	Installation
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

defined('_JEXEC') or die('Restricted access');

$here	= dirname(__FILE__);
require_once( $here.DS.'controller.php');
require_once( $here.DS.'helper.php');

// Get the controller
$config = array();

// check on proper task:
// lang for installation
$config['default_task']	= 'lang';

$controller	= new JInstallationController($config);
$controller->initialize();

// Set some paths
$controller->addViewPath ( $here.DS.'views'  );
$controller->addModelPath( $here.DS.'models' );

// Process the request
$task = JRequest::getCmd( 'task' );
$controller->execute( $task );