<?php
/**
 *
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.controller' );

class projectlogController extends JController
{
	var $debug = true;
	function __construct()
	{
		parent::__construct();
	}

	function display()
	{
        $user 		= & JFactory::getUser();
        $document	= & JFactory::getDocument();
        if( !JRequest::getVar('view')):
            JRequest::setVar( 'view', 'projects' );
        endif;

        parent::display();
	}
}

