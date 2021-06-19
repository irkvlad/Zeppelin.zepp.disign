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
$time = new DateTime($this->toDate);
$time_max = new DateTime($this->maxDate);
$col_days = (integer)( strtotime($time_max->format('Y-m-d'))-strtotime($time->format("Y-m-d")))/60/60/24;
?>
<script>
    window.onload = function() {
        setInterval(function() { flash() }, 500);
    }

    function flash() {
        if (document.getElementById("tab").style.borderColor == "yellow") {
            document.getElementById("tab").style.borderColor = "red";
        } else {
            document.getElementById("tab").style.borderColor = "yellow";
        }
    }
</script>
<style>
    .table_project {
        overflow: hidden;
    }
    .name_project table {
        border-collapse: collapse;
        border: 3px solid grey;
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
<p><span>Цвет соответсвует цвету календарика.</span><br>
<span>Цветом показаны рабочие дни по проекту.</span><br>
<span>Красная рамка - день показа проекта.</span><br>
<span>Мигающая рамка прошел срок первого показа и работа не выполнена.</span>
</p>

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
        <th>Старт<br>Конец<br>Показ</th>
        <?
        $m='';
        for($d=0;$d <= $col_days;$d++){?>
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
        $time = new DateTime($this->toDate);
        $time_end = new DateTime($this->designProjects[$i]->date_end);
        $time_start = new DateTime($this->designProjects[$i]->date_start);
        $duration = $this->designProjects[$i]->duration;
        $time_duration = new DateTime($this->designProjects[$i]->date_start);
        $time_duration->modify("+".$duration." day");
        $err=false;
        $tr_style='';
        if ( strtotime($time_end->format('Y-m-d')) < strtotime($time->format('Y-m-d'))){
            $bcolor="#F5BB45";$color="#A51709";$err=true;
            $tr_style = 'style="border: 4px solid yellow;" id="tab" border="1" width="130"';
        }else{
            $bcolor=$project->projecttype;$color=$project->workorder_id;
        }
        $link_project = JRoute::_("index.php?option=com_projectlog&view=project&id=" .$project->id);?>

        <tr <? echo $tr_style ?> onclick="location.href='<?echo $link_project ?>'" >
            <td style="background-color: #<?echo $project->projecttype ?>;color: #<?echo $project->workorder_id ?>"><?echo $project->release_id?></td>
            <td ><b><?echo $project->title?></b></td>
            <td><?echo $this->designProjects[$i]->duration?><br><?echo $project->cast_disign?> руб.</td>
            <td><?foreach ($project->users as $user){ echo '<span style="white-space:nowrap">'.projectlogHTML::getUserName($user->id_user)."</span><br/>"; }?></td>
            <td><?foreach ($project->users as $user){ echo '<span style="white-space:nowrap">'.$user->profit."</span><br/>";  }?></td>
            <td style="color: <?echo $color?>;background-color: <?echo $bcolor?>  "><?echo $time_start->format("d.m") ?><br><?echo $time_duration->format("d.m") ?><br><?echo $time_end->format("d.m") ?></td>
            <?
            for($d=0;$d <= $col_days;$d++){
                $boreder='';
                if (strtotime($time->format('Y-m-d')) > strtotime($time_duration->format('Y-m-d'))) {
                    $bcolor="#fff";$color="#000";
                }else if (strtotime($time->format('Y-m-d')) >= strtotime($time_start->format('Y-m-d'))){
                    $bcolor="#".$project->projecttype;"#".$color=$project->workorder_id;
                }
                if($err) {
                    $bcolor="#A51709";$color="#A51709";
                }
                if( strtotime($time->format('Y-m-d')) == strtotime($time_end->format('Y-m-d')) ){
                    $boreder = "border: 3px red solid;";
                }
                $time->modify("+1 day");
                ?>
                <td style="background-color: <?echo $bcolor ?>;color: <?echo $color ?>;<? echo $boreder ?> "></td>
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
            if ( strtotime($time_end->format('Y-m-d')) < strtotime($time->format('Y-m-d'))){
                $bcolor="#F5BB45";$color="#A51709";$err=true;
                $tr_style = 'style="border: 4px solid yellow;" id="tab" border="1" width="130"';
            }
            else{
                $bcolor=$project->projecttype;$color=$project->workorder_id;
            }
            $link_project = JRoute::_("index.php?option=com_projectlog&view=project&id=" .$project->id);?>
            <tr <? echo $tr_style ?> onclick="location.href='<?echo $link_project ?>'" >
                <td style="background-color: #<?echo $project->projecttype ?>;color: #<?echo $project->workorder_id ?>"><?echo $project->release_id?></td>
                <td ><b><?echo $project->title?></b></td>
                <td><?echo $design_project->duration?><br><?echo $project->cast_disign?> руб.</td>
                <td><? echo '<span style="white-space:nowrap">'.$design_project->profit."</span><br/>"; ?></td>
                <td style="color: <?echo $color?>;background-color: <?echo $bcolor?>  "><?echo $time_start->format("d.m") ?><br><?echo $time_duration->format("d.m") ?><br><?echo $time_end->format("d.m") ?></td>

            </tr>
            <?$i++?>
        <?}?>
        </tbody>
    </table>

</div>
</div>


