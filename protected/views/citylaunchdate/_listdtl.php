
<tr class='clickable-row' data-href='<?php echo $this->getLink('OS08', 'citylaunchdate/edit', 'citylaunchdate/edit', array('index'=>$this->record['id']));?>'>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <td class="name"><?php echo $this->record['city_name']; ?></td>
    <?php endif ?>
    <td class="launch_date"><?php echo $this->record['launch_date']; ?></td>
    <td class="creat_time"><?php echo $this->record['creat_time']; ?></td>
</tr>
