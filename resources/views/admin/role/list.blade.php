@extends('layouts.admin')

@section('style')
    <style>

    </style>
@endsection
@section('content')

    <div id="container">
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <span>号码列表</span>
                <el-button @click="handleReSet" style="float: right; padding: 3px 0" type="text">重置规则</el-button>
            </div>
            <div class="text item">
                <el-table :data="tableData" height="auto" border style="width: 100%">
                    <el-table-column type="selection" width="55">
                    </el-table-column>
                    <el-table-column prop="id" label="ID" >
                    </el-table-column>
                    <el-table-column prop="ze_name" label="规则名称">
                    </el-table-column>
                    <el-table-column prop="ze_status" label="状态" >
                        <template slot-scope="scope">
                            <el-tag :type="scope.row.ze_status == 1 ? 'success' : 'warning'" disable-transitions>
                                @{{ scope . row . ze_status == 1 ? '启用' : '禁用' }}</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column prop="ze_order" label="排序">
                        <template slot-scope="scope">
                            <!-- <el-popover trigger="hover" placement="top"> -->
                            <!-- <div style="display: flex;">
                    <el-input  type="text" :value="scope.row.ze_order" style="margin-right: 10px;" size="mini" placeholder="数值越大，越排前面"></el-input>
                    <el-button type="primary" icon="el-icon-edit" size="mini">排序</el-button>
                  </div> -->
                            <!-- <div slot="reference" class="name-wrapper"> -->
                            <el-tag size="medium">@{{ scope . row . ze_order }}</el-tag>
                            <!-- </div> -->
                            <!-- </el-popover> -->
                        </template>
                    </el-table-column>
                    <el-table-column prop="ze_rule" label="规则" show-overflow-tooltip>
                    </el-table-column>
                    <el-table-column fixed="right" label="操作" width="100">
                        <template slot-scope="scope">
                            <el-button @click="handleEdit(scope.row)" type="text" size="small">编辑
                            </el-button>
                            <template>
                                <el-popconfirm @confirm="handleRemove(scope.row)" title="确定删除吗？">
                                    <el-button type="text" style="color:#F56C6C" size="small" slot="reference">删除
                                    </el-button>
                                </el-popconfirm>
                            </template>
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
                tableData: {!!$rule_list!!}
            },

            methods: {
                handleME(row, column, cell, event) {},
                handleML(row, column, cell, event) {},
                handleEdit(row) {
                    window.location.href = "/Rule/edit/" + row.id
                },
                handleRemove(row) {
                    var that = this;
                    this.$axios.post('/Rule/del/' + row.id, this.sizeForm).then((res) => {
                        if (res.code === 0) {
                            this.tableData = this.tableData.filter(t => t.ze_order != row.ze_order)
                        }
                    })

                },
                changeOrder($e) {

                },
                handleReSet() {
                    this.$confirm('此操作将重置规则，重置规则后精品规则也将被重置, 是否继续?', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning'
                    }).then(() => {
                      this.$axios.post('/Rule/reset',).then((res) => {
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
