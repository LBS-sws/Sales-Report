<?php
$this->pageTitle = Yii::app()->name . ' - Riskrank';
?>

<?php
//if (1) {
//    $file_url = Yii::app()->createAbsoluteUrl('statement/test',array('fid'=>1233,'test'=>123));
//    $js = "$(location).attr('href','$file_url');";
//    Yii::app()->clientScript->registerScript('redirection',$js,CClientScript::POS_READY);
//}
//?>
<?php $form = $this->beginWidget('TbActiveForm', array(
    'id' => 'WorkOrder',
    'enableClientValidation' => false,
    'clientOptions' => array('validateOnSubmit' => false,),
    'layout' => TbHtml::FORM_LAYOUT_INLINE,
)); ?>

<section class="content" id="app">
    <div class="box">
        <div class="box-body" style="min-height: 100px; ">
            <div>

                <el-form ref="form" :model="form" label-width="80px" style="display: flex; justify-content: flex-start; " >

                    <el-form-item label="地区" style="width: 200px;">
                        <el-input v-model="form.name"></el-input>

                    </el-form-item>




                    <el-form-item label="时间" >
                        <el-date-picker
                                v-model="form.date"
                                type="daterange"
                                range-separator="至"
                                start-placeholder="开始日期"
                                end-placeholder="结束日期"
                                value-format="yyyy-MM-dd"

                        >
                        </el-date-picker>
                    </el-form-item>

<!--                    <el-button type="primary" style="margin-left: 20px; height: 40px;">搜索</el-button>-->
                    <el-button style="margin-left: 20px; height: 40px;" @click="exportData" type="primary" >导出</el-button>

                </el-form>
            </div>
        </div>
    </div>

</section>

<?php $this->endWidget(); ?>

<script src="./../../js/vue.js"></script>
<script src="./../../js/element.js"></script>
<script src="./../../js/echarts.js"></script>
<script src="./../../js/xlsx.core.min.js"></script>
<script src="./../../js/axios.min.js"></script>
<!-- 引入样式 -->
<link rel="stylesheet" href="./../../css/element-ui.css">

<!-- 引入组件库 -->
<!---->

<script>
    new Vue({
        el: '#app',
        data() {
            return {
                api_url:'<?php echo $api_url;?>',
                city:[<?php echo $city;?>],
                form :{
                    name:'',
                    date:[]
                },

            }
        },
        watch: {
            // 监听日期清理后数据为null进行处理否则会报错
            'form.date'(newVal) {
                if (newVal == null) {
                    this.form.date = ''

                }
            }
        },
        created(){

            // this.form.date = ['2024-01-01','2024-12-31']
            // console.log(this.form.date)

        },
        computed:{

        },
        methods: {

            // 导出
            exportData(){
                console.log(this.form.name)
                console.log(this.form.date)

                // let date = JSON.stringify(this.form.date)

                let url = '<?php echo $api_url;?>' + 'index.php/api/Risk/export';
                axios.post(url, {
                    name: this.form.name,
                    date: this.form.date,
                }).then(function (response) {
                    console.log(response);
                    if(response.data.code==400){
                        alert(response.data.msg)
                    }
                    if(response.data.code==200){
                        console.log(response.data.data.file_url)
                        window.location.href = response.data.data.file_url
                    }

                }).catch(function (error) {
                    console.log(error);
                });

                //console.log('导出...')
                //let domain = '<?php //echo $api_url;?>//'
                //// console.log(domain)
                //
                //let url = domain + 'index.php/api/Risk/export';
                //// console.log(url)
                //
                //window.open(url);       //在当前窗口中打开窗口
                //
                //console.log('导出')
            }
        },
        mounted(){

        },

    })
</script>

<style>

</style>
