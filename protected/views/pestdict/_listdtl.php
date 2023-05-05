
<tr class='clickable-row' data-href='<?php echo $this->getLink('PE02', 'pestdict/edit', 'pestdict/edit', array('index'=>$this->record['id']));?>'>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <td class="name"><?php echo $this->record['city_name']; ?></td>
    <?php endif ?>
    <td class="name"><?php echo $this->record['id']; ?></td>
    <td class="name"><?php echo $this->record['type_name']; ?></td>
    <td class="name"><?php echo $this->record['insect_name']; ?></td>
    <td class="name"><?php echo $this->record['analysis_result']; ?></td>
    <td class="name"><?php echo $this->record['suggestion']; ?></td>
    <td class="name"><?php echo $this->record['measure']; ?></td>
    <td class="name"><?php echo $this->record['created_at']; ?></td>
</tr>
