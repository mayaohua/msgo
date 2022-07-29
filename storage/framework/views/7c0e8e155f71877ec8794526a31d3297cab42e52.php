
<?php $__env->startSection('head'); ?>
<title>反馈建议</title>
<style>
    *{
        margin:0;
        padding:0;
    }
    body{
        background:#fafafa;
    }
    .content{
        padding-bottom: 50px;
        font-size:16px;
    }
    .van-panel__content .van-cell {
        border-bottom: 1px solid #ebedf0;
    }
     .van-panel__header{
        font-size:18px;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div id="container">
    <div ff class="content"> 
        <van-panel title="反馈建议" icon="comment-o" desc="感谢您的使用，有任何问题或建议欢迎进行提交">
            <van-form @submit="onSubmit">
                
                <div>
                <van-field
                    v-model="phone"
                    name="phone"
                    label=""
                    placeholder="请输入联系电话"
                    require
                />
                </div>
                <div>
                <van-field
                    v-model="content"
                    rows="2"
                    autosize
                    label=""
                    type="textarea"
                    maxlength="350"
                    placeholder="请输入问题或建议内容"
                    show-word-limit
                    require
                    />
                </div>
                <div>
                    <van-field name="uploader" label="">
                        <template #input>
                            <van-uploader @oversize="onOversize" :max-size="2 * 1024 * 1024" :max-count="4" :after-read="afterRead" v-model="uploader" />
                        </template>
                    </van-field>
                </div>
                
                <div style="margin: 16px;">
                    <van-button round block type="info" native-type="submit">提交</van-button>
                </div>
            </van-form>
        </van-panel>
        
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script type="text/javascript">
    new Vue({
        el:"#app",
        mixins: [HeaderMixin],
        data:{
            phone: '',
            content:'',
            uploader:[],
        },
		computed:{
			
		},
        created() {
			
		},
		onReady() {

		},
		methods: {
            validatorPhone:function(val){
                return 11 == val.trim().length && /^1[3|4|5|6|7|8|9]\d{9}$/.test(val)
            },
			onSubmit:function(){
			 //   alert(this.api.getProgram());return false;
                let img_arr = this.uploader.filter(val => val.path != null);
                let imgs_url = img_arr.map(v=>{return v.path ? v.path : null}).join(',');
                if(!this.validatorPhone(this.phone)){
                    message({ type: 'danger', message: '手机号格式不正确' });return;
                }
                if(this.content.length < 5){
                    message({ type: 'danger', message: '内容至少五个字以上' });return;
                }
                
                this.api.putQuestion({
					imgs_url:imgs_url,
                    content:this.content,
                    phone:this.phone,
                    from: this.api.getProgram(),
				}, res => {
					message({ type: 'success', message: '感谢反馈建议，我们会尽快查看处理' });
                    setTimeout(() => {
                        window.location.reload()
                    }, 1000);
				});
                
            },
            afterRead(file) {
                // 此时可以自行将文件上传至服务器
                file.status = 'uploading';
                file.message = '上传中...';
                this.api.uploadImg(file.file, res => {
					if(res.code !=0){
                        file.status = 'failed';
                        file.message = '上传失败';
                    }else{
                        file.status = 'done';
                        file.message = '上传成功';
                        file.path = res.data.path;
                    }
				});
            },
            onOversize(file) {
                console.log(file);
                message({ type: 'danger', message: '文件大小不能超过 2M' })
            },
		}
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.card', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>