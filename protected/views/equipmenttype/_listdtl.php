
<tr class='clickable-row' data-href='<?php echo $this->getLink('OS03', 'equipmenttype/edit', 'equipmenttype/edit', array('index'=>$this->record['id']));?>'>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <td class="name"><?php echo $this->record['city_name']; ?></td>
    <?php endif ?>
    <td class="name"><?php echo $this->record['name']; ?></td>
    <td class="name"><?php echo $this->record['type']; ?></td>
    <td class="name"><?php echo $this->record['check_targt']; ?></td>
    <td class="name"><?php echo $this->record['check_handles']; ?></td>
    <td class="name"><?php echo $this->record['creat_time']; ?></td>
</tr>
