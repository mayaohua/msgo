@extends('layouts.admin')

@section('style')
    <style>

    </style>
@endsection
@section('content')
    <div id="container">
        
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <span>精品号码</span>
                <i v-if="job_num"  style="font-size:12px;">剩余任务数@{{job_num}}</i>
                <el-button @click="handleResetjobs" v-if="job_num" style="float: right; padding: 3px 0" type="text">停止任务</el-button>
                <el-button @click="handleReSet" style="float: right; padding: 3px 0;margin-right:10px;" type="text">清空号码</el-button>
                <el-button @click="handleGetNumber" style="float: right; padding: 3px 0;margin-right:10px;" type="text">抓取号码</el-button>
            </div>
            <div class="text item">
                <el-card class="box-card" shadow="never" style="margin-bottom:20px;">
                    <el-form  size="mini" :inline="true" :model="formSearch" class="demo-form-inline">
                        <el-form-item label="号码">
                            <el-input v-model="formSearch.mobile" placeholder="请输入要查询的号码"></el-input>
                        </el-form-item>
                        <el-form-item label="号码来源">
                            <el-select v-model="formSearch.mobile_from" placeholder="号码来源选择">
                            <el-option label="不限" value=""></el-option>
                            <el-option label="官方" value="10010"></el-option>
                            <el-option label="hhdaili" value="hhdaili"></el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item label="符合规则">
                            <el-select v-model="formSearch.rule" placeholder="符合规则选择">
                            <el-option label="全部" value=""></el-option>
                            <el-option v-for="item in ruleArr" :label="item.ze_name" :value="item.id"></el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item label="归属地">
                        <el-cascader
                        v-model="formSearch.loca"
                        :options="locaArr"
                        :show-all-levels="false"
                        filterable
                        placeholder="试试搜索：北京"
                        :props="{ expandTrigger: 'hover' }"
                        >
                        </el-cascader>
                        </el-form-item>
                        <el-form-item label="号码类型">
                        <el-cascader
                        v-model="formSearch.card"
                        :options="cardArr"
                        :props="{ expandTrigger: 'hover' }"
                        >
                        </el-cascader>
                        </el-form-item>
                        <el-form-item label="是否出售">
                            <el-select v-model="formSearch.sell" placeholder="符合是否选择">
                            <el-option label="全部" value=""></el-option>
                            <el-option label="已出售" value="1"></el-option>
                            <el-option label="未出售" value="0"></el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item label="状态">
                            <el-select v-model="formSearch.status" placeholder="状态选择">
                            <el-option label="全部" value=""></el-option>
                            <el-option label="启用" value="1"></el-option>
                            <el-option label="禁用" value="0"></el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" @click="onSearch">查询</el-button>
                        </el-form-item>
                    </el-form>
                </el-card>
                <el-table :data="tableData.data" border style="width: 100%">
                    <el-table-column type="selection" width="55">
                    </el-table-column>
                    {{-- <el-table-column prop="id" label="ID">
                    </el-table-column> --}}
                    <el-table-column prop="mobile" label="号码">
                    </el-table-column>
                    <el-table-column prop="loca_name" label="归属地">
                    </el-table-column>
                    <el-table-column prop="card_name" label="号码类型">
                    </el-table-column>
                    <el-table-column prop="rule_name" label="符合规则">
                    </el-table-column>
                    <el-table-column prop="sell" label="是否出售">
                        <template slot-scope="scope">
                            <el-tag :type="scope.row.sell == 0 ? 'success' : 'warning'" disable-transitions>
                                @{{ scope . row . sell == 0 ? '未出售' : '已出售' }}</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column prop="status" label="状态">
                        <template slot-scope="scope">
                            <el-tag :type="scope.row.status == 1 ? 'success' : 'warning'" disable-transitions>
                                @{{ scope.row.status == 1 ? '启用' : '禁用' }}</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column prop="mobile_from" label="号码来源">
                        <template slot-scope="scope">
                            @{{scope.row.mobile_from}}
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
@endsection

@section('script')
    <script type="text/javascript">
        new Vue({
            el: "#app",
            data: {
                job_num: {{$job_num}},
                tableData: {!!$data!!},
                formSearch:{!! $inp !!},
                ruleArr:{!! $ruleArr !!},
                locaArr:{!! $locaArr !!},
                cardArr:{!! $cardArr !!},
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
                    obj.page = num ? num : 1
                    window.location.href = "?"+window.parseParam(obj);
                },
                currentChange(num) {
                    this.gotoUrl(num);
                },
                handleReSet() {
                    this.$confirm('此操作将删除所有号码, 是否继续?', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning'
                    }).then(() => {
                        this.$axios.post('/BNumber/reset', ).then((res) => {
                            window.location.reload()
                        })
                    })
                },
                handleGetNumber(){
                    this.$confirm('此操作将删除所有号码, 是否继续?', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning'
                    }).then(() => {
                        this.$axios.post('/BNumber/jobwork', )
                    })
                  
                },
                handleResetjobs() {
                    this.$confirm('此操作将删除所有号码, 是否继续?', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning'
                    }).then(() => {
                        this.$axios.post('/BNumber/resetjobs', ).then((res) => {
                            window.location.reload()
                        })
                    })
                },
            },
        })

    </script>
@endsection
