<?php
/**
 * Модель Дизайна
 *
 * Copyright (c) 2021.
 * Лощилов Владимир Геннадьевич
 * https://www.instagram.com/loshchilovvladimir
 * mailto://irkvlad@hotmail.com
 */

defined('_JEXEC') or die('No access');
jimport('joomla.application.component.model');

class ProjectlogModelDesign extends JModel
{
    //var $_id = null;
    var $_id_user = null;
    var $_project = null;
    var $_data = null;
    var $_disigner = null;


    function __construct(){
        parent::__construct();
        global $option;
        $mainframe =& JFactory::getApplication();
        $this->setId();
    }

    function setId(){
        $this->_id_user = JRequest::getInt('id_user', '0');
    }

    function getProjectOnEnd(){
        $time = new DateTime();
        $query = 'SELECT *'
            . ' FROM #__projectlog_design'
            . ' WHERE active = 0 '
            . ' AND profit > 0'
            . ' AND id_user = ' . $this->_id_user
            . ' AND date_end > "' . $time->format("Y-01-01 00:00:00").'"'
            . ' ORDER BY date_end ASC '
        ;
        $this->_db->setQuery($query);
        return $this->_db->loadObjectList();
    }

    /**
     * Запись дизайе-проекты для текущего проекта и текущего пользователя
     * @param int $id текущий проект
     * @param int $userid текущий пользователь
     * @return database|false
     */
    function getThisTable($id = 0, $userid = 0 ){
        if($id == 0) $id = JRequest::getInt('id','0');
        if($userid == 0) $userid   = &JFactory::getUser()->id;
        $query = 'SELECT *'
            . ' FROM #__projectlog_design'
            . ' WHERE active = 1 '
            . ' AND id_project = ' . $id
            . ' AND id_user = ' . $userid
            . ' ORDER BY date_end ASC '
        ;
        $this->_db->setQuery($query);
        $design_project = $this->_db->loadObject();
        $table = JTable::getInstance('projectlog_design', '');
        $table->load($design_project->id);
        return  $table;
    }

    function &getData(){
        if ($this->loadData()){}
        else  $this->_initData();
        return $this->_data;
    }

    function loadData(){
        if (empty($this->_data)){
            //SELECT * FROM jos_projectlog_design WHERE active = 1 AND id_user = 62 ORDER BY date_end ASC
            $query = 'SELECT *'
                . ' FROM #__projectlog_design'
                . ' WHERE active = 1 '
                . ' AND id_user = ' . $this->_id_user
                . ' ORDER BY date_end ASC '
            ;
            $this->_db->setQuery($query);
            $this->_data = $this->_db->loadObjectList();

            return (boolean) $this->_data;
        }
        return true;
    }

    function _initData(){
        if (empty($this->_data)){
            $data               = new stdClass();
            $data->id           = 0;
            $data->id_project   = null;
            $data->id_user      = null;
            $data->date_start   = null;
            $data->date_end     = null;
            $data->on_create    = null;
            $data->on_change    = null;
            $data->profit       = null;
            $data->duration     = null;
            $data->active       = null;
            $data->master_user  = null;
            $this->_data = $data;
            return (boolean) $this->_data;
        }
    }

    function getDesigner(){
        return projectlogHTML::getUserName($this->_id_user);
    }

    function getProject(){
        if($this->_data)   {
            foreach ($this->_data as $data){
                $projects[$data->id]= projectlogHTML::getProject($data->id_project);
                $projects[$data->id]->users = $this->getUsersInDesign($data->id_project);
            }
            return $projects;
        }
        return null;
    }

    /**
     * Создаем новый дизай-проект
     * @return false
     * @throws Exception
     */
    function saveDesignProject(){
        global $mainframe;
        $tz = new DateTimeZone( "Asia/Irkutsk" );
        $time = new DateTime();
        $time->setTimezone( $tz );

        $user   = &JFactory::getUser();// список пользователей
        $post   = JRequest::get('post', JREQUEST_ALLOWRAW);
        $row    = $this->getThisTable();//&$this->getTable('projectlog_design', ''); //подключение таблицы
        $d_date = new DateTime($post['disign_date']);
        $d_end = new DateTime($post['disign_date']);
        $d_end->modify("+".$post['count_days']." day");

        if(!$row->id){
            $data['id' ]  = 0;
            $data['on_create' ]   = date('Y-m-d');
            $data['profit' ]        = 100;
            $data['id_project' ]    = $post['id'];
            $data['id_user' ]       = $user->id;
            $data['on_change' ]     = null;
            $data['master_user' ]   = 1;
        }

        $data['date_start' ]  = $d_date->format("Y-m-d");
        $data['date_end' ]    = $post['disign_end'];
        $data['duration' ]    = $post['count_days'];

        if ( !$this->storeDateInRow($row,$data) ) return false;

        $query = "UPDATE #__projectlog_projects  SET on_designer = 1 WHERE id = " . $post['id'] . " ";
        $this->_db->setQuery($query);
        $col = $this->_db->query();

        // Посьмо исполнителю о дизайн - проекте
        // if (projectlogHTML::getUserPChekc($design_project->id_user) == 1)
        $project = projectlogHTML::getProject($post['id']);
        $link  = JRoute::_('http://zeppelin/zepp/index.php?option=com_projectlog&view=project&id=' . $post['id'], false);
        $body = "Изменения в дизайне проекта №" . projectlogHTML::getProjectNumber($post['id'])
            ." «" . projectlogHTML::getProjectName($post['id'])."» "
            ." дизайнер ". projectlogHTML::getUserName($user->id)
            ." \n<br/>Начанет работу: ". $d_date->format("d.m.Y")
            ." \n<br/>Длительность работ: ". $post['count_days']." дней. До ".$d_end->format("d.m.Y")
            ." \n<br/>Ссылка на проект: <a href='".$link."'>Проект ".projectlogHTML::getprojectname($post['id'])."</a>\n<br/>"
            .$time->format("d.m.Y H:i:s") . "."
        ;
        //$mainframe->getCfg('fromname') $mainframe->getCfg('mailfrom');
        JUtility::sendMail(SITE_EMAIL, SITE_NAME,
            projectlogHTML::userEmail($project->manager),
            projectlogHTML::getUserName($project->manager),
            $body ,
            $modeTXT_HTML="HTML",
            $cc="",
            $bcc="",
            $attachment="",
            $reply_to_email="",
            $reply_to_name=""
        );

        projectlogHTML::savePochta($from_user_id=$user->id,$text=$body,$to_user_id=$project->manager ,$tema = "Проекта взял дизайнер",$project_id=$post['id']);

        return $row->id;
    }

    /**
     * Управление дизайнерами и профитами проекта, если профит нулевой, то дизайнер перестает участвовать в проекте старшим становится тот у кого больше профит
     * @return false
     * @throws Exception
     */
    function addDesignProject(){
        // список пользователей
        $post   = JRequest::get('post', JREQUEST_ALLOWRAW);
        $d_date = new DateTime($post['disign_date']);
        $profit = JRequest::getVar('profit',0,'post');
        // Обнулили мастера
        $on_del_master = $this->onDelMaster($profit);
        // Максимальный процент за работу
        $max_profit = $this->getMaxArr($profit);

        // Сохраняем условия всех дизайнеров по контракту
        foreach(array_keys($profit) as $key){
            $data = null;
            // Если ключ профита нулевой, то это новый и его условия идут отдельно
            if ( $key == 0 ) {
                if( $profit[$key]== 0 ) continue;
                $row    = $this->getThisTable($post['id'],$post['designer']);
                $des    = $post['designer'];
            }
            // Иначе он из таблицы
            else {
                $row    = $this->getThisTable($post['id'],$key);
                $des    = $key;
            }
            // Если есть id записи, то запись имеется иначе ее небыло, создаем новую
            if(!$row->id){
                $data['id' ]            = 0;
                $data['on_create' ]     = date('Y-m-d');
                $data['id_project' ]    = $post['id'];
                $data['id_user' ]       = $des;
                $data['on_change' ]     = null;
            }
            // Сохроняем установленный процент за работу
            $data['profit']     = $profit[$key];
            $data['active']     = 1;
            $data['date_end']   = $post['disign_end'];
            // Если процент нуливой то исключаем дизайнера из проекта
            if( $profit[$key]== 0 ){
                $data['active' ] = 0;
                // если удаляем мастера то обнуляем его
                if($row->master_user == 1 ) $data['master_user' ] = 0;
            }
            // Если контракт был раньше то сохраняем прежнюю дату
            if(!$row->date_start)  $data['date_start' ]    = $d_date->format("Y-m-d");

            // Если мастер удален и процент максимальный то делаем его мастером
            if ($on_del_master && $max_profit == $profit[$key] )   $data['master_user' ] = 1;

            // привязка значений к объекту таблицы
            if( !$this->storeDateInRow($row,$data) ) return false;
        }

        // TODO: Почта
        //projectlogHTML::notifyDoc('doc', $user, $row->project_id);

        return $row->id;
    }

    /**
     * Сохранить запись
     * @param $row
     * @param $data
     * @return bool
     */
    function storeDateInRow($row,$data){
        if (!$row->bind($data)){
            $this->setError($row->getError());
            return false;
        }
        // Проверка на корректность
        if (!$row->check()){
            $this->setError($row->getError());
            return false;
        }
        // Запись в базу
        if (!$row->store()){
            $this->setError($row->getError());
            return false;
        }
        return true;
    }

    /**
     * Обнулили мастера
     * @param $profit
     * @return bool
     */
    function onDelMaster($profit){
        $user   = &JFactory::getUser();
        foreach (array_keys($profit) as $key){
            if($profit[$key] == 0 && $key == $user->id) return true;
        }
        return false;
    }

    /**
     * Получить максимум
     * @param $array
     * @return mixed
     */
    function getMaxArr( $array ){
        $max = $array[0];
        foreach ($array as $item){
            if ( $max < $item) $max = $item;
        }
        return $max;
    }

    function designStart(){
        $id = JRequest::getInt('id','0');
        $date_start = date('Y-m-d');
        $query = 'SELECT *'
            . ' FROM #__projectlog_design'
            . ' WHERE active = 1 '
            . ' AND id_project = ' . $id
            . ' AND id_user = ' . $this->_id_user
            . ' ORDER BY date_end ASC '
        ;
        $this->_db->setQuery($query);
        $design_projects = $this->_db->loadObjectList();

        $table = JTable::getInstance('projectlog_design', '');
        foreach ($design_projects as $design_project){
            $table->load($design_project->id);
            $table->set('date_start', $date_start);
            if ($table->check()){
                if (!$table->store()){
                    // обрабатываем ошибки записи с помощью $table->getError()
                    JError::raiseError(500, $table->getError());
                    return false;
                }
            }else{
                // обрабатываем ошибки ввода в буфер $table->getError()
                JError::raiseError(500, $table->getError());
                return false;
            }
        }
        return true;
    }

    function saveCountDays($id_project){
        $count_day = JRequest::getInt('count_day','1');
        $table = getThisTable();
        $table->set('duration', $count_day);
            if ($table->check()){
                if (!$table->store()){
                    // обрабатываем ошибки записи с помощью $table->getError()
                    JError::raiseError(500, $table->getError());
                    return false;
                }
            }else{
                // обрабатываем ошибки ввода в буфер $table->getError()
                JError::raiseError(500, $table->getError());
                return false;
            }
        return true;
    }

    /**
     * Все записи дизанеров проекта кроме теущего
     * @param $id_project
     * @return mixed
     */
    function getUsersInDesign($id_project){
        $query = 'SELECT *'
            . ' FROM #__projectlog_design'
            . ' WHERE active = 1 '
            . ' AND id_project = ' . $id_project
            //. ' AND id_user <> ' . $this->_id_user
            . ' ORDER BY on_create ASC '
        ;
        $this->_db->setQuery($query);
        $rows = $this->_db->loadObjectList();

        return $rows;
    }

    /**
     * Все записи дизанеров участвоваших в проекте
     * @param $id_project
     * @return mixed
     */
    function getDesignersInProject($id_project){
        $query = 'SELECT *'
            . ' FROM #__projectlog_design'
            . ' WHERE profit > 0 '
            . ' AND id_project = ' . $id_project
            . ' ORDER BY profit ASC '
        ;
        $this->_db->setQuery($query);
        $rows = $this->_db->loadObjectList();

        return $rows;
    }

    /**
     * Самая большая дата по Дизайну
     * @return mixed
     */
    function getMaxDateInProects(){
        $maxDate = JHTML::date("0000-00-00");
        foreach ($this->_data as $data){
           $date = JHTML::date($data->date_end);
           if ( strtotime($maxDate) < strtotime($date) ) $maxDate = $date;
        }
        return $maxDate;
    }

    /**
     * Завершить Дизайн проект
     * @param $id - ID Проекта
     * @return bool - Удачно
     */
    function rezumDesignProject($id ){
        global $mainframe;
        $user   = &JFactory::getUser();
        $query = 'SELECT *'
            . ' FROM #__projectlog_design'
            . ' WHERE active = 1 '
            . ' AND id_project = ' . $id
            . ' ORDER BY date_end ASC '
        ;
        $this->_db->setQuery($query);
        $design_projects = $this->_db->loadObjectList();
        $data['active' ] = 0;

        foreach ($design_projects as $design_project) {
            $table = JTable::getInstance('projectlog_design', '');
            $table->load($design_project->id);
            $tz = new DateTimeZone( "Asia/Irkutsk" );
            $time = new DateTime();
            $time->setTimezone( $tz );
            $link  = JRoute::_('http://zeppelin/zepp/index.php?option=com_projectlog&view=project&id=' . $design_project->id, false);

            if (!$this->storeDateInRow($table, $data)) return false;

            // Посьмо исполнителю о завершении дизайн - проекта
          //  if (projectlogHTML::getUserPChekc($design_project->id_user) == 1)

                $body = "Проект №" . projectlogHTML::getProjectNumber($design_project->id_project)
                    ." «" . projectlogHTML::getProjectName($design_project->id_project)."» "
                    ." закрыт и ушел в производство "
                    ." \n<br>Ссылка на проект: <a href='".$link."'>Проект".projectlogHTML::getprojectname($design_project->id_project)."</a>\n<br>"
                    .$time->format("d.m.Y H:i:s") . "."
                ;
                JUtility::sendMail(SITE_EMAIL, SITE_NAME,
                    projectlogHTML::userEmail($design_project->id_user),
                    projectlogHTML::getUserName($design_project->id_user),
                    $body ,
                    1
                );
            //projectlogHTML::savePochta($from_user_id=$user->id,$text=$body,$to_user_id=$design_project->id_user ,$tema = "Проекта взял дизайнер",$project_id=$design_project->id_project);

        }
        return true;
    }

}
