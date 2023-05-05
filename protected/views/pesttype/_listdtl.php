
<tr class='clickable-row' data-href='<?php echo $this->getLink('PE01', 'pesttype/edit', 'pesttype/edit', array('index'=>$this->record['id']));?>'>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <td class="name"><?php echo $this->record['city_name']; ?></td>
    <?php endif ?>
    <td class="name"><?php echo $this->record['type_name']; ?></td>
    <td class="name"><?php echo $this->record['created_at']; ?></td>
</tr>
