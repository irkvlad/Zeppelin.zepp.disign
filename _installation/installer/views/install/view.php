<?php
/**
 * @version		$Id: view.php 9764 2007-12-30 07:48:11Z ircmaxell $
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

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * @package		Joomla
 * @subpackage	Installation
 */

jimport('joomla.application.component.view');

class JInstallationView extends JView
{
	/**
	 * The installation steps
	 *
	 * @var		array
	 * @access	protected
	 * @since	1.5
	 */
	var $_steps		= null;

	/**
	 * The templabe object
	 *
	 * @var		object
	 * @access	protected
	 * @since	1.5
	 */
	var $_template		= null;

	/**
	 * Create a template object
	 *
	 * @return	boolean True if successful
	 * @access	private
	 * @since	1.5
	 */
	function _createTemplate( $bodyHtml = null, $mainHtml = 'page.html' )
	{

		jimport('joomla.template.template');

		$this->_template = new JTemplate();
		$this->_template->applyInputFilter('ShortModifiers');

		// load the wrapper and common templates
		$this->_template->setRoot( JPATH_BASE . DS . 'template' . DS. 'tmpl' );
		$this->_template->readTemplatesFromFile( $mainHtml );

		if ($bodyHtml) {
			$this->_template->setAttribute( 'body', 'src', $bodyHtml );
		}
	}
	
	/**
	 * Get the template object
	 *
	 * @param	string The name of the body html file
	 * @return	patTemplate
	 * @access	protected
	 * @since	1.5
	 */
	function & getTemplate( $bodyHtml = null )
	{
		static $current;

		$change	= false;

		// Record the current template body
		if ( is_null($current) && $bodyHtml)
		{
			$current	= $bodyHtml;
			$change		= true;
		}

		// Check if we need to create the body, possibly anew
		if ( is_null( $this->_template) || $change )
		{
			$this->_createTemplate($bodyHtml);
		}

		return $this->_template;
	}
	
	/**
	 * Get the installation steps
	 *
	 * @return	array
	 * @access	protected
	 * @since	1.5
	 */
	function & getSteps()
	{
		if ( is_null($this->_steps) )
		{
			$this->_steps = array(
				'lang' => 'off',
				'preinstall' => 'off',
				'license' => 'off',
				'dbconfig' => 'off',
				'ftpconfig' => 'off',
				'mainconfig' => 'off',
				'finish' => 'off'
			);
		}

		return $this->_steps;
	}

	/**
	 * Display the template
	 *
	 * @return	boolean True if successful
	 * @access	public
	 * @since	1.5
	 */
	function display()
	{
		$model	=& $this->getModel();
		$tmpl	=& $this->getTemplate();
		$lang	=& JFactory::getLanguage();
		$vars	=& $model->getVars();

		$tmpl->addVar( 'buttons', 'direction', $lang->isRTL() ? 'rtl' : 'ltr');
		$tmpl->addVar( 'body', 'lang', $lang->getTag() );
		$tmpl->addVars( 'body', $vars, 'var_' );

		echo $tmpl->fetch( 'page' );

		return true;
	}

/* ============================================================================================= */

	/**
	 * Report an error to the user
	 *
	 * @return	boolean True if successful
	 * @access	public
	 * @since	1.5
	 */
	function error()
	{
		$steps	=& $this->getSteps();
		$model	=& $this->getModel();
		$vars	=& $model->getVars();
		$tmpl	=& $this->getTemplate( 'error.html' );

		$msg	= $model->getError();
		$back	= $model->getData('back');
		$xmsg	= $model->getData('errors');

		$tmpl->addVars( 'stepbar', $steps, 		'step_' );
		$tmpl->addVar( 'messages', 'message', 	$msg );

		if ($xmsg) {
			$tmpl->addVar( 'xmessages', 'xmessage', $xmsg );
		}

		$tmpl->addVar( 'buttons', 'back', $back );
		$tmpl->addVars( 'body', $vars, 'var_' );

		return $this->display();
	}

	/**
	 * Language page
	 *
	 * @return	boolean True if successful
	 * @access	public
	 * @since	1.5
	 */
	function chooseLanguage()
	{
		$steps	=& $this->getSteps();

		$model	=& $this->getModel();
		$lists	=& $model->getData('lists');

		$tmpl	=& $this->getTemplate( 'language.html' );

		$steps['lang'] = 'on';

		$tmpl->addVars( 'stepbar', $steps, 'step_' );
		$tmpl->addRows( 'lang-options', $lists['langs'] );

		return $this->display();
	}
		
	/**
	 * The the pre-install info page
	 *
	 * @return	boolean True if successful
	 * @access	public
	 * @since	1.5
	 */
	function preInstall()
	{
		$steps	=& $this->getSteps();
		$model	=& $this->getModel();
		$lists	=& $model->getData('lists');

		$version	= new JVersion();
		$tmpl		=& $this->getTemplate( 'preinstall.html' );

		$steps['preinstall'] = 'on';

		$tmpl->addVars( 'stepbar', 	$steps, 	'step_' );
		$tmpl->addVar( 'body', 		'version', 	$version->getLongVersion() );

		$tmpl->addRows( 'php-options', 	$lists['phpOptions'] );
		$tmpl->addRows( 'php-settings', $lists['phpSettings'] );

		return $this->display();
	}
	
	/**
	 * The license page
	 *
	 * @return	boolean True if successful
	 * @access	public
	 * @since	1.5
	 */
	function license()
	{
		$steps	=& $this->getSteps();
		$model	=& $this->getModel();
		$tmpl	=& $this->getTemplate( 'license.html' );

		$steps['license'] = 'on';

		$tmpl->addVars( 'stepbar', 	$steps, 'step_' );

		return $this->display();
	}
	
	/**
	 * The DB Config page
	 *
	 * @return	boolean True if successful
	 * @access	public
	 * @since	1.5
	 */
	function dbConfig()
	{
		$steps	=& $this->getSteps();
		$model	=& $this->getModel();
		$lists	=& $model->getData('lists');
		$tmpl	=& $this->getTemplate( 'dbconfig.html' );

		$steps['dbconfig'] = 'on';

		$tmpl->addVars( 'stepbar', $steps, 'step_' );
		$tmpl->addRows( 'dbtype-options', $lists['dbTypes'] );

		return $this->display();
	}
	
	function mainDatabaseRestore() {
		$steps	=& $this->getSteps();
		$model	=& $this->getModel();

		$tmpl		=& $this->getTemplate( 'restore.html' );
		$scriptpath =& $model->getData('scriptpath');
		$tmpl->addVars( 'stepbar', 	$steps, 	'step_' );
		$tmpl->addVar( 'buttons', 'previous', $model->getData('back'));
		$tmpl->addVar( 'buttons', 'next', $model->getData('next'));
		$tmpl->addVar( 'autobuttons', 'next', $model->getData('next'));

		$steps	=& $this->getSteps();
		$steps['dbconfig'] = 'on';
		
		return $this->display();
	}
	
	/**
	 * The extra DB Config page
	 *
	 * @return	boolean True if successful
	 * @access	public
	 * @since	1.5
	 */
	function extradbConfig()
	{
		$steps	=& $this->getSteps();
		$model	=& $this->getModel();
		$lists	=& $model->getData('lists');
		$tmpl	=& $this->getTemplate( 'extradbconfig.html' );

		$steps['dbconfig'] = 'on';

		$tmpl->addVars( 'stepbar', $steps, 'step_' );
		$tmpl->addRows( 'dbtype-options', $lists['dbTypes'] );
		$tmpl->addVar( 'buttons', 'back', $model->getData('back'));
		$tmpl->addVar( 'buttons', 'next', $model->getData('next'));
		$tmpl->addVar( 'buttons2', 'next', $model->getData('next'));

		return $this->display();
	}

	function extraDatabaseRestore() {
		$steps	=& $this->getSteps();
		$model	=& $this->getModel();

		$tmpl		=& $this->getTemplate( 'extrarestore.html' );
		$scriptpath =& $model->getData('scriptpath');
		$tmpl->addVars( 'stepbar', 	$steps, 	'step_' );
		$tmpl->addVar( 'buttons', 'previous', $model->getData('back'));
		$tmpl->addVar( 'buttons', 'next', $model->getData('next'));
		$tmpl->addVar( 'autobuttons', 'next', $model->getData('next'));

		$steps	=& $this->getSteps();
		$steps['dbconfig'] = 'on';
		
		return $this->display();
	}


	/**
	 * Show the FTP config page
	 *
	 * @return	boolean True if successful
	 * @access	public
	 * @since	1.5
	 */
	function ftpConfig()
	{
		$steps	=& $this->getSteps();
		$model	=& $this->getModel();

		$tmpl =& $this->getTemplate( 'ftpconfig.html' );

		$steps['ftpconfig'] = 'on';

		$tmpl->addVars( 'stepbar', $steps, 'step_' );
		
		return $this->display();
	}

	/**
	 * The main configuration page
	 *
	 * @return	boolean True if successful
	 * @access	public
	 * @since	1.5
	 */
	function mainConfig()
	{
		$steps	=& $this->getSteps();
		$model	=& $this->getModel();
		$tmpl	=& $this->getTemplate( 'mainconfig.html' );

		$steps['mainconfig'] = 'on';

		$tmpl->addVars( 'stepbar', $steps, 'step_' );

		$tmpl->addVar( 'buttons', 'previous', 'ftpconfig');
		//		$tmpl->addRows( 'folder-perms', $lists['folderPerms'] );

		return $this->display();
	}
	
	/**
	 * The final page
	 *
	 * @return	boolean True if successful
	 * @access	public
	 * @since	1.5
	 */
	function finish()
	{
		$steps	=& $this->getSteps();
		$model	=& $this->getModel();
		$vars	=& $model->getVars();
		$tmpl	=& $this->getTemplate( 'finish.html' );

		$buffer	= $model->getData('buffer');

		$steps['finish'] = 'on';

		$tmpl->addVars( 'stepbar', $steps, 'step_' );

		if ($buffer) {
			$tmpl->addVar( 'configuration-error', 'buffer', $buffer );
		}

		return $this->display();
	}

}

?>