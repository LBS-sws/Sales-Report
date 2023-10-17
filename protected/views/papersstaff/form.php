<style>
    .input-ui {
        -webkit-appearance: none;
        background-color: #fff;
        background-image: none;
        border-radius: 4px;
        border: 1px solid #dcdfe6;
        box-sizing: border-box;
        color: #606266;
        display: inline-block;
        font-size: inherit;
        height: 40px;
        line-height: 40px;
        outline: none;
        padding: 0 15px;
        transition: border-color .2s cubic-bezier(.645,.045,.355,1);
        width: 100%;
    }
    .input-ui{ max-width:200px; font-size:14px; }
    #searchResults{ padding:0; margin:0 ;}
    #searchResults li{
        font-size:14px;
        color: #606266;
        list-style: none;
        position: relative;
        display: flex;
        align-items: center;
        padding: 0 30px 0 20px;
        height: 34px;
        line-height: 34px;
        outline: none;
        cursor:pointer;
    }
    #searchResults li:hover {
        background: #f5f7fa
    }
    .search{
        display: block;
        position: absolute;

        background-color: #ffffff;
        width: auto;
        height: auto;
        border: 1px solid #eee;
        overflow: auto;
        max-height: 400px;
    }
    #selectCustom{ width: 200px; }
    #selectCustom>div{ padding: 10px 10px; cursor:pointer; }
    #selectCustom>div:hover{   background: #eee;  }
    #selectCustom>div .in{ padding: 10px 10px 3px 0; }

</style>

<?php
$this->pageTitle=Yii::app()->name . ' - Credits for';
?>
<?php $form=$this->beginWidget('TbActiveForm', array(
    'id'=>'Papersstaff-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true,),
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>


<section class="content-header">
    <h1>
        <strong><?php echo Yii::t('papersstaff','Papersstaff Form'); ?></strong>
    </h1>
</section>

<section class="content">
    <div class="box"><div class="box-body">
            <div class="btn-group" role="group">
                <!-- 返回 -->
                <?php echo TbHtml::button('<span class="fa fa-reply" id="back"></span> '.Yii::t('misc','Back'), array(
                    'submit'=>Yii::app()->createUrl('papersstaff/index')));
                ?>
                <?php
                // 判断如果是编辑不显示保存
                if(!$item['id']){
                    echo TbHtml::button('<span class="fa fa-upload"></span> '.Yii::t('misc','Save'), array(
                        'submit'=>Yii::app()->createUrl('Papersstaff/save')));
                }
                ?>
            </div>
            <div class="btn-group pull-right" role="group">

            </div>
        </div>
    </div>

    <div class="box box-info" style=" padding-bottom: 10px;">
        <div class="box-body">
            <?php echo $form->hiddenField($model, 'scenario'); ?>
            <?php echo $form->hiddenField($model, 'id',array("id"=>"id")); ?>
            <?php echo $form->hiddenField($model, 'signature',array("id"=>"signature")); ?>

            <!---->
            <?php if(!$item['id']){?>
                <div class="form-group">
                    <?php echo $form->labelEx($model,'staffid',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php
                        //echo $form->dropDownList($model, 'staffid', $employee_lists);
                        ?>

                        <div style="display: none;">
                        <?php
                        echo $form->textField($model, 'staffid',
                            array('size'=>40,'maxlength'=>250,"id"=>"staffid",'readonly'=>false)
                        );
                        ?>
                        </div>
                        <div style="display: flex; ">
                        </div>
                        <div>
                            <input type="text" id ="selectSearch" class="input-40 form-control"/>

                            <form ation="#" >
                                <div id="selectCustom" class="search"> </div>
                            </form>

                        </div>
                    </div>
                </div>
            <?php }?>

            <?php if($item['id']){?>
                <div class="form-group">
                    <?php echo $form->labelEx($model,'staffid',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-2">
                        <input maxlength="250" id="name" name="staffname" value="<?php echo $item['code']."[".$item['name']."]"?>" class="input-40 form-control" type="text" >
                    </div>
                </div>
            <?php }?>
            <!-- 新增证件按钮 -->
            <?php if($item['id']){ ?>
                <div style="margin-left: 40%;">
                    <div class="add-button-ui" ></div>
                </div>
            <?php }?>
            <!-- 证件列表 -->
            <div class="Papersstaff_list" style="margin-top:30px;">
            </div>

            <div>
                <ul id="searchResults" style="max-width: 200px;"></ul>
            </div>
        </div>

        <script type="text/javascript" >
            $(function(){

                var dataSource = new Array();
                <?php
                foreach($employee_lists as $key => $value) {
                    echo "dataSource.push({id:'$key',name:'$value'});";
                }
                ?>
                coverOption(dataSource);
                console.log(dataSource)

                $("#selectSearch").keyup(function(){
                    var val1 =$("#selectSearch").val();
                    var newList = [];
                    for(var i=0;i<dataSource.length;i++){
                        if(dataSource[i].name.indexOf(val1)>-1){
                            newList.push(dataSource[i]);
                        }
                    }
                    coverOption(newList);
                });
                $("#selectCustom").hide();
                $("#selectSearch").click(function(){
                    $("#selectCustom").show();
                });
                var width1 = $(".zidingyi").width();
                $("#selectCustom").css("margin-left",(width1+5)+'px');
            });

            function coverOption(list){
                $("#selectCustom").html('');
                var tmp =[];
                for(var i=0;i<list.length;i++){
                    var str = '<div class="inBox"><input class="in" name="selectCustom" data-id="'+list[i].id+'" title="'+list[i].name+'" '+
                        ' type="radio" value="'+list[i].id+'" />'+list[i].name+'</div>';
                    tmp.push(str);
                }
                $("#selectCustom").html(tmp);



                var dataSource = new Array();
                <?php
                foreach($employee_lists as $key => $value) {
                    echo "dataSource.push({id:'$key',name:'$value'});";
                }
                ?>
                $(".inBox").click(function(){

                    let index = $(this).index()
                    $('input:radio').eq(index).attr('checked', 'true');

                    $("#selectSearch").val(dataSource[index].name)

                    $('#staffid').val(dataSource[index].id)

                    $("#selectCustom").hide();
                })
            }
            $('#selectSearch').on('input', function() {
                var value = $(this).val();
                console.log('输入框的值变为：' + value);
                if(!value){
                    $('#staffid').val('')
                }
                //
            });
        </script>
</section>

<?php if($item['id']){?>
    <!-- 模态框（Modal） -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">标题</h4>
                </div>
                <div class="modal-body">
                    <div style="padding: 40px 40px;">
                        <div class="form-group">
                            <label for="name">员工编号</label>
                            <input type="hidden" id="id" value="0" />
                            <input type="text" class="form-control" id="staffCode" placeholder="请输入员工编号">
                        </div>
                        <div class="form-group">
                            <label for="name">证件名称</label>
                            <input type="text" class="form-control" id="papersName" placeholder="请输入证件名称">
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
                            <label for="inputfile">证件图片</label>
                            <div class="upload-img-ui"></div>
                        </div>
                        <div class="form-group">
                            <label for="inputfile">证件图片</label>
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
                        提交
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
<?php }?>

<?php $this->endWidget(); ?>

<script>
    let id = "<?=$item['id'];?>";
    let staffCode = "<?=$item['code'];?>";
    var xid = 0;

    console.log('编号：'+staffCode)
    console.log('id:'+id)

    // 项目index.php目录
    let str = window.location.href
    let index = str.indexOf("index.php")
    let path_url = str.substring(0, index);
    console.log(path_url)

    if(id){
        $('#staffCode').val(staffCode)
    }

    $(function () {
        /* 数据列表 */
        $.ajax({
            url:"<?=Yii::app()->createUrl('papersstaff/list');?>",
            type:"get",
            dataType:"json",
            async: false,
            data:{id:id},
            success: function (data) {

                var html="";
                $.each(data.data, function(k,v) {
                    let arr = v.imgUrl.split(',')
                    var htmlxx = ""
                    arr.forEach((item,index)=>{
                        // console.log(item)
                        htmlxx+= '<div class="item-img"><img src="'+path_url+item+'"/></div>'
                    })

                    html+='<div class="item"><div class="form-group">'+
                        '<label class="col-sm-2 control-label" >证件名称</label>'+
                        '<div class="col-sm-2"><input type="text" class="input-40 form-control" value="'+v.PapersName+'" readonly /> </div>'+
                        '</div>'+
                        '<div class="form-group">'+
                        '<label class="col-sm-2 control-label" for="PapersstaffForm_staffid">生效日期</label>'+
                        '<div class="col-sm-2"><input type="text" class="input-40 form-control" value="'+v.StartDate+'" readonly /> </div>'+
                        '</div>'+
                        '<div class="form-group">'+
                        '<label class="col-sm-2 control-label" for="PapersstaffForm_staffid">截止日期</label>'+
                        '<div class="col-sm-2"><input type="text" class="input-40 form-control" value="'+v.EndDate+'" readonly /> </div>' +

                        '<div class="edit"><span data-id="'+v.id+'">编辑</span></div>'+
                        '<div class="dele"><span data-id="'+v.id+'">删除</span></div>'+
                        '</div>' +
                        '<div class="right-thumb">'+htmlxx+'</div>'+
                        '</div>'
                });
                $(".Papersstaff_list").append(html);

                $('.edit').on('click',function(){

                    var thisBtn = $(this);

                    var xid = thisBtn.find('span').attr('data-id')
                    console.log(xid)

                    $.ajax({
                        url:"<?=Yii::app()->createUrl('papersstaff/item');?>",
                        type:"get",
                        dataType:"json",
                        async: false,
                        data:{id:xid},
                        success:function(data){
                            console.log(data.data)
                            let item = data.data
                            $('#myModal').modal('show')

                            $('#id').val(item.id)
                            $('#papersName').val(item.PapersName)
                            $('#startDate').val(item.StartDate)
                            $('#endDate').val(item.EndDate)
                            $('#imgurl').val(item.imgUrl)
                            let imgString = item.imgUrl
                            var b = imgString

                            console.log(b)
                            let arr = b.split(',')
                            //
                            $('.thumb_list').empty()
                            var htmlx="";
                            $.each(arr, function(k,v) {
                                htmlx+='<div class="item-img">'+
                                    '<img src="'+path_url+v+'"/>'+
                                    '</div>'
                            });
                            $(".thumb_list").append(htmlx);

                        },error:function(e){
                            console.log(e.responseText);
                        }
                    });
                })
                $('.dele').on('click',function(){
                    var thisBtn = $(this);

                    var xid = thisBtn.find('span').attr('data-id')
                    console.log(xid)
                    $.ajax({
                        url:"<?=Yii::app()->createUrl('papersstaff/deletex');?>",
                        type:"get",
                        dataType:"json",
                        async: false,
                        data:{id:xid},
                        success:function(data){
                            console.log(data.data)
                            window.location.reload()

                        },error:function(e){
                            console.log(e.responseText);
                        }
                    });
                })
            }
        });
    })

    // 上传图片
    $("#file").change(function(e){

        var file = $("#file").get(0).files[0];
        // console.log($('#imgurl').val())
        // return false
        if(file){
            var formData = new FormData();
            formData.append('img', $('#file')[0].files[0]);

            let imgString = $('#imgurl').val()
            var b = ''

            $.ajax( {
                url: "<?=Yii::app()->createUrl('papersstaff/upload');?>",
                type: 'POST',
                dataType: "json",
                async: false,
                cache: false,
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    // console.log(data.img)

                    if(!imgString){
                        $('#imgurl').val(data.img)
                        b = data.img
                    }else{
                        $('#imgurl').val(imgString+','+data.img)
                        b = imgString+','+data.img
                    }
                    console.log(b)
                    let arr = b.split(',')
                    //
                    $('.thumb_list').empty()
                    var htmlx="";
                    $.each(arr, function(k,v) {
                        htmlx+='<div class="item-img">'+
                            '<img src="'+path_url+v+'"/>'+
                            '</div>'
                    });
                    $(".thumb_list").append(htmlx);

                },
                error: function(data) {

                }
            })
        }
    })
    // 自定义上传图片点击
    $('.upload-img-ui').on('click',function(){
        $('#file').click()
    })


    // add/save 证件
    $("#submit").on('click',function(){

        console.log($('#id').val())

        let xid = $('#id').val()
        let code = $('#staffCode').val()
        let name = $('#papersName').val()
        let startDate = $('#startDate').val()
        let endDate = $('#endDate').val()
        let imgUrl = $('#imgurl').val()

        $.ajax( {
            url: "<?=Yii::app()->createUrl('papersstaff/UpdateData');?>",
            type: 'POST',
            dataType: "json",
            async: false,
            cache: false,
            data: {id:xid,papersstaff_id:id,name:name,code:code,startDate:startDate,endDate:endDate,imgUrl:imgUrl},
            success: function(data) {
                if(data.id){
                    alert('操作成功')
                    window.location.reload()
                }
            },
            error: function(data) {

            }
        })

    })


    $('.add-button-ui').on('click',function(){
        $('#id').val('')
        $('#myModal').modal('show')
    })
    /* 返回 */
    $("#yt0").on('click',function(){
        window.location.href="<?=Yii::app()->createUrl('Papersstaff/index');?>"
    })
</script>

<script>
$(function () {

    var js_array = new Array();

    <?php
    foreach($employee_lists as $key => $value) {
//        echo "js_array.push('$value');";
        echo "js_array.push({id:'$key',name:'$value'});";
    }
    ?>

    // console.log(js_array);

    $('#myInput').on('input', function() {
        var value = $(this).val();
        console.log('输入框的值变为：' + value);
        $('#staffid').val(value)
    });
    $('#searchInput').on('input', function() {
        var keyword = $(this).val().toLowerCase();
        $('#searchResults').empty(); // 清空搜索结果列表

        if (keyword.length > 0) {
            // 模拟搜索结果
            var results = ['Apple', 'Banana', 'Orange', 'Pineapple'];

            js_array.forEach(function(item,index) {
                    // console.log(item.id+item.name)
                    // console.log(item.name)
                if (item.name.indexOf(keyword) !== -1) {
                    $('#searchResults').append('<li data-id="'+item.id+'">' + item.name+'-'+item.id+'' + '</li>');

                }
            });

            $('#searchResults li').on('click',function(e){
                let text = $(this).text()
                console.log($(this).index())
                console.log(text)
                console.log($(this).attr('data-id'))
                $('#myInput').val(text)

                $('#staffid').val($(this).attr('data-id'))
            })
        }
    });

})
</script>

<style>
    .add-button-ui{
        width: 40px;
        height: 40px;
        background: #46b8ef;
        border-radius: 40px;
        position: relative;
        cursor:pointer;
    }
    .add-button-ui::after{
        content:'';
        position: absolute;
        top:50%;
        left:50%;
        width: 2px;
        height: 20px;
        background: #fff;
        margin:-10px 0 0 -1px;
    }
    .add-button-ui::before{
        content:'';
        position: absolute;
        top:50%;
        left:50%;
        width: 20px;
        height: 2px;
        background: #fff;
        margin:-1px 0 0 -10px;
    }

    .Papersstaff_list .m-b-30{
        margin-bottom: 30px;
    }
    .Papersstaff_list .item{ position: relative; margin-bottom: 50px; }
    .Papersstaff_list .item .right-thumb{ position: absolute; top: 0; left: 50%; width: 100%; height: 120px; display: flex; justify-content: flex-start;  }
    .Papersstaff_list .item .right-thumb .item-img{ width:80px; margin-right: 5px; }
    .Papersstaff_list .item .right-thumb img{ width: 100%; }
    .form-group img{ width:100%; }

    /* 证件图片列表 */
    .thumb_list{ display: flex; justify-content: flex-start; flex-wrap: wrap; }
    .thumb_list .item-img{ width: 240px; }
    .thumb_list .item-img img{ width: 100%; }

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
    .edit{
        width: 60px;
        display: inline-block;
        height: 34px;

        border: 1px solid #bbb9b9;
        text-align: center;
        line-height: 34px;
        border-radius: 5px;
        color: #666;
    }
    .dele{
        width: 60px;
        display: inline-block;
        height: 34px;
        border: 1px solid #bbb9b9;
        text-align: center;
        line-height: 34px;
        border-radius: 5px;
        color: #666;
        margin-left:10px;
    }
</style>
