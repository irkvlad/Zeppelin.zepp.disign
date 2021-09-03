<?php
/*
 * Copyright (c) 2021.
 * Лощилов Владимир Геннадьевич
 * https://www.instagram.com/loshchilovvladimir
 * mailto://irkvlad@hotmail.com
 *
 * В таблице меню "jos_menu" прописать ссылку "index.php?option=com_projectlog&view=cat&id=5&layout=design"
 */
defined('_JEXEC') or die('Restricted access');

$plog_home_link   = JRoute::_('index.php?option=com_projectlog&view=cat&id=' . JRequest::getVar('id'));
$add_project_link = JRoute::_('index.php?option=com_projectlog&view=cat&layout=form&cid=' . JRequest::getVar('id'));
$cat_id           = JRequest::getVar('id');
$doc_path  = 'media/com_projectlog/docs/';
$last_fild = JText::_('CALENDAR');
$date = date('Y-m-d');
$link_buttom_go_designer_table = JRoute::_('index.php?option=com_projectlog&view=design&layout=designer&id_user='.$this->user->get('id').'&Itemid=124');

if ($this->user->get('id') == 0): ?>
    <div style="float:left;color:red" align="right"><b><?php echo JText::_('NON USER'); ?></b></div><br/>
<? endif;

// Проверяю есть ли заблокированные  проекты у текущего пользователя.
if (projectlogHTML::getUserPChekc($this->user->get('id')) == 1){
    if ($this->client){
        echo "<script language=\"javascript\" type=\"text/javascript\"> alert('Вам необходимо напомнить о себе следующим клиентам: \\n";
        foreach ($this->client as $p){
            echo $p->name . ": \\n";
            $query = "SELECT `fio` , `telefon` FROM #__zepp_client_contact WHERE ( `id_client` = " . $p->id . " )";
            $db     = JFactory::getDBO();
            $db->setQuery($query);
            $contact = $db->loadObjectList();
            if (count($contact) == 0) echo "контактов нет\\n";
            else
                foreach ($contact as $pc){
                    echo "контакт: " . $pc->fio . "\\t\\t" . $pc->telefon . " \\n";
                }
        }echo " ');	</script>";
    }
    // Проекты, выполнение которых по угрозой
    if ($this->projectStop){
        echo "<script language=\"javascript\" type=\"text/javascript\">
			alert('У вас имеются проекты, выполнение которых по угрозой. Вам необходимо принять решение по этим проектам: \\n";
        foreach ($this->projectStop as $p){
            echo $p->release_id . ";\\t\\t" . $p->title . " \\n";
        }
        echo " ');	</script>";
    }
    // Проверяю есть ли просроченные в изготовлении  проекты у текущего пользователя.
    if ($this->projectSrok){
        echo "<script language=\"javascript\" type=\"text/javascript\"> alert('У вас В ПРОИЗВОДСТВЕ имеются проекты, которое уже должны быть СДАНЫ заказчику, однако, до настоящего моента,  работа по ним НЕ ЗАКОНЧЕНА!!\\n";
        foreach ($this->projectSrok as $p){
            echo $p->release_id . " ;\\t\\t" . $p->title . "\\t - срок изготовления: \\t " . $p->release_date . " ; \\n";
        }echo " ');	</script>";
    }
}?>

    <script language="javascript" type="text/javascript">
        function tableOrdering(order, dir, task) {
            var form = document.adminForm;

            form.filter_order.value = order;
            form.filter_order_Dir.value = dir;
            //alert(order+" "+dir);
            document.adminForm.submit(task);
        }

        function listItemTask(id, task) {
            var form = document.adminForm;

            form.project_edit.value = id;
            form.task.value = task;
            document.adminForm.submit(task);
        }

        function resetForm() {
            document.adminForm.search.value = '';
            document.adminForm.filter.selectedIndex = '';
            document.adminForm.filter_design.selectedIndex = '';
        }
    </script>

    <div class="main-article-title"><h2 class="contentheading"><?php echo $this->catinfo->title; ?></h2></div>

   <?// Брак
   if (count($this->brak) > 0){
       echo '<div style="background:#c79f73;border: 3px outset #a86540;" >Выявлен брак:<br>';
       foreach ($this->brak as $b){
           $proj_link = JRoute::_('index.php?option=com_projectlog&cat_id=' . $cat_id . '&view=project&id=' . $b->id);
           echo '<a href="' . $proj_link . '">';
           echo 'Номер: <b>' . $b->release_id . '</b>; ';
           echo 'Описание: <b>' . mb_substr($b->location_spec, 0, 60) . '...</b> <Дальше>;';
           echo '</a><br>';
       }
       echo '</div>';
   } ?>

    <div class="main-article-block">

        <? if($this->user->dol_user == 12) : ?>
            <button class="helptxt" data-title="Перейти к таблице ваших проектов" style="float:left; text-align: left " onclick="document.location.assign(<?php echo "'" . $link_buttom_go_designer_table . "'"; ?>)">
                <?php echo JText::_('Таблица проектов дизайнера'); ?> </button>
        <? endif; ?>
        <form name="adminForm" method="get" action="index.php">
            <table class="ptable" width="100%" cellpadding="5" cellspacing="1">
                <tr>
                    <!-- Пагинация -->
                    <td colspan="2">
                        <div align="left" class="prop_header_results">
                            <?if ($this->projects) :
                                echo $this->pagination->getResultsCounter();
                            else:
                                echo '--';
                            endif;?>
                        </div>
                    </td>
                    <!-- Фильтр -->
                    <? // TODO: Переделать ?>
                    <td colspan="5">
                        <div align="right" class="prop_header_results">
                             <span style="text-align: left " class="helptxt" data-title="Будут показаны проекты нуждающиеся в дизанере и проекты в которых вы участвуете">
                                 <?php echo JText::_('Участие дизайнера в проектах: ') . ' ' . $this->lists['filter_design']; ?></span>

                            <span style="text-align: left " class="helptxt" data-title="Выберите критерий поиска">
                                <?php echo JText::_('SEARCH') . ' ' . $this->lists['filter']; ?></span>

                            <!--изменяются сроки по проекту, в случае если вы ошиблись или были добавлены в качестве помощника-->
                                <input type="text" name="search" id="search" value="<?php echo $this->lists['search']; ?>"
                                   class="text_area helptxt" data-title="Текст для поиска" onChange="document.adminForm.submit();"/></span>
                            <span style="text-align: left " class="helptxt" data-title="Включить филтр">
                                <button onclick="document.adminForm.submit();"><?php echo JText::_('GO'); ?></button></span>

                            <span style="text-align: left " class="helptxt" data-title="Отключить фильтр">
                                <button onclick="resetForm();document.adminForm.submit();"><?php echo JText::_('RESET'); ?></button></span>
                        </div>
                    </td>
                </tr>
                <!-- Проекты, которые по настоящее время не приняты в работу-->
                <?if ($this->user->get('id') == 97){
                    if ($this->projectAUT){
                        echo "<script language=\"javascript\" type=\"text/javascript\">
			            alert('У вас имеются проекты, которые по настоящее время не приняты в работу. Вам необходимо принять решение по этим проектам: \\n";
                        $i     = 0;
                        foreach ($this->projectAUT as $p){
                            $i++;
                            echo "$i. \\t" . $p->release_id . " \\t поступил \\t" . $p->deployment_to . "; \\n";
                        }echo " ');	</script>";
                    }
                }

    if ($this->projects) : ?>
                <tr>
                        <th width="15%"><? echo JHTML::_('grid.sort', JText::_('RELEASE DATE'), 'p.release_date', $this->lists['order_Dir'], $this->lists['order']) ?></th>
                        <th width="15%"><? echo JHTML::_('grid.sort', JText::_('Первый показ'), 'p.disign_date', $this->lists['order_Dir'], $this->lists['order']) ?></th>
                        <th width="15%"><? echo JHTML::_('grid.sort', JText::_('RELEASE NUM'), 'p.release_id', $this->lists['order_Dir'], $this->lists['order']) ?></th>
                        <th width="20%"><? echo JHTML::_('grid.sort', JText::_('PROJECT NAME'), 'p.title', $this->lists['order_Dir'], $this->lists['order']) ?></th>
                        <th width="15%"><? echo JHTML::_('grid.sort', JText::_('PROJECT MANAGER'), 'p.manager', $this->lists['order_Dir'], $this->lists['order']) ?></th>
                        <th width="15%"><? echo JHTML::_('grid.sort', JText::_('Дизайнер'), 'de.id_user', $this->lists['order_Dir'], $this->lists['order']) ?></th>
                        <th width="20%"><? echo $last_fild ?> </th>
                </tr>
            <?$i = 0;
            foreach ($this->projects as $p) :
                    $delete_project_link = JRoute::_('index.php?option=com_projectlog&view=cat&task=deleteProject&id=' . $p->id . '&category_id=' . $cat_id);
                    $proj_link           = JRoute::_('index.php?option=com_projectlog&cat_id=' . $cat_id . '&view=project&id=' . $p->id);
                    $release_date        = JFactory::getDate($p->release_date);
                    $calendar_link       = JRoute::_('index.php?option=com_projectlog&view=calendar&id=' . $p->id . '&Itemid=61');
                    $last_fild_on        = '<td align="center"><a target="_blank" href="' . $calendar_link . '" class="red">[' . JText::_('CALENDAR') . ']</a></td> ';
            ?>
                <tr>
                    <td  height="80px" align="center">
                        <a href="<? echo $proj_link ?>">
                        <div style="position:relative;">
                            <? echo '<strong>' . $release_date->toFormat('%d.%m.%Y') . '</strong><br/>'; ?>
                        </div>
                        <?foreach ($this->logo as $lg){
                            if ($lg->project_id == $p->id){
                                $tunbsrc = $doc_path . $p->id . DS . $lg->path;
                                if (file_exists($doc_path . $p->id . DS . '80x80_' . $lg->path)) $tunbsrc = $doc_path . $p->id . DS . '80x80_' . $lg->path;
                                echo '<img src="' . $tunbsrc . '" width="80" height="80" alt="Логотип">';
                            }
                        }?></a>
                    </td>
                    <td align="center"><? echo '<strong>' . JHTML::_('date', strtotime($p->disign_date), $format = '%d.%m.%Y', $offset = null). '</strong><br/>'; ?></td>
                    <td align="center"> <? echo $p->release_id ?>
                        <?if (($this->user->id == $p->manager || $this->user->id == $p->created_by && PEDIT_ACCESS) || PLOG_ADMIN) {
                            echo '<div><a href="' . $add_project_link . '&edit=' . $p->id . '" class="red">[' . JText::_('EDIT') . ']</a><br />';
                            echo '<a href="' . $delete_project_link . '" class="red" onclick="if(confirm(\'' . JText::_('CONFIRM DELETE') . '\')){return true;}else{return false;};">[' . JText::_('DELETE') . ']</a></div>';
                        }?>
                    </td>
                    <td><a href="<? echo $proj_link ?>"> <? echo $p->title ?> </a></td>
                    <td><? echo projectlogHTML::getusername($p->manager) ?></td>
                    <td align="center"><? echo ($p->designer) ? projectlogHTML::getusername($p->designer) : "<b>Требуется дизайнер</b>" ?></td>
                    <? echo $last_fild_on; ?>
                </tr>
                <? $i++;
            endforeach;?>
                <tr>
				    <td colspan="3" align="left"><? echo $this->pagination->getPagesLinks() ?>&nbsp;</td>
                    <td colspan="4" align="right"> Количество записей на странице: <? echo $this->pagination->getLimitBox() ?></td>
			    </tr>
                <tr>
                    <td colspan="7" align="center"><? echo $this->pagination->getPagesCounter() ?></td>
                </tr>
    <?else :?>
                <tr>
                    <td colspan="7">
                            <div align="center"><? echo JText::_('NO PROJECTS') ?></div>
                    </td>
                </tr>
    <? endif; ?>

            </table>
            <input type="hidden" name="option" value="com_projectlog"/>
            <input type="hidden" name="layout" value="design"/>
            <input type="hidden" name="view" value="<?php echo JRequest::getVar('view'); ?>"/>
            <input type="hidden" name="Itemid" value="<?php echo JRequest::getVar('Itemid'); ?>"/>
            <input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>"/>
            <input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>"/>
            <input type="hidden" name="project_edit" value=""/>
            <input type="hidden" name="id" value="<?php echo JRequest::getVar('id'); ?>"/>
            <input type="hidden" name="task" value=""/>
        </form>
        <p>Для работы с выбранным проектом, нужно его открыть.<br>Что бы открыть проект, нужно кликнуть по его названию.<br>Над таблицей проектов, имеется фильтр.С его помощью можно отбирать нужное.</p>
    </div>
<?if ( $this->settings->get('footer') ) echo '<div><p class="copyright">' . projectlogAdmin::footer() . '</p>';?>
