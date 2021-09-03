<?php
/**
 *      Форма вывода страницы дизайнера
 *
 * Copyright (c) 2021.
 * Лощилов Владимир Геннадьевич
 * https://www.instagram.com/loshchilovvladimir
 * mailto://irkvlad@hotmail.com
 *
 *    Управление Проектами 2013
 *    Автор Irkvlad irkvlad@hotmail.com
 *    https://www.instagram.com/loshchilovvladimir
 *    Copyright DC ZePPelin
 **/

defined('_JEXEC') or die('No access');

if ($this->project->group_access && !PLOG_ADMIN){
    if (!projectlogHelperQuery::isGroupMember($this->project->group_access, $this->user->get('id'))){
        JError::raiseWarning(403, JText::_('PLOG NOT AUTHORIZED'));
        return;
    }
}
if (
        (
           (
            $this->user->id == $this->project->manager ||         // Доступ имеют: менеджер
            $this->user->id == $this->project->chief   ||         // Дизайнер
            $this->user->id == $this->project->technicians        // Технолог
            )  && PEDIT_ACCESS
        ) || PLOG_ADMIN
   ){
        $acces_dok = true;                    // добаление файлов
        $acces_edit = true;                   // к правке файлов
    }

$bcolor="#fff";$color="#000";
$time = new DateTime($this->toDate); // Сегодня
$time_max = new DateTime($this->maxDate);//Дата первого показа
//Количество дней нужное дизайнеру для работы
$col_days = (integer)( strtotime($time_max->format('Y-m-d'))-strtotime($time->format("Y-m-d")))/60/60/24;
$to_end_days = 0;
foreach($this->projects as $project){
    if($to_end_days < strtotime($project->release_date)) $to_end_days= strtotime($project->release_date);
}
// Количество дней до сдачи самого последнего проекта
$to_end_days = ($to_end_days - strtotime($time->format("Y-m-d"))) /60/60/24;
?>
<script>
    window.onload = function() {
        setInterval(function() { flash() }, 500);
    }

    function flash() {
        if (document.getElementById("tab").style.borderColor == "grey") {
            document.getElementById("tab").style.borderColor = "red";
        } else {
            document.getElementById("tab").style.borderColor = "grey";
        }
    }
</script>
<style>
    .table_project {
        overflow: hidden;
    }
    .name_project table {
        border-collapse: collapse;
        border: 0px solid grey;
        border-right: 0px;
    }

    .name_project th, td {
        border: 1px solid grey;
    }

    .name_project th {
        background-color: #ec962782;
    }
    .name_project {
        margin-bottom: 10px;
    }
</style>

<h2>Список работ дизайнера: <?echo $this->designer ?></h2>


<div class="table_project">
<div class="name_project">
<table>
    <thead>
    <tr>
        <th>Номер заказа</th>
        <th width="90">Название заказа</th>
        <th>Дни / Стоимость</th>
        <th>Участники</th>
        <th>Доля</th>
        <th>Дизайнер приступит<br>Первый показ<br>Дизайнер закончит<br>Сдача проекта заказчику</th>
        <?
        $m='';
        for($d=0;$d <= $to_end_days;$d++){?>
            <th>
                <?if($m <> $time->format('m')){
                    $m =     $time->format('m');
                    echo  $m."<br>";
                }else{
                    echo "-<br>";
                }
                echo  $time->format('d');
                $time->modify("+1 day");?>
            </th>
        <?}?>
    </tr>
    </thead>
    <tbody>
    <?$i=0;?>
    <?foreach ($this->projects as $project){
        if(!$project->users) continue;
        $time = new DateTime($this->toDate); // Сегодня
        $time_end = new DateTime($project->disign_date);// Первый показ $this->designProjects[$i]->date_end);
        $project_end = new DateTime($project->release_date);// сдача заказчику $this->designProjects[$i]->date_end);
        $time_start = new DateTime($this->designProjects[$i]->date_start); // Менеджер начнет работу
        $duration = $this->designProjects[$i]->duration; // Продолжительность работы
        $time_duration = new DateTime($this->designProjects[$i]->date_start);
        $time_duration->modify("+".$duration." day"); // Когда менеджер закончит работу
        $err=false; // Первый показ прошел
        $tr_style=''; // Стиль текущей ячейки

        if ( strtotime($time_end->format('Y-m-d')) == strtotime($time->format('Y-m-d'))){
            $tr_style = 'style="border: 2px solid yellow;" border="1" width="130"';
            $bcolor="#F5BB45";$color="#A51709";
        }
        elseif ( strtotime($time_end->format('Y-m-d')) < strtotime($time->format('Y-m-d'))){
            $bcolor=" #A51709";$color="#F5BB45";$err=true;
            $tr_style = 'style="border: 2px solid yellow;" id="tab" border="1" width="130"';
        }else{
            $bcolor=$project->projecttype;$color=$project->workorder_id;
        }
        $link_project = JRoute::_("index.php?option=com_projectlog&view=project&id=" .$project->id);?>

        <tr <? echo $tr_style ?> onclick="location.href='<?echo $link_project ?>'" >
            <td  style="text-align: center; background-color: #<?echo $project->projecttype ?>;color: #<?echo $project->workorder_id ?>"><?echo $project->release_id?></td>
            <td style="padding: 0 5px"><b><?echo $project->title?></b></td>
            <td style="padding: 0 5px"><?echo $this->designProjects[$i]->duration?> раб.дн.<br><?echo $project->cast_disign?> руб.</td>
            <td style="padding: 0 5px"><?foreach ($project->users as $user){ echo '<span style="white-space:nowrap">'.projectlogHTML::getUserName($user->id_user)."</span><br/>"; }?></td>
            <td style="padding: 0 5px"><?foreach ($project->users as $user){ echo '<span style="white-space:nowrap">'.$user->profit."</span><br/>";  }?></td>
            <td style="padding: 0 5px;color: <?echo $color?>;background-color: <?echo $bcolor?>  "><span style="border-bottom: 5px solid #3416F3;" ><?echo $time_start->format("d.m") ?>&nbsp;приступить</span><br>
                            <span style="border-bottom: 5px solid yellow;"><?echo $time_end->format("d.m") ?>&nbsp;первый показ</span><br>
                            <span style=""><?echo $time_duration->format("d.m") ?>&nbsp;закончить</span><br>
                            <span style="border-bottom: 5px solid red;"><?echo JHTML::_('date', $project->release_date, JText::_('%d.%m'))?>&nbsp;нужно сдать</span>
            </td>
            <?
            for($d=0;$d <= $to_end_days;$d++){
                $boreder='';$text="";$opacity="70%";$bcolor="#fff";$color="#000";
                if (strtotime($time->format('Y-m-d')) > strtotime($time_duration->format('Y-m-d'))) {
                    $bcolor="#fff";$color="#000";
                }else if (strtotime($time->format('Y-m-d')) >= strtotime($time_start->format('Y-m-d'))){
                    $bcolor="#".$project->projecttype;"#".$color=$project->workorder_id;$text="Работа над проектом";
                }
                if($err) {
                    $bcolor="#A51709";$color="#A51709";$opacity="100%";$boreder = "border: 1px grey solid;";$text="Срок первого показа вышел";
                }
                if( strtotime($time->format('Y-m-d')) == strtotime($time_end->format('Y-m-d')) ){
                    $boreder = "border: 3px yellow solid;";$text="Первый показ дизайна";$opacity="-10%";$bcolor="#f5bb45";
                }
                if( strtotime($time->format('Y-m-d')) == strtotime($project_end->format('Y-m-d')) ){
                    $boreder = "border: 3px red solid;";$text="Завершение проекта и подписание актов";$opacity="-10%";
                }
                $time->modify("+1 day");
                ?>
            <td  title="<? echo $text ?>">
                <div style="background-color:<?echo $bcolor ?>;color:<?echo $color ?>;<? echo $boreder ?>;filter: opacity(<? echo $opacity ?>) ">&nbsp;<br><br><br></div>
    </td>
            <?}?>
        </tr>
        <?$i++?>
    <?}?>
    </tbody>
</table>
</div>
<div class="name_project">
    Выполненые работы:
    <table>
        <thead>
        <tr>
            <th>Номер заказа</th>
            <th width="90">Название заказа</th>
            <th>Дни / Стоимость</th>
            <th>Доля</th>
            <th>Старт<br>Конец<br>Показ</th>
        </tr>
        </thead>
        <tbody>
        <?$i=0;?>
        <?foreach ($this->end_projects as $design_project){
            $time = new DateTime($this->toDate);
            $time_end = new DateTime($design_project->date_end);
            $time_start = new DateTime($design_project->date_start);
            $duration = $design_project->duration;
            $time_duration = new DateTime($design_project->date_start);
            $time_duration->modify("+".$duration." day");
            $project = projectlogHTML::getProject($design_project->id_project);
            $err=false;
            $tr_style='';
            $bcolor=$project->projecttype;$color=$project->workorder_id;

            $link_project = JRoute::_("index.php?option=com_projectlog&view=project&id=" .$project->id);?>
            <tr <? echo $tr_style ?> onclick="location.href='<?echo $link_project ?>'" >
                <td style="text-align:center;padding: 0 5px;background-color: #<?echo $project->projecttype ?>;color: #<?echo $project->workorder_id ?>"><?echo $project->release_id?></td>
                <td style="padding: 0 5px"><b><?echo $project->title?></b></td>
                <td style="padding: 0 5px"><?echo $design_project->duration?><br><?echo $project->cast_disign?> руб.</td>
                <td style="padding: 0 5px"><? echo '<span style="white-space:nowrap">'.$design_project->profit."</span><br/>"; ?></td>
                <td style="padding: 0 5px;color: <?echo $color?>;background-color: <?echo $bcolor?>  "><?echo $time_start->format("d.m") ?><br><?echo $time_duration->format("d.m") ?><br><?echo $time_end->format("d.m") ?></td>

            </tr>
            <?$i++?>
        <?}?>
        </tbody>
    </table>
    <br/>
    <br/>
    <p  style="color: #ef4c40"><span>Цвет номера заказа, соответсвует цвету календарика.</span><br>
        <span>Цветом календарика показаны рабочие дни по проекту.</span><br>
        <span>Красная рамка - день сдачи проекта.</span><br>
        <span>Желтая рамка - день первого показа проекта.</span><br>
        <span>Красные ячейки - срок первого показа проекта вышел.</span><br>
        <span>Мигающая красная рамка прошел срок первого показа проекта и работа не выполнена.</span><br>
        <span>Дату первого показа устанавливает менеджер, она может не совпадать с периодом работы по проекту</span><br>
    </p>
</div>
</div>


