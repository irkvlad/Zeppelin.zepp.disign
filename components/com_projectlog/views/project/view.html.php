<?php
/**
 *      Формирование данных для вида Project
 *
 *    Управление Проектами 2013
 *    Автор Irkvlad irkvlad@hotmail.com
 *    https://www.instagram.com/loshchilovvladimir
 *    Copyright DC ZePPelin
 **/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('No access');
jimport('joomla.application.component.view');

class ProjectlogViewProject extends JView
{
	function display($tpl = null){
		global $option;
		JHTML::_('behavior.tooltip');
		$user = JFactory::getUser();
        $user_grup =projectlogHTML::getUserGrup();

		$settings      = &JComponentHelper::getParams('com_projectlog');
		$document      = &JFactory::getDocument();
		$this->baseurl = JURI::base();
		$document->addStyleSheet($this->baseurl . '/components/com_projectlog/assets/css/projectlog.css');
		$model   = &$this->getModel();
		$project = &$this->get('data');
		$logs    = &$this->get('logs');
		$docs    = &$this->get('docs');
		$logo    = &$this->get('logo');
		$akts    = &$this->get('akts');
		$document->setTitle($project->title);
		$doc_path = 'media/com_projectlog/docs/';

		//список  бригадиров
		$db    =& JFactory::getDBO();
		$query = "SELECT c.id AS value, c.name AS text FROM #__contact_details AS c WHERE (c.catid=20 ) AND c.published=1";
		$db->setQuery($query);
		$categorylist  = $db->loadObjectList();
		$categories    = array();
		$categories[]  = JHTML::_('select.option', '0', "Выберите бригадира", 'value', 'text');
		$categories    = array_merge($categories, $categorylist);
		$brigadir_list = $categories;

        //список  дизайнеров
        $query = "SELECT c.user_id AS value, c.name AS text FROM #__contact_details AS c WHERE (c.catid=12 ) AND c.published=1";
        $db->setQuery($query);
        $categorylist2  = $db->loadObjectList();
        $categories2    = array();
        $categories2[]  = JHTML::_('select.option', '0', "Выберите дизайнера", 'value', 'text');
        $categories2    = array_merge($categories2, $categorylist2);
        $desiner_list = $categories2;

		// Дизайн
        $query = "SELECT * FROM #__projectlog_design WHERE id_project = $project->id  AND profit > 0";
        $db->setQuery($query);
        $designers  = $db->loadObjectList();
        $master = false;
        $on_design = false;
        foreach ($designers as $designer){
            if( $designer->id_user == $user->id && $designer->master_user) $master = true;
            if( $designer->id_user == $user->id ) $on_design = true;
        }
        // Убрать дизайнеров которые есть в таблице
        for ( $i=0; $i < count($desiner_list);$i++)        {
            foreach ($designers as $ds){
                if($desiner_list[$i]->value == $ds->id_user) unset($desiner_list[$i]);
            }
        }

		$this->assignRef('user', $user);
		$this->assignRef('desiner_list', $desiner_list);
		$this->assignRef('master', $master);
		$this->assignRef('on_design', $on_design);
        $this->assignRef('user_grup', $user_grup);
		$this->assignRef('project', $project);
		$this->assignRef('logs', $logs);
		$this->assignRef('docs', $docs);
		$this->assignRef('akts', $akts);
		$this->assignRef('logo', $logo);
		$this->assignRef('doc_path', $doc_path);
		$this->assignRef('settings', $settings);
		$this->assignRef('brigadir_lis', $brigadir_list);
		$this->assignRef('user_grup', $user_grup);
		$this->assignRef('designers', $designers);


		parent::display($tpl);
	}
}
