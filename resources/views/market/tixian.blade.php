@extends('layouts.market')
@section('head')
<title>申请提现</title>
<style>
.user{
    display: flex;
    margin: 20px;
}
.user-left{
    width: 50px;
    height: 50px;
    border-radius: 100%;
    margin-right: 20px;
}
.user-right{
    display: flex;
    flex-direction: column;
    justify-content: space-evenly;
}
.user-right p span{
    background: orange;
    color: white;
    border-radius: 4px;
    padding: 0px 8px;
    font-size: 12px;
}
.user-right h1{
    display: flex;
    align-items: center;
    font-size: 16px;
}
.user-right h1 span{
    font-size: 16px;
    font-weight: bold;
}
.user-right h1 img{
    height: 16px;
    margin-left: 10px;
}
.user-money{
    background: #feb032;
    height: 100px;
    border-radius: 4px;
    margin: 0 10px;
    display: flex;
    align-items: center;
    justify-content: space-around;
}
.user-money .mobney-text{
    color: white;
}
.user-money .mobney{
    font-size: 24px;
    color: white;
    margin: 10px 0;
    font-weight: bold;
}
.user-money .money-right span{
    display: block;
    color: #feb032;
    background: yellow;
    padding: 8px 20px;
    border-radius: 22px;
}
.user-shuju{
    display: flex;
    margin: 10px;
    justify-content: space-around;
}
.shuju-item{
    display: flex;
    flex-direction: column;
    align-items: center;
    
}
.shuju-price{
    font-size: 16px;
    font-weight: bold;
}
.shuju-name{
    font-size: 12px;
    color: #999;
    margin-top: 5px;
}
.mint-swipe-item img{
    width: 100%;
    height: 100%;
}
.wenti p{
    color: #999;
    font-size: 12px;
    margin: 5px 0;
}
</style>
@endsection
@section('content')
<div id="container">
    <div class="user-top">
        <div class="user">
            <img class="user-left" :src="user_pic" alt="">
            <div class="user-right">
                <h1><span>@{{user_name}}</span></h1>
            </div>
        </div>
        <mt-field label="手机号" disabled placeholder="请输入本人的联系电话" type="tel" v-model="user_phone">
        <!-- <span style="margin:0 10px;">更换</span> -->
        </mt-field>
        <mt-field label="验证码" placeholder="请输入验证码" v-model="captcha.value">
            <mt-button size="small" type="primary" :disabled="captcha.disabled" :style="{'background':captcha.disabled?'#c5c5c5':'#1e96fa'}" class="send_code" @click="send_code">@{{captcha.disabled ? captcha.time+' 秒后获取':'获取验证码'}}</mt-button>
        </mt-field>
        <mt-field placeholder="请输入提现金额(不低于5元)" type="number" v-model="tixian_price">
        </mt-field>
        <mt-cell title="收款码">
            <mt-button size="small" type="primary" @click='$refs.uploadDom.click()'>上传收款码</mt-button>
            <input type='file' ref='uploadDom' hidden @change="uploadimg"  accept="image/png,image/jpeg,image/gif,image/jpg"/>
        </mt-cell>
        <div style="margin:10px">
            <div v-if='tixian_img' style='width:100px;'>
                <img @click='previewImage' style='width: 100%;' :src='tixian_img' />
            </div>
        </div>
        <mt-field label="" placeholder="提现备注，可以不填" type="textarea" rows="4" v-model="tixian_info"></mt-field>
        <p style="font-size: 12px;margin: 0 10px 10px 10px;">可提现金额<span style="color: orangered;">@{{user_money}}</span>元</p>
        <p style="margin: 20px;"><mt-button @click="tixian" type="primary" size="large">立即提现</mt-button></p>
    </div>
    <div class="wenti" style="margin:10px">
        <h1>提现说明</h1>
        <p>1.根据监管要求，未实名认证的用户不能进行提现操作。</p>
        <p>2.提现到微信零钱，一般审核需要1-3个工作日。</p>
        <p>3.提现到账后会收到微信消息提醒，请耐心等待。</p>
        <p>4.如有疑问，请联系客服</p>
        <p>5.如需要更改绑定的微信号或手机号，请联系客服（微信号：wxsvpid）。</p>
    </div>
</div>
@endsection
@section('script')
<script src="/smarket/js/jquery-1.11.2.min.js"></script>
<script src="/smarket/js/jqueryqr.js"></script>
<script src="/smarket/js/qrcode.js"></script>
<script type="text/javascript">
    new Vue({
        el:"#app",
        data:{
            user_pic: "{{$user_pic}}",
            user_name: "{{$user_name}}",
            user_phone: "{{$user_phone}}",
            user_money: "{{$user_money}}",
            tixian_price: '',
            tixian_info:'',
            captcha:{
                disabled:false,
                time:60,
                timer:0,
                value:''
            },
            min_money:5,
            tixian_img:'',
        },
        methods: {
            send_code:function(){
               if(this.captcha.disabled){return;}
               if(parseFloat(this.min_money) > parseFloat(this.user_money)){
                    this.$toast('可提现金额不足');return;
               }
				this.$indicator.open();
				let that = this;
                this.$axios.post('/market/api/captcha',{
                    phone : that.user_phone
                }).then(function(res){
                    if(res.code == 0){
                        that.$toast('验证码发送成功');
                        that.captcha.disabled = true;
                        that.captcha.time--
                        that.captcha.timer = setInterval(n=>{
                            if(that.captcha.time == 1){
                                that.captcha.time = 60;
                                that.captcha.disabled = false;
                                clearInterval(that.captcha.timer)
                            }
                            that.captcha.time--
                        },1000)
                    }else{
                        that.$toast(res.msg);
                    }
                    that.$indicator.close();
                }).catch(function(error){
                    console.log(error)
                    that.$toast('验证码发送失败');
					that.$indicator.close();
                });
				
           },
           tixian:function(){
               if(!this.tixian_price || parseFloat(this.tixian_price) < parseFloat(this.min_money)){
                this.$toast('提现金额不能小于'+this.min_money+'元');return;
               }
               console.log(this.user_money)
               if(parseFloat(this.tixian_price) > parseFloat(this.user_money)){
                    this.$toast('可提现金额不足');return;
               }
               if(!this.captcha.value){
                    this.$toast('请输入验证码');return;
               }
               if(!this.tixian_img){
                   this.$toast('请上传收款码图片');return;
               }
               this.$indicator.open();
               this.$axios.post('/market/api/tixian',{
                    captcha : this.captcha.value,
                    tixian_price: parseFloat(this.tixian_price),
                    tixian_info:this.tixian_info,
                    tixian_img:this.tixian_img
                }).then((res) => {
                    this.$indicator.close();
                    if(res.code != '0'){
                        this.$toast(res.msg);
                    }else{
                        this.$toast('申请成功，正在跳转');
                        window.location.href='/market/tixian_list'
                    }

                });
           },
           uploadimg:function(event){
               let dom = this.$refs.uploadDom;
               let img = dom.files[0];
               console.log(img)
               let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                };
                var formData = new FormData();
                formData.append('fileUpload',img)
                this.$indicator.open();
                this.$axios.post('/api/upload',formData ,config).then((res) => {
                    this.tixian_img = res.data.path
                    console.log(this.tixian_img)
                    this.$indicator.close();
                })
               //console.log(this.$refs.uploadDom.click())
           },
           previewImage(){
               wx.previewImage({
                    current : this.tixian_img,
                    urls : [this.tixian_img]
                });
           },
        },
    })
</script>
@endsection