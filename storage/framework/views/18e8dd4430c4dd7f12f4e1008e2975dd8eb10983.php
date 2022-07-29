

<?php $__env->startSection('style'); ?>
    <style>

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div id="container">
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <span>充值订单</span>
                <el-button @click="handleReSet" style="float: right; padding: 3px 0" type="text">清空订单</el-button>
            </div>
            <div class="text item">
                <el-card class="box-card" shadow="never" style="margin-bottom:20px;">
                    <el-form  size="mini" :inline="true" :model="formSearch" class="demo-form-inline">
                        <el-form-item label="查询">
                            <el-input v-model="formSearch.keyword" placeholder="请输入要查询的内容"></el-input>
                        </el-form-item>
                        <el-form-item label="状态">
                            <el-select v-model="formSearch.bill_status" placeholder="充值状态选择">
                                <el-option label="全部" value=""></el-option>
                                <el-option label="待支付" value="0"></el-option>
                                <el-option label="支付成功" value="1"></el-option>
                                <el-option label="支付失败" value="2"></el-option>
                                <el-option label="充值中" value="5"></el-option>
                                <el-option label="充值成功" value="3"></el-option>
                                <el-option label="充值失败" value="4"></el-option>
                                <el-option label="退款中" value="6"></el-option>
                                <el-option label="退款完成" value="7"></el-option>
                                <el-option label="退款失败" value="8"></el-option>
                                <el-option label="异常订单" value="9"></el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item label="下单时间">
                            <el-date-picker
                            v-model="formSearch.time"
                            type="daterange"
                            align="right"
                            unlink-panels
                            range-separator="至"
                            start-placeholder="开始日期"
                            end-placeholder="结束日期"
                            format="yyyy 年 MM 月 dd 日"
                            value-format="yyyy-MM-dd"
                            :picker-options="pickerOptions">
                            </el-date-picker>
                        </el-form-item>
                        
                        <el-form-item>
                            <el-button type="primary" @click="onSearch">查询</el-button>
                        </el-form-item>
                    </el-form>
                </el-card>
                <el-table :data="tableData.data" style="width: 100%">
                    <el-table-column type="expand">
                        <template slot-scope="props">
                            <template v-for="item in props.row.status_items">
                                <el-form  label-position="left" inline class="demo-table-expand">
                                    <el-form-item style="margin-bottom:0" label="状态名称：">
                                        <span style="color:#333;font-weight:bold;">{{ item.status_name }}</span>
                                    </el-form-item>
                                    <el-form-item  style="margin-bottom:0" label="生成时间：">
                                        <span style="color:#333;font-weight:bold;">{{ item.created_at }}</span>
                                    </el-form-item>
                                    <el-form-item  style="margin-bottom:0" label="状态说明：">
                                        <span style="color:#333;font-weight:bold;">{{ item.status_desc }}</span>
                                    </el-form-item>
                                    
                                </el-form>
                            </template>
                        </template>
                    </el-table-column>
                    <el-table-column prop="bill_mobile" label="充值号码">
                        <template slot-scope="scope">
                            {{scope.row.bill_mobile}}
                            <template v-if='scope.row.bill_data.user_key'><br/><span style="color:#409eff;">分销订单</span></template>
                        </template>
                    </el-table-column>
                    <el-table-column prop="bill_type_name" label="充值商品">
                    </el-table-column>
                    <el-table-column prop="bill_type_text" label="商品信息">
                    </el-table-column>
                    <el-table-column prop="bill_money" label="充值金额">
                        <template slot-scope="scope">
                            {{scope.row.bill_money}}元</template>
                    </el-table-column>
                    <el-table-column prop="bill_user_openid" label="下单人">
                    </el-table-column>
                    <el-table-column prop="apply_from" label="下单途径">
                    <template slot-scope="scope">{{scope.row.apply_from == 'official'?'公众号':'小程序'}}</template>
                    </el-table-column>
                    <el-table-column prop="bill_app_order_id" label="我方订单号">
                    </el-table-column>
                    <el-table-column prop="bill_wx_order_id" label="微信订单号">
                    </el-table-column>
                    <el-table-column prop="bill_biz_order_id" label="平台订单号">
                    </el-table-column>
                    <el-table-column prop="bill_msg" label="失败原因">
                    </el-table-column>
                    <el-table-column prop="bill_status" label="下单状态">
                        <template slot-scope="scope">
                            <el-tag type="primary" v-if="scope.row.bill_status == 0" disable-transitions>等待付款</el-tag>
                            <el-tag type="success" v-if="scope.row.bill_status == 1" disable-transitions>支付成功</el-tag>
                            <el-tag type="danger" v-if="scope.row.bill_status == 2" disable-transitions>支付失败</el-tag>
                            <el-tag type="success" v-if="scope.row.bill_status == 3" disable-transitions>充值成功</el-tag>
                            <el-tag type="danger" v-if="scope.row.bill_status == 4" disable-transitions>充值失败</el-tag>
                            <el-tag type="primary" v-if="scope.row.bill_status == 5" disable-transitions>话费充值中</el-tag>
                            <el-tag type="primary" v-if="scope.row.bill_status == 6" disable-transitions>退款中</el-tag>
                            <el-tag type="success" v-if="scope.row.bill_status == 7" disable-transitions>退款成功</el-tag>
                            <el-tag type="danger" v-if="scope.row.bill_status == 8" disable-transitions>退款失败</el-tag>
                            <el-tag type="danger" v-if="scope.row.bill_status == 9" disable-transitions>异常订单</el-tag>
                        </template>
                    </el-table-column>
                    
                    <el-table-column prop="created_at" label="下单时间">
                    </el-table-column>
                    <el-table-column prop="finished_at" label="完成时间">
                    </el-table-column>
                    <el-table-column fixed="right" label="操作" width="100">
                        <template slot-scope="scope">
                            
                            <el-button @click="handleDel(scope.row)" type="text" size="small">删除</el-button>
                        </template>
                    </el-table-column>
                </el-table>
                <el-pagination background layout="prev, pager, next" :current-page="tableData.current_page"
                    :total="tableData.total" :page-size="tableData.per_page" style="text-align:center;margin:20px; 0"
                    @current-change="currentChange">
                </el-pagination>
            </div>
        </el-card>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        new Vue({
            el: "#app",
            data: {
                tableData: <?php echo $data; ?>,
                formSearch:<?php echo $inp; ?>,
                statusArr:[
                    {name: "待支付",id: '0'},
                    {'name':'支付成功','id':1},
                    {'name':'支付失败','id':2},
                    {'name':'充值中','id':5},
                    {'name':'充值成功','id':3},
                    {'name':'充值失败','id':4},
                    {'name':'退款中','id':6},
                    {'name':'退款完成','id':7},
                    {'name':'退款失败','id':8},
                ],
                pickerOptions: {
                    disabledDate(time) {
                        return time.getTime() > Date.now();
                    },
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
            },
            methods: {
                onSearch() {
                    this.gotoUrl();
                },
                gotoUrl(num){
                    var obj = Object.assign({},this.formSearch);
                    console.log(window.parseParam(obj))
                    obj.time = obj.time.join(',')
                    obj.page = num ? num : 1
                    window.location.href = "?"+window.parseParam(obj);
                },
                currentChange(num) {
                    this.gotoUrl(num);
                },
                handleDel(row){
                    this.$axios.post('/PhoneBillOrder/del/'+row.id,).then((res) => {
                          window.location.reload()
                      })
                },
                handleReSet() {
                    this.$confirm('此操作将删除所有订单, 是否继续?', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning'
                    }).then(() => {
                        this.$axios.post('/Order/reset',).then((res) => {
                          window.location.reload()
                      })
                    }).catch(() => {
                        this.$message({
                            type: 'info',
                            message: '已取消删除'
                        });
                    });
                }
            },
        })

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>