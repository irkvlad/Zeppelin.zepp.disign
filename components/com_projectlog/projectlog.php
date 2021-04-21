<?php
/**
*    Управление Проектами 2013
*    Автор Irkvlad irkvlad@hotmail.com
*    https://www.instagram.com/loshchilovvladimir
*    Copyright DC ZePPelin
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

require_once(JPATH_COMPONENT . DS . 'controller.php');
require_once(JPATH_COMPONENT . DS . 'helpers' . DS .'html.helper.php');

$controller = new projectlogController();
$controller->execute(JRequest::getVar('view'));

$controller->redirect();

?>

