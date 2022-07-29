<?php $__env->startSection('style'); ?>
<style>
    .error{
       position:fixed;
       left: 0;
       top: 0px; 
       width: 100%;

    }
    .item{
        margin: 5px 0;
    }
    .item span{
        font-size: 18px;
    }
    .box-margin{
        margin-top: 10px;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div id="container">
    <?php if(!$is_mobile): ?>
<el-row>
  <el-col :span="6" >
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span>号码总数</span>
        <el-button style="float: right; padding: 3px 0" type="text">
            <el-link href="/PhoneCardOrder/list" type="primary">前往</el-link>
        </el-button>
      </div>
      <div class="text item">
       下单成功数：<span><?php echo e($success_order_count); ?>单</span>
      </div>
      <div class="text item">
       下单失败数：<span><?php echo e($all_order_count-$success_order_count); ?>单</span>
      </div>
    </el-card>
  </el-col>
  <el-col :span="6" :offset="1">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span>充值订单</span>
        <el-button style="float: right; padding: 3px 0" type="text">
            <el-link href="/PhoneBillOrder/list" type="primary">前往</el-link>
        </el-button>
      </div>
      <div class="text item">
        <span><?php echo e($bill_count); ?>个</span>
      </div>
    </el-card>
  </el-col>
    <el-col :span="6" :offset="1">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span>充值商品总数</span>
        <el-button style="float: right; padding: 3px 0" type="text">
            <el-link href="/BillCase/list" type="primary">前往</el-link>
        </el-button>
      </div>
      <div class="text item">
        <span><?php echo e($bill_case_num); ?>个</span>
      </div>
    </el-card>
  </el-col>
</el-row>
    <?php else: ?>
    <el-card class="box-card box-margin">
      <div slot="header" class="clearfix">
        <span>号码总数</span>
        <el-button style="float: right; padding: 3px 0" type="text">
            <el-link href="/PhoneCardOrder/list" type="primary">前往</el-link>
        </el-button>
      </div>
      <div class="text item">
       下单成功数：<span><?php echo e($success_order_count); ?>单</span>
      </div>
      <div class="text item">
       下单失败数：<span><?php echo e($all_order_count-$success_order_count); ?>单</span>
      </div>
    </el-card>
    <el-card class="box-card box-margin">
      <div slot="header" class="clearfix">
        <span>充值订单</span>
        <el-button style="float: right; padding: 3px 0" type="text">
            <el-link href="/PhoneBillOrder/list" type="primary">前往</el-link>
        </el-button>
      </div>
      <div class="text item">
        <span><?php echo e($bill_count); ?>个</span>
      </div>
    </el-card>
    <el-card class="box-card box-margin">
      <div slot="header" class="clearfix">
        <span>充值商品总数</span>
        <el-button style="float: right; padding: 3px 0" type="text">
            <el-link href="/BillCase/list" type="primary">前往</el-link>
        </el-button>
      </div>
      <div class="text item">
        <span><?php echo e($bill_case_num); ?>个</span>
      </div>
    </el-card>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script type="text/javascript">
    new Vue({
        el:"#app",
        data:{
            
        },
        methods: {
           
        },
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>