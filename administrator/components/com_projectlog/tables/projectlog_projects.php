<?php
/**
 *      Модель данных Проектов
 *
 *    Управление Проектами 2013
 *    Автор Irkvlad irkvlad@hotmail.com
 *    https://www.instagram.com/loshchilovvladimir
 *    Copyright DC ZePPelin
 **/

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class projectlog_projects extends JTable
{
	var $id                 = null;
    var $category           = null;
    var $group_access       = null;
    var $release_id         = null;
    var $job_id             = null;
    var $task_id            = null;
    var $cast_disign        = null;
    var $workorder_id       = null;
    var $title              = null;
    var $shot_title         = null;
    var $description        = null;
    var $release_date       = null;
    var $disign_date        = null;
    var $contract_from      = null;
    var $contract_to        = null;
    var $location_gen       = null;
    var $location_spec      = null;
    var $manager            = null;
    var $chief              = null;
    var $technicians        = null;
    var $brigadir           = null;
    var $deployment_from    = null;
    var $deployment_to      = null;
    var $onsite             = null;
    var $projecttype        = null;
    var $client             = null;
    var $status             = null;
    var $approved           = null;
    var $created_by         = null;
    var $published          = 1;
    var $pipl_on	        = 0;
    var $mat_on		        = 0;
    var $plan_on	        = 0;
    var $podrydchik         = null;
    var $ringclient_ids     = null;

    function __construct(&$db){
		parent::__construct( '#__projectlog_projects', 'id', $db );
	}
}
?>