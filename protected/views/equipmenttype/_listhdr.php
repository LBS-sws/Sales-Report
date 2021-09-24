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
        <?php echo TbHtml::link($this->getLabelName('type').$this->drawOrderArrow('type'),'#',$this->createOrderLink('equipment','equipmenttype'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('check_targt').$this->drawOrderArrow('check_targt'),'#',$this->createOrderLink('equipment','equipmenttype'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('check_handles').$this->drawOrderArrow('check_handles'),'#',$this->createOrderLink('equipment','equipmenttype'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('creat_time').$this->drawOrderArrow('creat_time'),'#',$this->createOrderLink('equipment','equipmenttype'))
        ;
        ?>
    </th>
    <th width="10%"></th>
</tr>
