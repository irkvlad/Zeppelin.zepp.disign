<?php
/**
 * @version		$Id: importcsv.php
 * @package		Joomla
 * @subpackage	ImportCSV
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

$params =& JComponentHelper::getParams('com_importcsv');

require_once (JPATH_COMPONENT.DS.'controller.php');
$controller = new ImportCSVController();

// Perform the Request task
$controller->execute(null);

// Redirect if set by the controller
$controller->redirect();
?>
