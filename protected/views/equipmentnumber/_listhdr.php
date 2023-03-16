<tr>
    <th><input type="checkbox" value="" name="chkboxAll" id="chkboxAll"></th>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <th>
            <?php echo TbHtml::link($this->getLabelName('city_name').$this->drawOrderArrow('city_name'),'#',$this->createOrderLink('material','city_name'))
            ;
            ?>
        </th>
    <?php endif ?>
    <th>
        <?php echo TbHtml::link($this->getLabelName('name').$this->drawOrderArrow('name'),'#',$this->createOrderLink('equipment','equipmentnumber'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('equipment_number').$this->drawOrderArrow('equipment_number'),'#',$this->createOrderLink('equipment','equipmentnumber'))
        ;
        ?>
    </th>
<!--    <th>-->
<!--        --><?php //echo TbHtml::link($this->getLabelName('status').$this->drawOrderArrow('status'),'#',$this->createOrderLink('equipment','equipmentnumber'))
//        ;
//        ?>
<!--    </th>-->
    <th>
        <?php echo TbHtml::link($this->getLabelName('downcount').$this->drawOrderArrow('downcount'),'#',$this->createOrderLink('equipment','equipmentnumber'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('creat_time').$this->drawOrderArrow('creat_time'),'#',$this->createOrderLink('equipment','equipmentnumber'))
        ;
        ?>
    </th>
    <th>
    </th>
</tr>