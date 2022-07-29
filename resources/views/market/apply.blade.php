@extends('layouts.market')

@section('head')
<title>合伙人申请</title>
@endsection
@section('content')
<div id="container">
    <span style="padding:10px 10px;display:block;color: #999;">请确保认证信息的真实有效</span>
    <mt-field label="真实姓名" placeholder="请输入本人的真实姓名" v-model="formData.user_name"></mt-field>
    <mt-field label="身份证号" placeholder="请输入本人的身份证号" type="text" v-model="formData.user_code"></mt-field>
    <mt-field label="联系电话" placeholder="请输入本人的联系电话" type="tel" v-model="formData.user_phone"></mt-field>
    <mt-field label="验证码" placeholder="请输入验证码" v-model="formData.captcha">
        <mt-button size="small" type="primary" :disabled="captcha.disabled" :style="{'background':captcha.disabled?'#c5c5c5':'#1e96fa'}" class="send_code" @click="send_code">@{{captcha.disabled ? captcha.time+' 秒后获取':'获取验证码'}}</mt-button>
    </mt-field>
    <mt-field label="常用微信" placeholder="可不填写，常用微信号" v-model="formData.user_wx_id"></mt-field>
    {{-- <span style="padding:0 10px;margin-top:30px;display:block;color: red;font-size:12px;">分销产生的佣金将提现到微信零钱，请确保账户（{{$user_nike}}）已通过实名认证</span> --}}
    <div style="margin-top:20px;padding:0 10px;" >
        <mt-button size="large" type="primary" @click="submit">提交申请</mt-button>
    </div>
</div> 
@endsection
@section('script')
<script type="text/javascript">
    new Vue({
        el:"#app",
        data:{
            formData:{
                user_name:'',
                user_code:'',
                user_phone:'',
                user_wx_id:'',
                captcha:''
            },
            captcha:{
                disabled:false,
                time:60,
                timer:0,
            },
        },
        methods: {
           send_code:function(){
               if(this.captcha.disabled){return;}
               if(this.formData.user_phone ===''){
                   this.$toast('手机号码不能为空');return;
               }
               if(11 !== this.formData.user_phone.length || !/^1[3|4|5|6|7|8|9]\d{9}$/.test(this.formData.user_phone)){
                   this.$toast('手机号格式不正确');return;
               }
				this.$indicator.open();
				let that = this;
                this.$axios.post('/market/api/captcha',{
                    phone : that.formData.user_phone
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
           submit:function(){
               if(this.formData.user_name ===''){
                   this.$toast('真实姓名不能为空');return;
               }
               var idO = this.idcardCheck(this.formData.user_code);
               if(!idO.isPass){
                    this.$toast(idO.errorMess);return;
               }
                if(this.formData.user_phone === ''){
                    this.$toast('手机号码不能为空');return;
                }
                if(11 !== this.formData.user_phone.length || !/^1[3|4|5|6|7|8|9]\d{9}$/.test(this.formData.user_phone)){
                    this.$toast('手机号格式不正确');return;
                }
                if(this.formData.captcha === ''){
                    this.$toast('验证码不能为空');return;
                }
                this.$indicator.open();
                let that = this;
                this.$axios.post('/market/api/apply_action',
                    this.formData
                ).then(function(res){
                    if(res.code == 0){
                        that.$toast('申请成功正在跳转');
                        window.setTimeout(n=>{
                            window.location.href="/market"
                        },2000)
                    }else{
                        that.$toast(res.msg);
                    }
                    that.$indicator.close();
                })
           },
           idcardCheck: function(a) {
			        var t = {
			            11: "北京",
			            12: "天津",
			            13: "河北",
			            14: "山西",
			            15: "内蒙古",
			            21: "辽宁",
			            22: "吉林",
			            23: "黑龙江 ",
			            31: "上海",
			            32: "江苏",
			            33: "浙江",
			            34: "安徽",
			            35: "福建",
			            36: "江西",
			            37: "山东",
			            41: "河南",
			            42: "湖北 ",
			            43: "湖南",
			            44: "广东",
			            45: "广西",
			            46: "海南",
			            50: "重庆",
			            51: "四川",
			            52: "贵州",
			            53: "云南",
			            54: "西藏 ",
			            61: "陕西",
			            62: "甘肃",
			            63: "青海",
			            64: "宁夏",
			            65: "新疆",
			            71: "台湾",
			            81: "香港",
			            82: "澳门",
			            91: "国外 "
			        }, o = /^\d{6}(18|19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|X)$/i, e = "", n = !0;
			        if (a && o.test(a)) if (t[a.substr(0, 2)]) {
			            if (18 == a.length) {
			                a = a.split("");
			                for (var c = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2 ], s = [ 1, 0, "X", 9, 8, 7, 6, 5, 4, 3, 2 ], i = 0, r = 0; r < 17; r++) i += a[r] * c[r];
			                s[i % 11] != a[17] && (e = "您输入的身份证号不存在！", n = !1);
			            }
			        } else e = "您输入的身份证地址编码有误！", n = !1; else e = "您输入的身份证号格式有误！", n = !1;
			        return {
			            errorMess: e,
			            isPass: n
			        };
			    },
        },
    })
</script>
@endsection