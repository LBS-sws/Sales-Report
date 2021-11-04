<tr>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <th>
            <?php echo TbHtml::link($this->getLabelName('city_name').$this->drawOrderArrow('city_name'),'#',$this->createOrderLink('serviceequipment','city_name'))
            ;
            ?>
        </th>
    <?php endif ?>
    <th>
        <?php echo TbHtml::link($this->getLabelName('service_name').$this->drawOrderArrow('service_name'),'#',$this->createOrderLink('serviceequipment','serviceequipment'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('equipment_names').$this->drawOrderArrow('equipment_names'),'#',$this->createOrderLink('serviceequipment','serviceequipment'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('creat_time').$this->drawOrderArrow('creat_time'),'#',$this->createOrderLink('serviceequipment','serviceequipment'))
        ;
        ?>
    </th>
    <th width="10%"></th>
</tr>
