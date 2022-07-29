@extends('layouts.admin')

@section('style')
    <style>

    </style>
@endsection
@section('content')

    <div id="container">
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <span>反馈列表</span>
                {{-- <el-button @click="handleReSet" style="float: right; padding: 3px 0" type="text">重置规则</el-button> --}}
            </div>
            <div class="text item">
                <el-table :data="tableData" height="auto" border style="width: 100%">
                    <el-table-column type="selection" width="55">
                    </el-table-column>
                    <el-table-column prop="kui_content" label="反馈内容">
                    </el-table-column>
                    <el-table-column prop="kui_contact" label="联系方式">
                    </el-table-column>
                    <el-table-column prop="kui_file" label="上传图片">
                         <template slot-scope="scope" v-if="scope.row.kui_file">
                            <el-popover trigger="hover" placement="top">
                              <p style="text-align: center"><a :href="scope.row.kui_file"><img style="width: 100px;height:100px;" :src="scope.row.kui_file" alt=""></a></p>
                              <div slot="reference" class="name-wrapper">
                                <el-tag size="medium" style="cursor: pointer">查看</el-tag>
                              </div>
                            </el-popover>
                          </template>
                    </el-table-column>
                    <el-table-column prop="created_at" label="反馈时间">
                    </el-table-column>
                    <el-table-column fixed="right" label="操作" width="100">
                        <template slot-scope="scope">
                            {{-- <el-button @click="handleEdit(scope.row)" type="text" size="small">编辑
                            </el-button> --}}
                            {{-- <template>
                                <el-popconfirm @confirm="handleRemove(scope.row)" title="确定删除吗？">
                                    <el-button type="text" style="color:#F56C6C" size="small" slot="reference">删除
                                    </el-button>
                                </el-popconfirm>
                            </template> --}}
                        </template>
                    </el-table-column>
                </el-table>
            </div>
        </el-card>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        var app = new Vue({
            el: "#app",
            data: {
                tableData: {!!$sug_list!!}
            },

            methods: {
                handleME(row, column, cell, event) {},
                handleML(row, column, cell, event) {},
                

            },
        })

    </script>
@endsection
