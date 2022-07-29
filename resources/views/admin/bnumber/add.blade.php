@extends('layouts.admin')

@section('style')
<style>
    
</style>
@endsection
@section('content')

<div id="container">
    <el-form :model="sizeForm" ref="sizeForm" :rules="rules" label-width="80px">
  <el-form-item label="号码" placeholder="请输入号码"  prop="phone">
    <el-input v-model="sizeForm.num_mobile "></el-input>
  </el-form-item>
  <el-form-item label="归属地"  prop="num_address">
    <el-input v-model="sizeForm.ze_rule" placeholder="请输入归属地"></el-input>
  </el-form-item>
  <el-form-item label="号码类型" prop="region">
    <el-select v-model="sizeForm.region" placeholder="请选择号码类型">
      <el-option label="区域一" value="shanghai"></el-option>
      <el-option label="区域二" value="beijing"></el-option>
    </el-select>
  </el-form-item>
  <el-form-item label="号码价格">
    <el-input v-model="sizeForm.num_money" placeholder="请输入号码价格"></el-input>
  </el-form-item>
  <el-form-item label="号码状态">
    <el-switch
    style="display: block;margin-top:10px"
    v-model="sizeForm.num_status"
    active-color="#13ce66"
    inactive-color="#ff4949"
    active-value="1"
    inactive-value="0"
    active-text="启用"
    inactive-text="禁用">
    </el-switch>
  </el-form-item>
  <el-form-item >
    <el-button type="primary" @click="submitForm('sizeForm')">立即添加</el-button>
  </el-form-item>
</el-form>
</div>
@endsection

@section('script')
<script type="text/javascript">
    new Vue({
        el:"#app",
        data:{
           sizeForm: {
               ze_name:'',
               ze_rule:'',
               ze_status:'1',
               ze_order:0,
           },
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
               this.$refs[formName].validate((valid) => {
                if (valid) {
                    this.$axios.post('/Rule/add',this.sizeForm).then(function(){
                        window.location.reload()
                    })
                } else {
                    return false;
                }
                });
           }
        },
    })
</script>
@endsection