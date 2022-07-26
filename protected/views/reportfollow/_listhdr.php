<tr>
<!--	<th>  <input name="Fruit"  type="checkbox"  id="all"></th>-->
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <th>
            <?php echo TbHtml::link($this->getLabelName('City').$this->drawOrderArrow('City'),'#',$this->createOrderLink('Reportfollow-list','City'))
            ;
            ?>
        </th>
    <?php endif ?>
	<th>
		<?php echo TbHtml::link($this->getLabelName('JobDate').$this->drawOrderArrow('JobDate'),'#',$this->createOrderLink('Reportfollow-list','JobDate'))
			;
		?>
	</th>

	<th>
		<?php echo TbHtml::link($this->getLabelName('CustomerID').$this->drawOrderArrow('CustomerID'),'#',$this->createOrderLink('Reportfollow-list','CustomerID'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('CustomerName').$this->drawOrderArrow('CustomerName'),'#',$this->createOrderLink('Reportfollow-list','CustomerName'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('ServiceType').$this->drawOrderArrow('ServiceType'),'#',$this->createOrderLink('Reportfollow-list','ServiceType'))
			;
		?>
	</th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('Staff01').$this->drawOrderArrow('Staff01'),'#',$this->createOrderLink('Reportfollow-list','Staff01'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('StartTime').$this->drawOrderArrow('StartTime'),'#',$this->createOrderLink('Reportfollow-list','StartTime'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('FinishTime').$this->drawOrderArrow('FinishTime'),'#',$this->createOrderLink('Reportfollow-list','FinishTime'))
        ;
        ?>
    </th>
</tr>
