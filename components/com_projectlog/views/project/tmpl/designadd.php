<?php
/*
 * Copyright (c) 2021.
 * Лощилов Владимир Геннадьевич
 * https://www.instagram.com/loshchilovvladimir
 * mailto://irkvlad@hotmail.com
 */
?>
<div>  <h3><u> Добавить помощника: </u></h3>

    <form action="index.php" method="post" name="adminForm" id="adminForm" onsubmit="return chekProfit()" >
        <span style="text-align: left " class="helptxt" data-title="Выбрать участника">
            <?php echo JHTML::_('select.genericlist', $this->desiner_list, 'designer', 'size="1"', 'value', 'text', "", 'designer', true); ?></span>&nbsp;

        <b>Процент</b>&nbsp;<span style="text-align: left " class="helptxt" data-title="Объем работы">
            <input class="prof" type="number" name="profit[0]" size="4" max="100" min="0" value="0"  /></span>&nbsp;
        <input type="submit" value="<?php echo JText::_('Добавить'); ?>"/>
<table>
    <thead>
        <tr><th>Дизайнер</th><th>Процент</th><th>Дни</th></tr>
    </thead>
    <?foreach ($this->designers as $designer){?>
        <tr>
            <td><? echo projectlogHTML::getusername($designer->id_user) ?></td>
            <td><input class="prof" type="number" name="profit[<? echo $designer->id_user ?>]" size="4" max="100" min="0" value="<? echo $designer->profit ?>"  /></td>
            <td><? echo $designer->duration ?></td>
        </tr>
    <?}?>
</table>
        <?php echo JHTML::_('form.token'); ?>
        <input type="hidden" name="option" value="com_projectlog"/>
        <input type="hidden" name="cat_id" value="5"/>
        <input type="hidden" name="view" value="project"/>
        <input type="hidden" name="task" value="design_add"/>
        <input type="hidden" name="disign_end" value="<? echo $this->project->disign_date ?>" />
        <input type="hidden" name="Itemid" value="<? echo JRequest::getVar('Itemid'); ?>"/>
        <input type="hidden" name="id" value="<? echo $this->project->id; ?>"/>
    </form><br />
    Если себе или пощнику установить процент "0", то этот дизайнер выйдет из участия в проекте. Мастером проекта будет назначен дизайнер , у которого больше процент.
</div>
<script>
    function chekProfit() {
        var pr = document.querySelectorAll('input.prof');
        var sum = 0 ;
        for (index = 0; index < pr.length; ++index) {
            sum+=pr[index].value*1;
        }

        if(sum == 100 )
            return true;
        else
            alert('Сумма нагрузок должна быть равна 100%');
        return false;
    }
</script>
