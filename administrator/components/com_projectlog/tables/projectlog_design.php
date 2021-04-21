<?php
/**
 *  Модель таблицы ДизайнПроектов
 *
 * Copyright (c) 2021.
 * Лощилов Владимир Геннадьевич
 * https://www.instagram.com/loshchilovvladimir
 * mailto://irkvlad@hotmail.com
 *
 *    Управление Проектами 2013
 *    Copyright DC ZePPelin
 **/

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class projectlog_design extends JTable
{
    var $id           = null;
    var $id_project   = null;
    var $id_user      = null;
    var $date_start   = null;
    var $date_end     = null;
    var $on_create    = null;
    var $on_change    = null;
    var $profit       = null;
    var $duration     = null;
    var $active       = null;
    var $master_user   = null;

    function __construct(&$db){
        parent::__construct( '#__projectlog_design', 'id', $db );
    }
    /**
     * Проверка
     *
     * @return boolean True if buffer is valid

    function check(){
        if(!$this->content)
        {
            $this->setError(JText::_('Ошибка'));
            return false;
        }
        return true;
    }
*/
}