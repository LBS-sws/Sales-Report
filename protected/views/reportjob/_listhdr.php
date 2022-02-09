<tr>
	<th>  <input name="Fruit"  type="checkbox"  id="all"></th>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <th>
            <?php echo TbHtml::link($this->getLabelName('City').$this->drawOrderArrow('City'),'#',$this->createOrderLink('invoice-list','City'))
            ;
            ?>
        </th>
    <?php endif ?>
	<th>
		<?php echo TbHtml::link($this->getLabelName('JobDate').$this->drawOrderArrow('JobDate'),'#',$this->createOrderLink('invoice-list','JobDate'))
			;
		?>
	</th>

	<th>
		<?php echo TbHtml::link($this->getLabelName('CustomerID').$this->drawOrderArrow('CustomerID'),'#',$this->createOrderLink('invoice-list','CustomerID'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('CustomerName').$this->drawOrderArrow('CustomerName'),'#',$this->createOrderLink('invoice-list','CustomerName'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('ServiceType').$this->drawOrderArrow('ServiceType'),'#',$this->createOrderLink('invoice-list','ServiceType'))
			;
		?>
	</th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('Staff01').$this->drawOrderArrow('Staff01'),'#',$this->createOrderLink('invoice-list','Staff01'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('StartTime').$this->drawOrderArrow('StartTime'),'#',$this->createOrderLink('invoice-list','StartTime'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('FinishTime').$this->drawOrderArrow('FinishTime'),'#',$this->createOrderLink('invoice-list','FinishTime'))
        ;
        ?>
    </th>
</tr>
