
<tr class='clickable-row' data-href='<?php echo $this->getLink('OS09', 'servicematerial/edit', 'servicematerial/edit', array('index'=>$this->record['id']));?>'>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <td class="name"><?php echo $this->record['city_name']; ?></td>
    <?php endif ?>
    <td class="name"><?php echo $this->record['service_name']; ?></td>
    <td class="name"><?php echo $this->record['material_names']; ?></td>
    <td class="name"><?php echo $this->record['creat_time']; ?></td>
</tr>
