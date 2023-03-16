
<tr class='clickable-row' data-href='<?php echo $this->getLink('OS11', 'numbercode/edit', 'numbercode/edit', array('index'=>$this->record['id']));?>'>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <td class="name"><?php echo $this->record['city_name']; ?></td>
    <?php endif ?>
    <td class="name"><?php echo $this->record['name']; ?></td>
    <td class="numbercode"><?php echo $this->record['number_code']; ?></td>
</tr>
