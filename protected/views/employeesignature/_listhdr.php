<tr>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <th>
            <?php echo TbHtml::link($this->getLabelName('city_name').$this->drawOrderArrow('city_name'),'#',$this->createOrderLink('employeesignature','city_name'))
            ;
            ?>
        </th>
    <?php endif ?>
    <th>
        <?php echo TbHtml::link($this->getLabelName('staffid').$this->drawOrderArrow('staffid'),'#',$this->createOrderLink('employeesignature','staffid'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('staffname').$this->drawOrderArrow('staffname'),'#',$this->createOrderLink('employeesignature','staffname'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('signature').$this->drawOrderArrow('signature'),'#',$this->createOrderLink('employeesignature','signature'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('creat_time').$this->drawOrderArrow('creat_time'),'#',$this->createOrderLink('employeesignature','usearea'))
        ;
        ?>
    </th>
    <th width="10%"></th>
</tr>
