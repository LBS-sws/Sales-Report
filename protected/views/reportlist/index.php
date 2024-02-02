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
        <div class="box-body">
            <div>
                <div>
                    <span class="demonstration">客户名称：</span>

                    <!-- 远程搜索要使用filterable和remote -->
                    <el-autocomplete srt
                                     v-model="state2"
                                     clearable
                                     :fetch-suggestions="querySearch"
                                     placeholder="请输入内容"
                                     :trigger-on-focus="false"
                                     @select="handleSelect"
                                     size="small"
                    ></el-autocomplete>


                    <el-button style="margin-left: 20px" @click="getCustomerList()" type="primary">查询</el-button>
                </div>
            </div>
        </div>
    </div>
    <div>
        <!-- 表格分页 -->
        <!-- pager-count pager-count属性可以设置最大页码按钮数,超出折叠,默认为7-->
        <!-- 注意：若数据是后端接口返回的则此时:total="pageCount"-->
        <el-pagination
            @size-change="handleSizeChange"
            @current-change="handleCurrentChange"
            :pager-count="7"
            :current-page="currentPage"
            :page-sizes="[pagesize]"
            :page-count="pageCount"
            layout="total, sizes, prev, pager, next, jumper"
            :total="total">
        </el-pagination>
        <el-table
            :key="tableKey"
            :data="tableData"
            style="width: 100%">
            <el-table-column label="地区" prop="Text"> </el-table-column>

            <el-table-column label="客户名称" prop="NameZH"> </el-table-column>
            <el-table-column label="客户编号" prop="CustomerID"> </el-table-column>
            <el-table-column label="服务日期" prop="JobDate"> </el-table-column>

            <el-table-column label="鼠类发现数量" prop="risk_data[0][value]"> </el-table-column>
            <el-table-column label="鼠迹" prop="risk_data[1][value]"> </el-table-column>

            <el-table-column label="蟑螂活体数量" prop="risk_data[2][value]"> </el-table-column>
            <el-table-column label="蟑螂痕迹" prop="risk_data[3][value]"> </el-table-column>

            <el-table-column label="飞虫数量" prop="risk_data[4][value]"> </el-table-column>
            <el-table-column label="飞虫类目" prop="risk_data[5][value]"> </el-table-column>

<!--            <el-table-column label="操作">-->
<!--                <template slot-scope="scope">-->
<!---->
<!--                    <el-button size="mini" type="primary" @click="handleEdit(scope.$index, scope.row)">下载</el-button>-->
<!---->
<!--                </template>-->
<!--            </el-table-column>-->

        </el-table>


    </div>
</section>

<?php $this->endWidget(); ?>

<script src="./../../js/vue.js"></script>
<script src="./../../js/element.js"></script>
<script src="./../../js/echarts.js"></script>
<script src="./../../js/xlsx.core.min.js"></script>

<!-- 引入样式 -->
<link rel="stylesheet" href="./../../css/element-ui.css">

<!-- 引入组件库 -->
<!---->
<script>
    console.log("<?php echo $api_url;?>");
    console.log('123')
</script>
<script>
    new Vue({
        el: '#app',
        data() {
            return {
                date1: [],
                currentPage: 1,  //默认初始页
                pagesize: 15,    //每页默认显示的数据
                pageCount: 0,   //数据的总条数,如果数据是后端接口返回的，则此值需修改
                total:0,
                tableKey:'',
                tableData: [],
                searchKey:'',
                loading:false,
                api_url:'<?php echo $api_url;?>',
                //
                city:[<?php echo $city;?>],
                yearMonth:'',
                pickerOptions: {
                    // 限制时分秒
                    // 限制年月日
                    disabledDate:(time)=>{  // time为el-date-picker选择器的时间
                        const date = new Date()  // 获取当前时间
                        const year = date.getFullYear() // 转化当前年度
                        let month = date.getMonth() + 1  // 转化当前月份 需+1
                        if (month >= 1 && month <= 9) {   // 为1-9月前加上0  比如: 03
                            month = '0' + month
                        }
                        const currentDate = year.toString() + month.toString() //  将年份和月份拼接 202110
                        const timeYear = time.getFullYear()  //  将el-date-picker选择器转化为年份
                        let timeMonth = time.getMonth() + 1    //  将el-date-picker选择器时间转化为月份
                        if (timeMonth >= 1 && timeMonth <= 9) {  // 为1-9月前加上0  比如: 03
                            timeMonth = '0' + timeMonth
                        }
                        const timeDate = timeYear.toString() + timeMonth.toString()  // 将年份和月份拼接 会自动进行循环  自动拼接el-date-picker选择器的时间 例:202101
                        /**
                         * 可以取区间值
                         * 也可以某年某月之前或者之后
                         * timeDate 选择器时间
                         * currentDate 当前年月份  202110
                         */
                        return currentDate < timeDate || currentDate > timeDate  //  将2021年10之前和2021年10月之后禁用  只可选取2021年10月
                    }
                },
                dataList:[],
                state2: "",
                dataArr: [],
                popupVisible: false,
                //
                pickerOptions: {
                    shortcuts: [{
                        text: '最近一周',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: '最近一个月',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: '最近三个月',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
                            picker.$emit('pick', [start, end]);
                        }
                    }]
                },
            };
        },
        watch:{
            value:{
                handler:function(val){
                    this.copyValue=val;
                },
                deep:true
            }
        },
        created:{

        },
        computed:{
            queryParams() {
                return {
                    pageSize:-1,            //-1，查询所有数据
                    pageNumber:1,
                    schoolKey:this.keyWord
                }
            }
        },
        methods: {
            handleSelect(item) {
                this.searchKey = item.label??'';
                console.log(item.label);
            },
            showPopup() {
                this.popupVisible = true;
            },

            // 第二步
            // 当queryString不为空的时候，就说明用户输入内容了，我们把用户输入的内容在数据库中做对比，如果有能够模糊关联的，就直接取出
            // 并返回给带搜索建议的输入框，输入框就把返回的数据以下拉框的形式呈现出来，供用户选择。
            querySearch(queryString, cb) {
                if (queryString != "") {
                    // 输入内容以后才去做模糊查询
                    setTimeout(() => {
                        let callBackArr = []; // 准备一个空数组，此数组是最终返给输入框的数组
                        // 这个res是发请求，从后台获取的数据
                        console.log(queryString)
                        fetch(this.api_url+'index.php/api/Risk/list?q=' + queryString + '&city='+this.city , {
                            method: "get",
                            // body: JSON.stringify({City:val}),
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        }).then(result => {
                            // console.log(result);
                            return result.json();
                        }).then(res => {
                            // console.log(data);
                            if (res.code == 0) {
                                let result = res.data;
                                console.log(result)
                                result.forEach((item) => {
                                    // 把数据库做遍历，拿用户输入的这个字，和数据库中的每一项做对比
                                    // if (item.value.indexOf(queryString) == 0) { // 等于0 以什么什么开头
                                    // if (result.label.indexOf(queryString) > -1) { // 大于-1，只要包含就行，不再乎位置
                                    // 如果有具有关联性的数据
                                    callBackArr.push(item); // 就存到callBackArr里面准备返回呈现
                                    // }
                                });
                                // 经过这么一波查询操作以后，如果这个数组还为空，说明没有查询到具有关联的数据，就直接返回给用户暂无数据
                                if (callBackArr.length == 0) {
                                    cb([{ value: "暂无数据", label: "暂无数据" }]);
                                }
                                // 如果经过这一波查询操作以后，找到数据了，就把装有关联数据的数组callBackArr呈现给用户
                                else {
                                    cb(callBackArr);
                                }
                            } else {
                                this.gridData = []
                                this.$message({
                                    message: '暂无数据',
                                    type: 'warning'
                                });
                                setTimeout(() => {
                                    this.loading = false
                                }, 1000);
                            }
                        })
                    }, 1000);
                }
            },

            downloadPDF(url) {
                window.open(url, "_blank");
            },
            //表格编辑
            handleEdit(index, row) {
                console.log(row)
                this.loading = true
                this.$message({
                    message: '正在加载报告，请稍后~',
                    type: 'info'
                });
                // console.log(row.NameZH);
                // const dateStr = this.yearMonth;
                // const formattedDate = dateStr.replace(/-/g, "");
                console.log(this.city)
                fetch(this.api_url+'index.php/api/Customer/getPdf?' + 'month=' + row.date + '&cust=' + row.customer_id + '&custzh=' + encodeURIComponent(row.customer_name) + '&city=' + row.city, {
                    method: "get",
                    // body: JSON.stringify({City:val}),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then(result => {
                    // console.log(result);
                    return result.json();
                }).then(res => {
                    // console.log(data);
                    if (res.code == 0) {
                        let result = res.data;
                        this.downloadPDF(result)
                        setTimeout(() => {
                            this.loading = false
                        }, 1000);

                    } else {
                        this.$message({
                            message: '暂无数据',
                            type: 'warning'
                        });
                        setTimeout(() => {
                            this.loading = false
                        }, 1000);
                    }
                })
                this.yearMonth = ''
            },
            //表格删除
            handleClick(index, row) {
                console.log(index, row);
                this.popupVisible = true;
            },
            //改变每页容纳的数据量
            handleSizeChange: function (size) {
                this.pagesize = size;
            },
            //切换页码
            handleCurrentChange: function (currentPage) {
                this.currentPage = currentPage;
                console.log(this.currentPage)
                this.getCustomerList()

            },

            /**
             * 格式化时间
             * */
            formatDate(d) {
                var date = new Date(d);
                var YY = date.getFullYear() + '-';
                var MM =
                    (date.getMonth() + 1 < 10
                        ? '0' + (date.getMonth() + 1)
                        : date.getMonth() + 1) + '-';
                var DD = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
                var hh =
                    (date.getHours() < 10 ? '0' + date.getHours() : date.getHours()) + ':';
                var mm =
                    (date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes()) +
                    ':';
                var ss =
                    date.getSeconds() < 10 ? '0' + date.getSeconds() : date.getSeconds();
                return YY + MM + DD + ' ' + hh + mm + ss;
            },

            getCustomerList() {
                // consol
                // this.nowUser = val
                let orgin_time = this.date1;
                let start_date = this.formatDate(orgin_time[0]);
                let end_date = this.formatDate(orgin_time[1]);
                if (this.switch_value === true) {
                    this.is_mark = 1;
                } else {
                    this.is_mark = 0;
                }
                this.loading = true

                fetch(this.api_url+'index.php/api/Risk/list?' + 'page=' + this.currentPage + '&q=' + this.state2+ '&city='+this.city, {
                    method: "get",
                    // body: JSON.stringify({City:val}),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then(result => {
                    // console.log(result);
                    return result.json();
                }).then(res => {
                    // console.log(data);
                    if (res.code == 0) {
                        let result = res.data;
                        console.log(result)
                        this.tableData = result.data;
                        this.tableKey = Math.random()
                        this.currentPage = result.current_page; //默认初始页
                        this.total = result.total; //默认初始页
                        this.pagesize = result.per_page;    //每页默认显示的数据
                        this.pageCount = result.last_page;   //数据的总条数,如果数据是后端接口返回的，则此值需修改
                        setTimeout(() => {
                            this.loading = false
                        }, 1000);
                    } else {
                        this.gridData = []
                        this.$message({
                            message: '暂无数据',
                            type: 'warning'
                        });
                        setTimeout(() => {
                            this.loading = false
                        }, 1000);
                    }
                })
                // this.checkUser = ''
            },
        },
        mounted(){
            // 在页面加载时请求数据
            this.getCustomerList()

        },

    })
</script>
<style>
    .el-autocomplete {
        white-space: nowrap;
    }
    .el-popper[x-placement^=bottom]{
        width:400px !important;
    }

</style>
