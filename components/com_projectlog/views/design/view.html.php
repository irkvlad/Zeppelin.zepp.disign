<?php
/**
 *  Вид для проекитов дизайна
 *
 *    Управление Проектами 2013
 *    Автор Irkvlad irkvlad@hotmail.com
 *    https://www.instagram.com/loshchilovvladimir
 *    Copyright DC ZePPelin
 **/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class projectlogViewdesign extends JView
{
	function display($tpl = null){
        global $option;
        JHTML::_('behavior.tooltip');
        $user = JFactory::getUser();
        $user_grup =projectlogHTML::getUserGrup();

        //$settings      = &JComponentHelper::getParams('com_projectlog');
        $document      = &JFactory::getDocument();
        $this->baseurl = JURI::base();
        $document->addStyleSheet($this->baseurl . '/components/com_projectlog/assets/css/projectlog.css');

        $model   = &$this->getModel();
        $designProjects = &$this->get('data');
        $designer = $this->get('Designer');
        $projects = $this->get('project');
        $maxDate = $this->get('MaxDateInProects');
        $toDate = JHTML::date('now');
        $end_projects = $this->get('ProjectOnEnd');

        $this->assignRef('designProjects', $designProjects);
        $this->assignRef('end_projects', $end_projects);
        $this->assignRef('designer', $designer);
        $this->assignRef('projects', $projects);
        $this->assignRef('user', $user);
        $this->assignRef('user_grup', $user_grup);
        $this->assignRef('maxDate', $maxDate);
        $this->assignRef('toDate', $toDate);

		parent::display($tpl);
	}


}


