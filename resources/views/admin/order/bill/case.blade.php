@extends('layouts.admin')

@section('style')
    <style>

    </style>
@endsection
@section('content')
    <div id="container">
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <span>充值商品</span>
                <el-button @click="handleReSet" style="float: right; padding: 3px 0" type="text">重置商品</el-button>
                <el-button @click="handleAdd" style="float: right; padding: 3px 0;margin-right:10px;" type="text">添加商品</el-button>
            </div>
            <div class="text item">
                <el-table :data="tableData" border style="width: 100%">
                    <el-table-column type="selection" width="55">
                    </el-table-column>
                    <el-table-column prop="id" label="商品编号">
                    </el-table-column>
                    <el-table-column prop="itemName" label="商品名称">
                    </el-table-column>
                    <el-table-column prop="itemFacePrice" label="面值">
                        <template slot-scope="scope">
                            @{{scope.row.itemFacePrice/1000}}元
                        </template>
                    </el-table-column>
                    <el-table-column prop="itemSalesPrice" label="售价">
                        <template slot-scope="scope">
                            @{{scope.row.itemSalesPrice/1000}}元
                        </template>
                    </el-table-column>
                    <el-table-column 
                    prop="bizId" 
                    label="运营商"
                    :filters="[{ text: '联通', value: 200 }, { text: '电信', value: 202 }, { text: '移动', value: 201 }]"
                    :filter-method="filterYysTag"
                    filter-placement="bottom-end"
                    >
                        <template slot-scope="scope">
                            @{{scope.row.bizId == 200 ? '联通' : scope.row.bizId == 202 ? '电信' : '移动'}}
                        </template>
                    </el-table-column>
                    <el-table-column prop="info" label="到账时间">
                    </el-table-column>
                    <el-table-column 
                    prop="status" 
                    label="状态"
                    :filters="[{ text: '上架', value: 2 }, { text: '下架', value: 3 }]"
                    :filter-method="filterstatusTag"
                    filter-placement="bottom-end">
                        <template slot-scope="scope">
                            <el-tag type="success" v-if="scope.row.status == 2" disable-transitions>上架</el-tag>
                            <el-tag type="wraing" v-else disable-transitions>下架</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column prop="areaCodeDesc" label="地区"
                    :filters="areaData"
                    :filter-method="filterareaTag"
                    filter-placement="bottom-end">
                    </el-table-column>
                    <el-table-column prop="areaCode" label="地区编码">
                    </el-table-column>
                    <el-table-column fixed="right" label="操作" width="100">
                        <template slot-scope="scope">
                            <el-button @click="dialogVisible = true;fromData.data = scope.row;fromData.edit = true;" type="text" size="small">修改</el-button>
                            <el-button @click="handleDel(scope.row)" type="text" size="small">删除</el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
        </el-card>
        <el-dialog
        title="修改信息"
        :visible.sync="dialogVisible"
        width="30%"
        v-if="fromData.data"
        >
        <div class="content">
            <el-form ref="form" :model="fromData.data" label-width="80px">
                <el-form-item label="商品编号" v-if="!fromData.edit">
                    <el-input type="number" v-model="fromData.data.id"></el-input>
                </el-form-item>
                <el-form-item label="商品名称">
                    <el-input v-model="fromData.data.itemName"></el-input>
                </el-form-item>
                <el-form-item label="商品面值">
                    <el-input type="number" placeholder="单位填厘 1000厘=1元" v-model="fromData.data.itemFacePrice"></el-input>
                </el-form-item>
                <el-form-item type="number" label="商品售价">
                    <el-input v-model="fromData.data.itemSalesPrice" placeholder="单位填厘 1000厘=1元"></el-input>
                </el-form-item>
                <el-form-item label="运营商">
                    <el-input v-model="fromData.data.bizId" placeholder="联通200 移动201 电信202"></el-input>
                </el-form-item>
                <el-form-item label="到账时间">
                    <el-input v-model="fromData.data.info" placeholder="请填写"></el-input>
                </el-form-item>
                <el-form-item label="状态">
                    <el-input v-model="fromData.data.status" placeholder="上架2 下架3"></el-input>
                </el-form-item>
                <el-form-item label="地区编码">
                    <el-input v-model="fromData.data.areaCode" placeholder="地区编码"></el-input>
                </el-form-item>
                <el-form-item label="地区名称">
                    <el-input v-model="fromData.data.areaCodeDesc" placeholder="地区名称"></el-input>
                </el-form-item>
            </el-form>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button @click="dialogVisible = false">取 消</el-button>
            <el-button type="primary" @click="handleEdit">确 定</el-button>
        </span>
        </el-dialog>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        new Vue({
            el: "#app",
            data: {
                tableData: {!! $data !!},
                areaData:[],
                dialogVisible:false,
                fromData:{
                    edit:true,
                    data:{
                        id:''
                    }
                },
            },
            created(){
                this.getAreaList()
            },
            methods: {
                getAreaList(){
                    for (let index = 0; index < this.tableData.length; index++) {
                        let element = this.tableData[index];
                        var res = {
                            text:element.areaCodeDesc,
                            value:element.areaCode
                        }
                        let has = false;
                        for (let i = 0; i < this.areaData.length; i++) {
                            let e = this.areaData[i];
                            if(e.value == element.areaCode){
                                has = true;break;
                            }
                        }
                        if(!has){
                            this.areaData.push(res)
                        }
                    }
                },
                
                filterstatusTag(value, row){
                    return row.status === value;
                },
                filterYysTag(value, row){
                    return row.bizId === value;
                },
                filterareaTag(value, row){
                    return row.areaCode === value;
                },
                handleAdd(){
                    this.fromData.edit = false;
                    this.fromData.data = {
                        id:'',
                        itemName : "",
                        itemFacePrice:0,
                        itemSalesPrice:0,
                        bizId:'',
                        status:'',
                        areaCode:"",
                        areaCodeDesc:"",
                        useableType:'',
                        carrierType:'',
                        flow:'',
                        packType:'',
                        info:''
                    };
                    this.dialogVisible = true;
                },
                handleEdit(){
                    if(this.fromData.edit){
                        this.$axios.post('/BillCase/edit/'+this.fromData.data.id,this.fromData.data).then((res) => {
                            if(res.code == 0){
                                this.dialogVisible = false;
                            }
                        })
                    }else{
                        this.$axios.post('/BillCase/add',this.fromData.data).then((res) => {
                          if(res.code == 0){
                            this.dialogVisible = false;
                          }
                    })
                    }
                    
                    
                },
                handleDel(row){
                    this.$confirm('此操作将删除商品, 是否继续?', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning'
                    }).then(() => {
                        this.$axios.post('/BillCase/del/'+row.id).then((res) => {
                          window.location.reload()
                      })
                    }).catch(() => {
                        this.$message({
                            type: 'info',
                            message: '已取消删除'
                        });
                    });
                },
                handleReSet() {
                    this.$confirm('此操作将重置所有商品, 是否继续?', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning'
                    }).then(() => {
                        this.$axios.post('/BillCase/reset').then((res) => {
                          this.tableData = res.data
                          this.getAreaList()
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
