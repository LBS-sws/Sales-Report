
<tr class='clickable-row' data-href='<?php echo $this->getLink('OS05', 'usearea/edit', 'usearea/edit', array('index'=>$this->record['id']));?>'>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <td class="name"><?php echo $this->record['city_name']; ?></td>
    <?php endif ?>
    <td class="name"><?php echo $this->record['area_type']; ?></td>
    <td class="name"><?php echo $this->record['use_area']; ?></td>
    <td class="name"><?php echo $this->record['creat_time']; ?></td>
</tr>
