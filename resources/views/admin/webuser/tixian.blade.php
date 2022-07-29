@extends('layouts.admin')

@section('style')
    <style>

    </style>
@endsection
@section('content')
    <div id="container">
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <span>提现记录</span>
                {{-- <el-button @click="handleReSet" style="float: right; padding: 3px 0" type="text">清空订单</el-button> --}}
            </div>
            <div class="text item">
                <el-card class="box-card" shadow="never" style="margin-bottom:20px;">
                    <el-form  size="mini" :inline="true" :model="formSearch" class="demo-form-inline">
                        <el-form-item label="查询">
                            <el-input v-model="formSearch.keyword" placeholder="请输入要查询的内容"></el-input>
                        </el-form-item>
                        <el-form-item label="状态">
                            <el-select v-model="formSearch.status" placeholder="状态选择">
                                <el-option label="全部" value=""></el-option>
                                <el-option label="审核中" value="1"></el-option>
                                <el-option label="申请通过" value="2"></el-option>
                                <el-option label="支付拒绝" value="3"></el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item label="申请时间">
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
                <el-table :data="tableData.data" border style="width: 100%">
                    <el-table-column type="selection" width="55">
                    </el-table-column>
                    <el-table-column prop="tixian_money" label="提现金额（元）">
                    </el-table-column>
                    <el-table-column prop="user_id" label="申请人">
                        <template slot-scope="scope">
                            @{{scope.row.user.user_name}}(@{{scope.row.user.user_key}})
                        </template>
                    </el-table-column>
                    <el-table-column prop="tixian_info" label="提现备注">
                    </el-table-column>
                    <el-table-column prop="tixian_img" label="收款码">
                        <template slot-scope="scope">
                            <el-image 
                                style="width: 100px; height: 100px"
                                :src="scope.row.tixian_img" 
                                :preview-src-list="[scope.row.tixian_img]">
                            </el-image>
                        </template>    
                    </el-table-column>
                    <el-table-column prop="created_at" label="申请时间">
                    </el-table-column>
                    <el-table-column prop="tixian_status" label="提现状态">
                        <template slot-scope="scope">
                            <el-tag type="primary" v-if="scope.row.tixian_status == 1" disable-transitions>审核中</el-tag>
                            <el-tag type="success" v-if="scope.row.tixian_status == 2" disable-transitions>申请通过</el-tag>
                            <el-tag type="danger" v-if="scope.row.tixian_status == 3" disable-transitions>申请拒绝</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column prop="fail_msg" label="拒绝原因">
                    </el-table-column>
                    <el-table-column fixed="right" label="操作" width="100">
                        <template slot-scope="scope">
                            <el-button @click="handleEdit(scope.row)" type="text" size="small">修改</el-button>
                            {{-- <el-button @click="handleDel(scope.row)" type="text" style="color:red" size="small">删除</el-button> --}}
                        </template>
                    </el-table-column>
                </el-table>
                <el-pagination background layout="prev, pager, next" :current-page="tableData.current_page"
                    :total="tableData.total" :page-size="tableData.per_page" style="text-align:center;margin:20px; 0"
                    @current-change="currentChange">
                </el-pagination>
            </div>
        </el-card>
        <el-dialog title="订单更新" :visible.sync="dialog.formVisible">
        <el-form :model="dialog.data" :inline="true" size="mini">
            <el-form-item label="订单状态">
                <el-select v-model="dialog.data.tixian_status" placeholder="请选择订单状态">
                    <el-option label="审核中" value="1"></el-option>
                    <el-option label="申请通过" value="2"></el-option>
                    <el-option label="申请拒绝" value="3"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="失效原因" v-if="dialog.data.tixian_status == 3">
                <el-input v-model="dialog.data.fail_msg" type="textarea" autocomplete="off"></el-input>
            </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
            <el-button @click="dialog.formVisible = false">取 消</el-button>
            <el-button type="primary" @click="handleUpdate">确 定</el-button>
        </div>
        </el-dialog>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        new Vue({
            el: "#app",
            data: {
                tableData: {!!$data!!},
                formSearch:{!!$inp!!},
                dialog:{
                    formVisible:false,
                    data:{
                        tixian_status:'',
                        fail_msg:'',
                    },
                },
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
                    this.$confirm('此操作将删除订单, 是否继续?', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning'
                    }).then(() => {
                        this.$axios.post('/UserSellOrder/del/'+row.id,).then((res) => {
                          window.location.reload()
                      })
                    }).catch(() => {
                        this.$message({
                            type: 'info',
                            message: '已取消删除'
                        });
                    });
                    
                },
                handleEdit(row){
                    if(row.tixian_status != 1){
                        this.$message({
                            type: 'info',
                            message: '状态已改变，不可修改'
                        });
                        return;
                    }
                    this.dialog.formVisible = true;
                    this.dialog.data.tixian_status = String(row.tixian_status);
                    this.dialog.data.fail_msg =  row.fail_msg;
                    this.dialog.data.row_id =  row.id;
                    
                },
                handleUpdate(){
                    if(this.dialog.data.tixian_status != 3){
                        this.dialog.data.fail_msg = '';
                    }
                    if(this.dialog.data.tixian_status == 1){
                        this.$message({
                            type: 'info',
                            message: '无需修改'
                        });
                        return;
                    }
                    this.$axios.post('/UserTiXian/edit/'+this.dialog.data.row_id,this.dialog.data).then((res) => {
                          if(res.code == '0'){
                              window.location.reload()
                          }
                    })
                    //

                },
                handleReSet() {
                    this.$confirm('此操作将删除所有订单, 是否继续?', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning'
                    }).then(() => {
                        this.$axios.post('/UserTiXian/reset',).then((res) => {
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
@endsection
