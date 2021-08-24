<?php
/*
 * Copyright (c) 2021.
 * Лощилов Владимир Геннадьевич
 * https://www.instagram.com/loshchilovvladimir
 * mailto://irkvlad@hotmail.com
 */
?>
<div>  <h3><u> Дизайн контракт: </u></h3>
                        <form action="index.php" method="post" name="adminForm" id="adminForm" >
                            <?php echo JText::_('Я сделаю за '); ?>
                            <span style="text-align: left " class="helptxt" data-title="Количество дней за которое вы выполните проект">
                                <input type="number" name="count_days" value="1" size="3"> </span>,&nbsp;

                                Начиная с&nbsp;
                            <span style="text-align: left " class="helptxt" data-title="Когда вы сможете приступить к работе">
                            <?
                            $start_date = new DateTime();
                             echo JHTML::_('calendar',  $start_date->format("d-m-Y"), 'disign_date', 'disign_date','%d-%m-%Y', "required" ); ?>&nbsp;
                                <input type="submit" value="<?php echo JText::_('Отправить'); ?>"/></span>

                            <?php echo JHTML::_('form.token'); ?>
                            <input type="hidden" name="option" value="com_projectlog"/>
                            <input type="hidden" name="cat_id" value="5"/>
                            <input type="hidden" name="view" value="project"/>
                            <input type="hidden" name="task" value="design_save"/>
                            <input type="hidden" name="disign_end" value="<? echo $this->project->disign_date ?>" />
                            <input type="hidden" name="Itemid" value="<? echo JRequest::getVar('Itemid'); ?>"/>
                            <input type="hidden" name="id" value="<? echo $this->project->id; ?>"/>
                        </form><br />
</div>