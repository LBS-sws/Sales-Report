<tr>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <th>
            <?php echo TbHtml::link($this->getLabelName('city_name').$this->drawOrderArrow('city'),'#',$this->createOrderLink('pesttype','city'))
            ;
            ?>
        </th>
    <?php endif ?>
    <th>
        <?php echo TbHtml::link($this->getLabelName('type_name').$this->drawOrderArrow('type_name'),'#',$this->createOrderLink('pesttype','type_name'))
        ;
        ?>
    </th>

    <th>
        <?php echo TbHtml::link($this->getLabelName('created_at').$this->drawOrderArrow('created_at'),'#',$this->createOrderLink('pesttype','created_at'))
        ;
        ?>
    </th>

</tr>
