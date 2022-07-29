@extends('layouts.admin')

@section('style')
    <style>

    </style>
@endsection
@section('content')
    <div id="container">
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <span>分销用户</span>
            </div>
            <div class="text item">
                <el-card class="box-card" shadow="never" style="margin-bottom:20px;">
                    <el-form  size="mini" :inline="true" :model="formSearch" class="demo-form-inline">
                        <el-form-item label="查询">
                            <el-input v-model="formSearch.keyword" placeholder="请输入要查询的内容"></el-input>
                        </el-form-item>
                        <el-form-item label="状态">
                            <el-select v-model="formSearch.status" placeholder="用户状态选择">
                                <el-option label="全部" value=""></el-option>
                                <el-option label="正常" value="1"></el-option>
                                <el-option label="冻结" value="2"></el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item label="创建时间">
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
                    <el-table-column prop="user_info" label="头像">
                        <template slot-scope="scope">
                            <el-image 
                                :src="scope.row.user_info.headimgurl" 
                                :preview-src-list="[scope.row.user_info.headimgurl]">
                            </el-image>
                        </template>    
                    </el-table-column>
                    <el-table-column prop="nickname" label="昵称" width='100'>
                        <template slot-scope="scope">
                            @{{scope.row.user_info.nickname}}
                        </template>
                    </el-table-column>
                    <el-table-column prop="user_name" label="姓名">
                    </el-table-column>
                    <el-table-column prop="user_code" label="身份证号">
                    </el-table-column>
                    <el-table-column prop="user_phone" label="手机号">
                    </el-table-column>
                    <el-table-column prop="user_wx_id" label="微信号">
                    </el-table-column>
                    <el-table-column prop="user_key" label="key">
                    </el-table-column>
                    <el-table-column prop="user_money" label="可提现(元)">
                    </el-table-column>
                    <el-table-column prop="user_tixian_money" label="已提现(元)">
                    </el-table-column>
                    <el-table-column prop="user_dongjie_money" label="提现冻结(元)">
                    </el-table-column>
                    <el-table-column prop="user_order_count" label="用户单数">
                    </el-table-column>
                    <el-table-column prop="user_status" label="状态">
                        <template slot-scope="scope">
                            <el-tag type="primary" v-if="scope.row.user_status == 1" disable-transitions>正常</el-tag>
                            <el-tag type="danger" v-if="scope.row.user_status == 2" disable-transitions>冻结</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column prop="created_at" label="创建时间">
                    </el-table-column>
                    <el-table-column fixed="right" label="操作" width="100">
                        <template slot-scope="scope">
                            <el-button @click="handleEdit(scope.row)" type="text" size="small">修改</el-button>
                        </template>
                    </el-table-column>
                </el-table>
                <el-pagination background layout="prev, pager, next" :current-page="tableData.current_page"
                    :total="tableData.total" :page-size="tableData.per_page" style="text-align:center;margin:20px; 0"
                    @current-change="currentChange">
                </el-pagination>
            </div>
        </el-card>
        <el-drawer
            :visible.sync="drawer.visible"
            irection="rtl"
            ref="drawer"
            :before-close="handleDrawerClose"
            :with-header="false"
            >
        <div class="drawer-content">
            <div class="demo-drawer__content">
                <el-card class="box-card" shadow="never">
                    <div slot="header" class="clearfix">
                        <span>卡片名称</span>
                        <el-button style="float: right; padding: 3px 0" @click="$refs.drawer.closeDrawer()" type="text">关闭</el-button>
                    </div>
                    <div class=""  style="height: calc(100vh - 130px);overflow-y:auto;">
                        <el-form ref="editFrom" :model="drawer.form" size="mini"  label-position="top">
                            <el-form-item label="用户姓名" prop="user_name" :rules="[{ required: true, message: '请输入用户姓名', trigger: 'blur' }]">
                                <el-input v-model="drawer.form.user_name" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="身份证号" prop="user_code" :rules="[{ required: true, message: '请输入身份证号', trigger: 'blur' }]">
                                <el-input v-model="drawer.form.user_code" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="电话号码" prop="user_phone" :rules="[{ required: true, message: '请输入电话号码', trigger: 'blur' }]">
                                <el-input  type='number' v-model="drawer.form.user_phone" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="key"  prop="user_key" :rules="[{ required: true, message: '请输入key', trigger: 'blur' },{ min: 4, max: 8, message: '长度在 4 到 8 个字符', trigger: 'blur' }]">
                                <el-input  type='text' v-model="drawer.form.user_key" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="微信号">
                                <el-input v-model="drawer.form.user_wx_id" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="可提现金额(元)"  prop="user_money" :rules="[{required: true, message: '请输入可提现金额', trigger: 'blur' }]">
                                <el-input type='number'  v-model="drawer.form.user_money" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="已提现金额(元)"  prop="user_tixian_money" :rules="[{ required: true, message: '请输入已提现金额', trigger: 'blur' }]">
                                <el-input type='number' v-model="drawer.form.user_tixian_money" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="状态"  prop="user_status" :rules="[{ required: true, message: '请输入状态', trigger: 'blur' },{type: 'enum',enum: ['1','2'], message: '请输入正确的状态（1或者2）', trigger: 'blur' }]">
                                <el-input type='number' placeholder='1为正常，2为冻结' v-model="drawer.form.user_status" autocomplete="off"></el-input>
                            </el-form-item>
                        </el-form>
                    </div>
                    <div class="drawer__footer">
                        <el-button @click="$refs.drawer.closeDrawer()">取 消</el-button>
                        <el-button type="primary" @click="handleEditAction" :loading="drawer.loading">@{{ drawer.loading ? '提交中 ...' : '确 定' }}</el-button>
                    </div>
                </el-card>
                
            </div>
        </div>
        </el-drawer>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        new Vue({
            el: "#app",
            data: {
                tableData: {!!$data!!},
                formSearch:{!! $inp !!},
                drawer:{
                    visible:false,
                    loading:false,
                    form:{}
                },
                rules: {
                    user_names: [
                        { required: true, message: '请输入用户姓名', trigger: 'blur' },
                    ],
                },
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
                handleEdit(row){
                    this.drawer.visible = true;
                    this.drawer.row_id  = row.id;
                    this.drawer.form = {
                        user_name:row.user_name,
                        user_code:row.user_code,
                        user_phone:row.user_phone,
                        user_wx_id:row.user_wx_id,
                        user_money:row.user_money,
                        user_tixian_money:row.user_tixian_money,
                        user_status:String(row.user_status),
                        user_key:row.user_key,
                    }
                    
                },
                handleDrawerClose(done){
                    done();
                },
                handleEditAction(){
                    this.$refs.editFrom.validate((valid) => {
                        if (valid) {
                            this.drawer.loading = true;
                            this.$axios.post('/WebUser/edit/'+this.drawer.row_id,this.drawer.form).then((res) => {
                                if(res.code == '0'){
                                    window.location.reload()
                                }
                                this.drawer.loading = false;
                            })
                        } else {
                            console.log('error submit!!');
                            return false;
                        }
                    });
                }
            },
        })

    </script>
@endsection
