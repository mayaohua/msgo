@extends('layouts.admin')

@section('style')
<style>
    
</style>
@endsection
@section('content')

<div id="container">
    <el-form :model="sizeForm" ref="sizeForm" :rules="rules" label-width="80px" size="mini">
  <el-form-item label="规则名称"  prop="ze_name">
    <el-input v-model="sizeForm.ze_name"></el-input>
  </el-form-item>
  <el-form-item label="规则制定"  prop="ze_rule">
    <el-input v-model="sizeForm.ze_rule" placeholder="请输入正则表达式"></el-input>
  </el-form-item>
  <el-form-item label="规则排序">
    <el-input type="number" v-model="sizeForm.ze_order"></el-input>
  </el-form-item>
  <el-form-item label="规则状态">
    <el-switch
    style="display: block"
    v-model="sizeForm.ze_status"
    active-color="#13ce66"
    inactive-color="#ff4949">
    </el-switch>
  </el-form-item>
  <el-form-item size="mini">
    <el-button type="primary" @click="submitForm('sizeForm')">立即修改</el-button>
  </el-form-item>
</el-form>
</div>
@endsection

@section('script')
<script type="text/javascript">
    new Vue({
        el:"#app",
        data:{
           sizeForm: {!! $info !!},
            rules: {
            ze_name: [
              { required: true, message: '规则名称必填', trigger: 'blur' },
              { min: 1, max: 8, message: '长度在 1 到 8 个字符', trigger: 'blur' }
            ],
            ze_rule: [
              { required: true, message: '规则必填', trigger: 'blur' }
            ],
            ze_order: [
              { type: 'ze_order', required: true, message: '排序必须为数字', trigger: 'blur' }
            ],
          }
        },
        methods: {
           submitForm(formName){
               if(this.sizeForm.id){
                  this.$delete(this.sizeForm,'id')
                }
                
                this.$refs[formName].validate((valid) => {
                if (valid) {
                    this.$axios.post('',this.sizeForm)
                } else {
                    return false;
                }
                });
           }
        },
    })
</script>
@endsection