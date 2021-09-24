<tr>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <th>
            <?php echo TbHtml::link($this->getLabelName('city_name').$this->drawOrderArrow('city_name'),'#',$this->createOrderLink('material','city_name'))
            ;
            ?>
        </th>
    <?php endif ?>
    <th>
        <?php echo TbHtml::link($this->getLabelName('target').$this->drawOrderArrow('target'),'#',$this->createOrderLink('risk','riskpest'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('creat_time').$this->drawOrderArrow('creat_time'),'#',$this->createOrderLink('risk','riskpest'))
        ;
        ?>
    </th>
    <th width="10%"></th>
</tr>
