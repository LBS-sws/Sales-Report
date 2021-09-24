
<tr class='clickable-row' data-href='<?php echo $this->getLink('SS01', 'employeesignature/edit', 'employeesignature/edit', array('index'=>$this->record['id']));?>'>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <td class="name"><?php echo $this->record['city_name']; ?></td>
    <?php endif ?>
    <td class="staffid"><?php echo $this->record['staffid']; ?></td>
    <td class="staffname"><?php echo $this->record['staffname']; ?></td>
    <td class="signature">
        <?php
        echo (empty($this->record['signature'])) ? '&nbsp;' : CHtml::image($this->record['signature'],'signature',array('width'=>25,'height'=>25));
        ?>
    </td>
    <td class="creat_time"><?php echo $this->record['creat_time']; ?></td>
</tr>
