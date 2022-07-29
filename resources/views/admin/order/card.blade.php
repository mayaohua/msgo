@extends('layouts.admin')

@section('style')
    <style>

    </style>
@endsection
@section('content')
    <div id="container">
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <span>订单列表</span>
                <el-button @click="handleReSet" style="float: right; padding: 3px 0" type="text">清空订单</el-button>
            </div>
            <div class="text item">
            <el-card class="box-card" shadow="never" style="margin-bottom:20px;">
                    <el-form  size="mini" :inline="true" :model="formSearch" class="demo-form-inline">
                        <el-form-item label="关键词">
                            <el-input v-model="formSearch.keyword" placeholder="请输入要查询的关键词"></el-input>
                        </el-form-item>
                        
                        <!--<el-form-item label="归属地">
                        <el-cascader
                        v-model="formSearch.loca"
                        :options="locaArr"
                        :show-all-levels="false"
                        filterable
                        placeholder="试试搜索：北京"
                        :props="{ expandTrigger: 'hover' }"
                        >
                        </el-cascader>
                        </el-form-item>-->
                        <el-form-item label="号码类型">
                        <el-cascader
                        v-model="formSearch.card"
                        :options="cardArr"
                        :props="{ expandTrigger: 'hover' }"
                        >
                        </el-cascader>
                        </el-form-item>
                        <el-form-item label="状态">
                            <el-select v-model="formSearch.status" placeholder="状态选择">
                            <el-option label="全部" value=""></el-option>
                            <el-option label="成功" value="1"></el-option>
                            <el-option label="失败" value="0"></el-option>
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

                <el-table :data="tableData.data" border style="width: 100%">
                    <el-table-column type="selection" width="55">
                    </el-table-column>
                    <el-table-column prop="mobile" label="号码">
                        <template slot-scope="scope">
                            @{{scope.row.mobile}}
                            <template v-if='scope.row.user_data.user_key'><br/><span style="color:#409eff;">分销订单</span></template>
                        </template>
                    </el-table-column>
                    <el-table-column prop="mobile_location" label="归属地">
                    </el-table-column>
                    <el-table-column prop="card_name" label="号码类型">
                    </el-table-column>
                    <el-table-column prop="user_name" label="下单人">
                    </el-table-column>
                    <el-table-column prop="user_phone" label="手机号码">
                    </el-table-column>
                    <el-table-column prop="user_code" label="身份证号码">
                    </el-table-column>
                    <el-table-column prop="user_address" label="家庭住址">
                    </el-table-column>
                    <el-table-column prop="apply_from" label="下单途径">
                        <template slot-scope="scope">
                            <span v-if="scope.row.apply_from == 'official'">公众号</span>
                            <span v-if="scope.row.apply_from == 'web'">网页</span>
                            <span v-if="scope.row.apply_from == 'wxapp'">小程序</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="order_to" label="订单对接">
                        <template slot-scope="scope">
                            <span v-if="scope.row.order_to == 'lt'">中国联通</span>
                            <span v-if="scope.row.order_to == 'dg'">东莞联通</span>
                            <span v-if="scope.row.order_to == 'dsf'">号卡助手</span>
                            
                        </template>
                    </el-table-column>
                    <el-table-column prop="card_status" label="下单状态">
                        <template slot-scope="scope">
                            <el-tag type="success" v-if="scope.row.card_status == 0" disable-transitions>下单成功</el-tag>
                            <el-tag type="danger" v-if="scope.row.card_status == 1" disable-transitions>下单失败</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column prop="card_msg" label="失败原因">
                    </el-table-column>
                    <el-table-column prop="created_at" label="下单时间">
                    </el-table-column>
                    
                </el-table>
                <el-pagination background layout="prev, pager, next" :current-page="tableData.current_page"
                    :total="tableData.total" :page-size="tableData.per_page" style="text-align:center;margin:20px; 0"
                    @current-change="currentChange">
                </el-pagination>
            </div>
        </el-card>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        new Vue({
            el: "#app",
            data: {
                tableData: {!!$data!!},
                formSearch:{!! $inp !!},
                locaArr:{!! $locaArr !!},
                cardArr:{!! $cardArr !!},
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
                    obj.loca = obj.loca.join(',')
                    obj.card = obj.card.join(',')
                    obj.time = obj.time.join(',')
                    obj.page = num ? num : 1
                    window.location.href = "?"+window.parseParam(obj);
                },
                currentChange(num) {
                    this.gotoUrl(num);
                },
                handleReSet() {
                    this.$confirm('此操作将删除所有订单, 是否继续?', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning'
                    }).then(() => {
                        this.$axios.post('/PhoneCardOrder/reset',).then((res) => {
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
