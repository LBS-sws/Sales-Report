
<tr>
    <td><input type="checkbox" value="<?php echo $this->record['id']; ?>" name="EqnumOS11List[id][]"></td>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <td class="name"><?php echo $this->record['city_name']; ?></td>
    <?php endif ?>
    <td class="name"><?php echo $this->record['name']; ?></td>
    <td class="name"><?php echo $this->record['equipment_number']; ?></td>
<!--    <td class="name">--><?php //echo $this->record['status']; ?><!--</td>-->
    <td class="name"><?php echo $this->record['downcount']; ?></td>
    <td class="name"><?php echo $this->record['creat_time']; ?></td>
</tr>
