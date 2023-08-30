<?php
$this->pageTitle=Yii::app()->name . ' - Credits for';
?>
<?php $form=$this->beginWidget('TbActiveForm', array(
    'id'=>'Material-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true,),
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

<section class="content-header">
    <h1>
        <strong><?php echo Yii::t('material','Material Form'); ?></strong>
    </h1>
    <!--
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Layout</a></li>
            <li class="active">Top Navigation</li>
        </ol>
    -->
</section>

<section class="content">
    <div class="box"><div class="box-body">
            <div class="btn-group" role="group">
                <?php
                if ($model->scenario!='new' && $model->scenario!='view') {
                    echo TbHtml::button('<span class="fa fa-file-o"></span> '.Yii::t('misc','Add Another'), array(
                        'submit'=>Yii::app()->createUrl('materiallist/new')));
                }
                ?>
                <?php echo TbHtml::button('<span class="fa fa-reply"></span> '.Yii::t('misc','Back'), array(
                    'submit'=>Yii::app()->createUrl('materiallist/index')));
                ?>
                <?php
                echo TbHtml::button('<span class="fa fa-upload"></span> '.Yii::t('misc','Save'), array(
                    'submit'=>Yii::app()->createUrl('materiallist/save')));
                ?>
                <?php if($model->id){ echo TbHtml::button('<span class="fa fa-remove"></span> '.Yii::t('misc','Delete'), array( 'submit'=>Yii::app()->createUrl('materiallist/delete'))
                );}
                ?>
            </div>
            <div class="btn-group pull-right" role="group">
                <!--                --><?php
                //                $counter = ($model->no_of_attm['icut'] > 0) ? ' <span id="docicut" class="label label-info">'.$model->no_of_attm['icut'].'</span>' : ' <span id="docicut"></span>';
                //                echo TbHtml::button('<span class="fa  fa-file-text-o"></span> '.Yii::t('misc','Attachment').$counter, array(
                //                        'name'=>'btnFile','id'=>'btnFile','data-toggle'=>'modal','data-target'=>'#fileuploadicut',)
                //                );
                //                ?>
            </div>
        </div></div>

    <div class="box box-info" style=" padding-bottom: 10px;">
        <div class="box-body">
            <?php echo $form->hiddenField($model, 'scenario'); ?>
            <?php echo $form->hiddenField($model, 'id',array("id"=>"id")); ?>

            <div class="form-group">
                <?php echo $form->labelEx($model,'name',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->textField($model, 'name',
                        array('size'=>40,'maxlength'=>250,"id"=>"name",'readonly'=>false)
                    ); ?>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model,'classify_id',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-2">
                    <?php
                    echo $form->dropDownList($model, 'classify_id', $maclass);
                    ?>
                </div>
            </div>
            <div class="form-group" style="padding-bottom: 10px;">
                <?php echo $form->labelEx($model,'registration_no',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->textField($model, 'registration_no',array('readonly'=>false)
                    ); ?>
                </div>
            </div>
            <div class="form-group" style="padding-bottom: 10px;">
                <?php echo $form->labelEx($model,'validity',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->textField($model, 'validity',array('readonly'=>false)
                    ); ?>
                </div>
                <div class="col-sm-6">
                    <p class="form-control-static" style="color: #c50303;">填写格式例如：2021-07-11</p >
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model,'active_ingredient',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->textField($model, 'active_ingredient',
                        array("id"=>"active_ingredient",'readonly'=>false)
                    ); ?>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model,'ratio',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->textField($model, 'ratio',
                        array("id"=>"ratio",'readonly'=>false)
                    ); ?>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model,'unit',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->textField($model, 'unit',
                        array("id"=>"unit",'readonly'=>false)
                    ); ?>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model,'status',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-2">
                    <?php
                    echo $form->dropDownList($model, 'status', $status_lists);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model,'sort',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->textField($model, 'sort',
                        array("id"=>"unit",'readonly'=>false)
                    ); ?>
                </div>
                <div class="col-sm-6">
                    <p class="form-control-static" style="color: #c50303;">填写范围例如：1~100，（与小程序里选择物料的顺序是挂钩的，排序值越高则选择物料的顺序越靠前，反之越低则越靠后，1是最高，100是最低。）</p >
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model,'brief',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-7">
                    <?php echo $form->textArea($model, 'brief',
                        array('rows'=>3,'cols'=>60,'maxlength'=>5000,'readonly'=>false)
                    ); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="MaterialFrom_brief">
                    附件
                </label>
                <div style="display:flex;">
                    <div class="imgList">

                    </div>
                    <div class="add-button-ui"></div>
                    <?php //echo $model->id;?>
                </div>
            </div>
            <div class="form-group" style="display: none;">
                <label class="col-sm-2 control-label" for="MaterialFrom_brief">
                    图片
                </label>
                <div class="col-sm-7">
                    <?php echo $form->textArea($model, 'img_arr',
                        array('rows'=>3,'cols'=>60,'maxlength'=>5000,'readonly'=>false)
                    ); ?>
                </div>
            </div>
</section>


<?php //$this->renderPartial('//site/fileupload',array('model'=>$model,
//    'form'=>$form,
//    'doctype'=>'ICUT',
//    'header'=>Yii::t('dialog','File Attachment'),
//    'ronly'=>($model->scenario=='view'),
//));
//?>
<?php

$js = '
    $(function () {
        $(".btnIntegralApply").on("click",function () {
            $("#gift_type").val($("#rq_gift_id").val());
            $("#gift_name").val($("#rq_gift_name").val());
            $("#bonus_point").val($("#rq_bonus_point").val());
            $("#integralApply").modal("show");
            return false;
        })
    })
    ';
Yii::app()->clientScript->registerScript('calcFunction',$js,CClientScript::POS_READY);
Script::genFileUpload($model,$form->id,'ICUT');
$js = Script::genReadonlyField();
Yii::app()->clientScript->registerScript('readonlyClass',$js,CClientScript::POS_READY);
?>

<?php $this->endWidget(); ?>


<script>
    $(function () {
        console.log('loading')

        // let arrList = '[{"startDate":"","endDate":"","img":"http://localhost:10003/LBS/sales-report/upload/materiel/1693364050.jpg"},{"startDate":"","endDate":"","img":"http://localhost:10003/LBS/sales-report/upload/materiel/1693364055.jpg"},{"startDate":"","endDate":"","img":"http://localhost:10003/LBS/sales-report/upload/materiel/1693364080.png"}]';
        // console.log(arrList)

        // 读取值
        var arrList = '<?=$model->img_arr;?>';
        $('#MaterialFrom_img_arr').val(arrList)
        if(arrList){
            arrList = JSON.parse(arrList)
            foreach(arrList)
        }
    })
    function foreach(arr) {
        var html="";
        $.each(arr,function(key,val){

            html+='<div class="item">' +
                '<div class="thumb"><img src="'+val.img+'"/></div>' +
                '<div class="date">证件名称:'+val.papersname+'</div>' +
                '<div class="date">生效日期:'+val.startDate+'</div>' +
                '<div class="date">截止日期:'+val.endDate+'</div>' +
                '<div class="del"><span data-id="'+key+'">删除</span></div>'+
                '</div>';
        });
        $(".imgList").empty()
        $(".imgList").append(html);
        $('.del').on('click',function(){
            var thisBtn = $(this);
            var xid = thisBtn.find('span').attr('data-id')
            var arrdel = JSON.parse($('#MaterialFrom_img_arr').val())
            arrdel.splice(xid,1);
            $('#MaterialFrom_img_arr').val(JSON.stringify(arrdel));
            foreach(arrdel)
        })
    }
</script>

<style>
    /* 上传附件按钮 */
    .add-button-ui {
        width: 40px;
        height: 40px;
        background: #46b8ef;
        border-radius: 40px;
        position: relative;
        cursor: pointer;
    }
    .add-button-ui::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 2px;
        background: #fff;
        margin: -1px 0 0 -10px;
    }
    .add-button-ui::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 2px;
        height: 20px;
        background: #fff;
        margin: -10px 0 0 -1px;
    }
    /* 自定义上传按钮 */
    .upload-img-ui{
        margin: 10px 0 0 0;
        width: 60px;
        height: 60px;
        background: #fff;
        text-align: center;
        border-radius: 5px;
        line-height: 60px;
        color: #fff;
        cursor: pointer;
        position: relative;
        border: 2px solid #eee;
    }
    .upload-img-ui::after{
        content:"";
        width: 30px;
        height: 2px;
        position: absolute;
        top:50%;
        left: 50%;
        margin: -1px 0 0 -15px;
        background: #eee;
    }
    .upload-img-ui::before{
        content:"";
        width: 2px;
        height: 30px;
        position: absolute;
        top:50%;
        left: 50%;
        margin: -15px 0 0 -1px;
        background: #eee;
    }
    /* 图片预览 */
    #img{ max-width: 100%; }
    .imgList{
        display: flex;
        justify-content: flex-start;
    }
    .imgList .item{
        min-width: 200px;

    }
    .imgList .item .thumb{
        max-width: 100px;
        min-height: 100px;
        margin-bottom: 5px;
    }
    .imgList .item .thumb img{ width: 100%; }
    .imgList .item .date{ margin-bottom: 10px; }
    .imgList .item .del{ width:auto; height: 30px; line-height: 30px; font-size: 14px; background: #ee3148; color: #fff; display: inline-block; padding: 0 10px; border-radius: 5px; cursor: pointer; }
</style>

<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">上传</h4>
            </div>
            <div class="modal-body">
                <div style="padding: 40px 40px;">
                    <div class="form-group">
                        <label for="name">证件名称</label>
                        <input type="text" class="form-control" id="papersname" placeholder="请输入证件名称">
                    </div>
                    <div class="form-group">
                        <label for="name">生效日期</label>
                        <input type="text" class="form-control" id="startDate" placeholder="请输入生效日期">
                    </div>
                    <div class="form-group">
                        <label for="name">截止日期</label>
                        <input type="text" class="form-control" id="endDate" placeholder="请输入截止日期">
                    </div>
                    <div class="form-group">
                        <label for="inputfile">图片上传</label>
                        <div class="upload-img-ui"></div>
                    </div>
                    <div class="form-group">
                        <label for="inputfile">图片预览</label>
                        <div class="form-group">
                            <img id="img" src="" />
                        </div>
                        <div style="display: none;">
                            <input type="file" id="file" name="file">
                        </div>
                    </div>
                    <!-- 证件循环 -->
                    <div class="thumb_list">

                    </div>
                    <div class="form-group" style="display: none;">
                        <label for="name">图片地址</label>
                        <input type="text" id="imgurl" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                </button>
                <button type="button" class="btn btn-primary" id="submit">
                    确定
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script>
$(function () {

    /* 上传图片 */
    $('.upload-img-ui').on('click',function(){
        $('#file').click()
    })
    $("#file").change(function(e) {
        var file = $("#file").get(0).files[0];

        if(file){
            var formData = new FormData();
            formData.append('img', $('#file')[0].files[0]);

            var str = window.location.href
            var index = str.indexOf("index.php")
            var path_url = str.substring(0, index);

            $.ajax( {
                url: "<?=Yii::app()->createUrl('materiallist/upload');?>",
                type: 'POST',
                dataType: "json",
                async: false,
                cache: false,
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    console.log(path_url + data.img)
                    $('#img').attr('src',path_url+data.img)
                },
                error: function(data) {

                }
            })
        }
    })
    /* push对象 */
    $('#submit').on('click',function(){
        let papersname = $('#papersname').val();
        let startDate = $('#startDate').val();
        let endDate   = $('#endDate').val();
        let img       = $('#img').attr('src')
        let obj = {
            papersname:papersname,
            startDate:startDate,
            endDate:endDate,
            img:img
        }
        // console.log(obj)
        var imgArr = []

        if($('#MaterialFrom_img_arr').val()){

            let imgStr = $('#MaterialFrom_img_arr').val()
            let imgStrx = JSON.parse(imgStr)

            imgStrx.push(obj)
            imgArr = imgStrx
        }else{
            imgArr.push(obj)
        }

        // each start
        var html="";
        $.each(imgArr,function(key,val){

            html+='<div class="item">' +
                '<div class="thumb"><img src="'+val.img+'"/></div>' +
                '<div class="date">证件名称:'+val.papersname+'</div>' +
                '<div class="date">生效日期:'+val.startDate+'</div>' +
                '<div class="date">截止日期:'+val.endDate+'</div>' +
                '<div class="del"><span data-id="'+key+'">删除</span></div>'+
                '</div>';
        });
        $(".imgList").empty()
        $(".imgList").append(html);
        $('.del').on('click',function(){
            var thisBtn = $(this);

            var xid = thisBtn.find('span').attr('data-id')
            console.log(xid)

            var arrdel = JSON.parse($('#MaterialFrom_img_arr').val())
            arrdel.splice(xid,1);
            console.log(arrdel)

            $('#MaterialFrom_img_arr').val(JSON.stringify(arrdel));

            foreach(arrdel)
        })
        // each end
        $('#MaterialFrom_img_arr').val(JSON.stringify(imgArr))

        $('#myModal').modal('hide')

        $('#papersname').val('');
        $('#startDate').val('');
        $('#endDate').val('');
        $('#img').attr('src','')
        $('#file').val()
    })
    /* 显示模态框 */
    $('.add-button-ui').on('click',function(){

        $('#myModal').modal('show')
    })
})
</script>