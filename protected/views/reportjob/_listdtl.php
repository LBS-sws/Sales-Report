<tr class='clickable-row' data-href='<?php echo $this->getLink('RQ01', 'reportjob/edit', 'reportjob/view', array('index'=>$this->record['JobID']));?>'>
    <td class="che"> <input value="<?php echo $this->record['JobID']; ?>"  type="checkbox" name="Reportjob[attr][]" ></td>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <td><?php echo $this->record['City']; ?></td>
    <?php endif ?>
	<td><?php echo $this->record['JobDate']; ?></td>
	<td><?php echo $this->record['CustomerID']; ?></td>
	<td><?php echo $this->record['CustomerName']; ?></td>
	<td><?php echo $this->record['ServiceType']; ?></td>
    <td><?php echo $this->record['Staff01']; ?></td>
    <td><?php echo $this->record['StartTime']; ?></td>
    <td><?php echo $this->record['FinishTime']; ?></td>

</tr>
