<tr>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <th>
            <?php echo TbHtml::link($this->getLabelName('city_name').$this->drawOrderArrow('city_name'),'#',$this->createOrderLink('material','city_name'))
            ;
            ?>
        </th>
    <?php endif ?>
    <th>
        <?php echo TbHtml::link($this->getLabelName('equipment_type_name').$this->drawOrderArrow('equipment_type_name'),'#',$this->createOrderLink('equipment','equipmenttypeselect'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('check_targt').$this->drawOrderArrow('check_targt.equipment_type_id'),'#',$this->createOrderLink('equipment','equipmenttypeselect'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('check_selects').$this->drawOrderArrow('check_selects'),'#',$this->createOrderLink('equipment','equipmenttypeselect'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('creat_time').$this->drawOrderArrow('creat_time'),'#',$this->createOrderLink('equipment','equipmenttypeselect'))
        ;
        ?>
    </th>
    <th width="10%"></th>
</tr>
