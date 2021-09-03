<?php
/**
*    Управление Проектами 2013
*    Автор Irkvlad irkvlad@hotmail.com
*    https://www.instagram.com/loshchilovvladimir
*    Copyright DC ZePPelin
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class projectlogViewcat extends JView
{
		var $db  ; //= &JFactory::getDBO();
		var $user; //= &JFactory::getUser();

	function display($tpl = null)
	{
		global $option, $mainframe;
		JHTML::_('behavior.tooltip');
		JHTML::_('behavior.modal', 'a.modal');

		$db   = &JFactory::getDBO();
		$user = &JFactory::getUser();
		$query = 'SELECT * FROM #__users WHERE id = ' . $user->id;
		$db->setQuery($query);
		$userDop = $db->loadObject();/**/
		$contactDetalis = projectlogHTML::userDetails($user->id);
		$user->dol_user = $contactDetalis->catid;
		$user->pochta_chek = $userDop->pochta_chek;

		$this->baseurl = JURI::base();
		$document      = &JFactory::getDocument();
		$settings      = &JComponentHelper::getParams('com_projectlog');
		$pathway       = &$mainframe->getPathway();
		$document->addStyleSheet($this->baseurl . '/components/com_projectlog/assets/css/projectlog.css');
		$document->addStyleSheet($this->baseurl . '/components/com_projectlog/assets/css/helptext.css');

		$model      = &$this->getModel();

		$catinfo    = &$this->get('data');
		$usercolor  = $model->getUserColor();
		$projects   = &$this->get('projects');
		$pagination = &$this->get('Pagination');
		$logo       = &$this->get('Logo');
		$doc_path   = 'media/com_projectlog/docs/';
		$brak       = &$this->get('Brak');
		$filter_set = "";
		$filter_design_set = "";
		if( IS_MANAGER ) $filter_set = "4";
		if( IS_DESIGNER ) $filter_design_set = $user->id;

		$lists = array();

		$filter_order     = $mainframe->getUserStateFromRequest($option . '.cat.filter_order', 'filter_order', 'p.release_date', 'cmd');
		$filter_order_dir = $mainframe->getUserStateFromRequest($option . '.cat.filter_order_dir', 'filter_order_Dir', 'DESC', 'word');
		$filter           = $mainframe->getUserStateFromRequest($option . '.cat.filter', 'filter', $filter_set, 'int');
		$filter_design    = $mainframe->getUserStateFromRequest($option . '.cat.filter_design', 'filter_design', $filter_design_set, 'int');
		$search           = $mainframe->getUserStateFromRequest($option . '.cat.search', 'search', '', 'string');
		$search           = $db->getEscaped(trim(JString::strtolower($search)));

		$filters   = array();
		$filters[] = JHTML::_('select.option', '1', JText::_('PROJECT NAME'));
		$filters[] = JHTML::_('select.option', '2', JText::_('RELEASE NUM'));
		if ($catinfo->id <> 5) $filters[] = JHTML::_('select.option', '3', JText::_('Бригадир'));
		if ($user->id <> 0) $filters[] = JHTML::_('select.option', '4', JText::_('RELEASE MANEGER'));
		                      //JHTML::_('select.genericlist', $chief_list, 'filter_design', 'size="1" class="inputbox"', 'value', 'text', $filter_design);
		$lists['filter']    = JHTML::_('select.genericlist', $filters,    'filter',        'size="1" class="inputbox"', 'value', 'text', $filter);
		$lists['search']    = $search;
		$lists['order']     = $filter_order;
		$lists['order_Dir'] = $filter_order_dir;

		//==========  Список  Менеджер  ================================================================
		$db =& JFactory::getDBO();// Получаем объект базы данных
		$query = "SELECT c.user_id AS value, c.name AS text FROM #__contact_details AS c WHERE (c.catid=3 ) AND c.published=1 AND c.company <> 2";// Формируем запрос (OR c.catid=4)
		$db->setQuery($query);// Выполняем запрос
		$categorylist = $db->loadObjectList();// Получаем массив объектов
		$categories[] = JHTML::_('select.option', '', "Выберите менеджера", 'value', 'text');// Создаём первый элемент выпадающего списка (<option value="0">Выберите категорию</option>)
		$categories = array_merge($categories, $categorylist);// Добавляем массив данных из базы данных
		$manager_list = JHTML::_(
			'select.genericlist' /* тип элемента формы */,
			$categories /* массив, каждый элемент которого содержит value и текст */,
			'manager' /* id и name select`a формы */,
			'size="1" required' /* другие атрибуты элемента select class="inputbox" */,
			'value' /* название поля в массиве объектов содержащего ключ */,
			'text' /* название поля в массиве объектов содержащего значение */,
			$user->id /* value элемента, который должен быть выбран (selected) по умолчанию */,
			'manager' /* id select'a формы */,
			true /* пропускать ли элементы полей text через JText::_(), default = false */
		);// Получаем выпадающий список
		//==========  список  технолог  ================================================================
		$db    =& JFactory::getDBO();
		$query = "SELECT c.user_id AS value, c.name AS text FROM #__contact_details AS c WHERE (c.catid=13 ) AND c.published=1";
		$db->setQuery($query);
		$categorylist     = $db->loadObjectList();
		$categories       = $categorie = array();
		$categories[]     = JHTML::_('select.option', '', "Выберите технолога", 'value', 'text');
		$categories       = array_merge($categories, $categorylist);
		$technicians_list = $categories;
		//==========  список  дизайнер ================================================================
		$db    =& JFactory::getDBO();
		$query = "SELECT c.user_id AS value, c.name AS text FROM #__contact_details AS c WHERE (c.catid=12 ) AND c.published = 1 ";
		$db->setQuery($query);
		$categorylist = $db->loadObjectList();
		$categories   = $categorie = array();
		$categories[] = JHTML::_('select.option', '', "Выберите дизайнера", 'value', 'text');
		$categories   = array_merge($categories, $categorylist);
		$chief_list   = $categories;

		$lists['filter_design'] = JHTML::_('select.genericlist', $chief_list, 'filter_design', 'size="1" class="inputbox"', 'value', 'text', $filter_design); //, 'filter_design', true
		if ($user->id <> 0){
			// проекты, выполнение которых по угрозой
			$query = "SELECT * FROM #__projectlog_projects WHERE ( manager = " . $user->id . " ) AND ( category = 13)";
			$db->setQuery($query);
			$projectStop = $db->loadObjectList();
			//**** просроченные в изготовлении  проекты
			$d     = new DateTime(date('Y-m-d'));
			if ($user->id == 97){
				$query = "SELECT * FROM #__projectlog_projects WHERE  ( category = 8) AND ( release_date <  '" . $d->format("Y-m-d") . "');";
			}
			else {
				$query = "SELECT * FROM #__projectlog_projects WHERE ( manager = " . $user->id . " ) AND ( category = 8) AND ( release_date <  '" . $d->format("Y-m-d") . "' );";
			}
			$db->setQuery($query);
			$projectSrok = $db->loadObjectList();
			//***** проекты, которые по настоящее время не приняты в работу
			$d     = new DateTime(date('Y-m-d'));
			$d->modify("-2 day");
			$query = "SELECT * FROM #__projectlog_projects WHERE ( category = 7) AND ( deployment_to <  '" . $d->format("Y-m-d") . "' );";
			$db->setQuery($query);
			$projectAUT = $db->loadObjectList();
			//**** Клиенты которым не звонили ***********
			$db     = JFactory::getDBO();
			$query  = "SELECT * FROM #__zepp_client WHERE ( modifer_user = " . $user->id . " )  AND ( send = 1 ) AND ( on_send < '" . date('Y-m-d') . "' )";
			$db->setQuery($query);
			$client = $db->loadObjectList();
		}

		$this->assignRef('projectStop', $projectStop);
		$this->assignRef('client', $client);
		$this->assignRef('projectAUT', $projectAUT);
		$this->assignRef('projectSrok', $projectSrok);
		$this->assignRef('catinfo', $catinfo);
		$this->assignRef('projects', $projects);
		$this->assignRef('lists', $lists);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('settings', $settings);
		$this->assignRef('user', $user);
		$this->assignRef('logo', $logo);
		$this->assignRef('document', $document);
		$this->assignRef('doc_path', $doc_path);
		$this->assignRef('usercolor', $usercolor);
		$this->assignRef('manager_list', $manager_list);
		$this->assignRef('technicians_list', $technicians_list);
		$this->assignRef('chief_list', $chief_list);
		$this->assignRef('brak', $brak);

		parent::display($tpl);
	}


}

?>
