<tr>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <th>
            <?php echo TbHtml::link($this->getLabelName('city_name').$this->drawOrderArrow('city_name'),'#',$this->createOrderLink('material','city_name'))
            ;
            ?>
        </th>
    <?php endif ?>
    <th>
        <?php echo TbHtml::link($this->getLabelName('name').$this->drawOrderArrow('name'),'#',$this->createOrderLink('equipment','equipmenttype'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('number_code').$this->drawOrderArrow('number_code'),'#',$this->createOrderLink('equipment','equipmenttype'))
        ;
        ?>
    </th>
    <th width="10%"></th>
</tr>
