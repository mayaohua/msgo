
<?php $__env->startSection('head'); ?>
<title>精品靓号-星耀互联</title>
<style>
    *{
        margin:0;
        padding:0;
    }
    .van-grid-item__text{
        font-size:14px;
    }
    .van-grid-item__icon{
        font-size:0px;
    }
    .van-grid-item__icon img{
        width:2rem;
        height:2rem;
    }
    .van-grid-item__content .van-grid-item__icon+.van-grid-item__text{
        margin-top:0px!important;
    }
    .van-grid-item__content{
        padding:10px 8px;
    }
    i,em{
        font-style: normal;
        font-weight: normal;
    }
    body{
        background:#f0f0f0;
    }
    #container{
        /* padding-bottom: 50px; */
        font-size:16px;
        background:#fff;
    }
    .griditem{
        width:100%;
        height:100%;
    }
    .griditem .van-image{
        flex:1;
        width:50px;
        height:50px;
    }
    .griditem .van-grid-item__content{
        padding:10px 5px;
    }
    .griditem .gridtext{
        flex:1;
        margin-top:8px;
        font-size: 14px;
    }
    .notice-swipe {
		height: 40px;
		line-height: 40px;
	}
    .best-num{
        display:flex;
        /* align-items:center; */
        height:250px;
    }
    .van-sidebar {
        background: #f7f8fa;
    }
    .card-items{
        /* height:220px; */
        
        box-sizing: border-box;
    }
    .card-item{
        /* margin:10px; */
        height:250px;
        box-sizing: border-box;
        overflow: auto;
    }
    .jinpin-items{
        background:#fff;
    }
    .jinpin-item{
        border-bottom:1px solid #ebedf0;
        display:flex;
        align-items: center;
        font-size:14px;
        padding:5px;
    }
    .jinpin-item img{
        width:50px;
        height:50px;
        border-radius:5px;
        margin-right:5px;
        
        box-sizing: border-box;
    }
    .jinpin-item .number{
        color:#000;
        font-size:17px;
    }
    .jinpin-item .number i{
        color:#ff8e08;
        font-size:17px;
    }
    .jinpin-item .guishudi{
        color:#ff8e08;
        font-size:15px;
    }
    .jinpin-item .card-name{
        color:#000;
        font-size:15px;
    }
    .jinpin-item .xiadan{
        color:#ff8e08;
        font-size:16px;
    }
    .jinpin-right{
        flex:1;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        margin-right:10px;
    }
    .jinpin-top-text{
        display:flex;
        align-items: center;
        justify-content: space-between;
    }
    .jinpin-bottom-text{
        display:flex;
        align-items: center;
        justify-content: space-between;
    }
    .list{
        border-radius:5px;
        background:#fff;
    }

    .prick-items{
        background:#fff;
    }
    .prick-item{
        display:flex;
        align-items: center;
        font-size:14px;
        /* padding: 5px; */
    }
    .prick-item img{
        /* width:55px; */
        height:63px;
        border-radius:5px;
        margin-right:5px;
        /* padding:5px; */
        box-sizing: border-box;
    }
    .prick-item .prick-name{
        color:#fa6016;
        font-size:15px;
        text-overflow: -o-ellipsis-lastline;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        line-clamp: 1;
        -webkit-box-orient: vertical;
    }
    .prick-item .prick-name i{
        color:#ff8e08;
        font-size:12px;
        float: right;
    }
    .prick-item .prick-desc{
        color:#999;
        font-size:12px;
        text-overflow: -o-ellipsis-lastline;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        line-height: 18px;
    }
    .prick-item .prick-desc i{
        color:#ff8e08;
        font-size:12px;
    }
    .prick-right{
        flex:1;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        margin-right:10px;
        height: 63px;
    }
    .van-cell .van-cell__title i{
        color:#ed6a0c;
        font-size:12px;
        margin-left:5px;
    }
    .van-cell .van-cell__title{
        display:flex;
        align-items:center;
        flex:2;
        font-size:16px;
    }
    .error-page{
		display: flex;
		align-items: start;
		justify-content: center;
		height: calc(100vh - 100px);
	} 
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div id="container">
    <div class="list" style="border-radius: 5px;">
        <van-search v-model="searchVal" placeholder="搜索你喜欢的数字、幸运数字等" @search="onRefresh"></van-search>
        <div class="van-dropdown-menu">
            <div class="van-dropdown-menu__bar">
                <div role="button" tabindex="0" class="van-dropdown-menu__item" @click="showCity">
                    <span class="van-dropdown-menu__title">
                        <div style="text-algin:center" class="van-ellipsis">{{cityData.fieldValue}}</div>
                    </span>
                </div>
                <div role="button" tabindex="1" class="van-dropdown-menu__item" @click="showLx">
                    <span class="van-dropdown-menu__title">
                        <div style="text-algin:center" class="van-ellipsis">{{LxData.fieldValue}}</div>
                    </span>
                </div>
            </div>
        </div>
        <van-pull-refresh v-model="refreshing" @refresh="onRefresh">
            <div v-show="bestNums.length == 0 && finished == true" class="error-page">
            <van-empty
                class="custom-image"
                image="search"
                description="哎呀，未找到靓号"
                />
            </div>
            <van-list
                v-show="bestNums.length>0" 
                v-model="loading"
                :finished="finished"
                finished-text="没有更多了"
                @load="onLoad"
            >
                
                <div class="jinpin-items">
                    <div class="jinpin-item" v-for="item in bestNums"  @click="gotoOrder(item)">
                        <img :src="item.card_icon" alt="">
                        <div class="jinpin-right">
                            <div class="jinpin-top-text">
                                <span class="number" v-html="item.show_mob?item.show_mob:item.mobile_number"></span>
                                <span class="card-name">{{item.card_name}}</span>
                            </div>
                            <div class="jinpin-bottom-text">
                                <span class="guishudi">{{item.data.area.provice.name+item.data.area.city.name}}</span>
                                <span class="xiadan"><em>免费领取</em></span>
                            </div>
                        </div>
                    </div>
                </div>
                
            </van-list>
        </van-pull-refresh>
    </div>
</div>
<van-popup v-model="selectData.show" position="bottom">
    <van-cascader
        v-model="selectData.cascaderValue"
        :title="selectData.title"
        placeholder="请选择"
        :options="selectData.options"
        :field-names="selectData.fieldNames"
        @close="selectData.show = false"
        @change="onChange"
        @finish="onFinish"
    >
    </van-cascader>
</van-popup>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('js/fillout_order_info_area.js')); ?>"></script>
<script src="<?php echo e(URL::asset('js/cityArea.js')); ?>"></script>

<script type="text/javascript">
    new Vue({
        el:"#app",
        mixins: [HeaderMixin],
        data:{
            static_domain: "<?php echo e(env('STATIC_DOMAIN')); ?>",
            bestNums: <?php echo $best_nums; ?>,
            searchVal:'',
            list: [],
            loading: false,
            finished: false,
            refreshing: false,
            page: 1,
            selectData:{
                title:'',
                show:false,
                options:[],
                fieldValue:'',
                cascaderValue:'',
                who:'',
                fieldNames:null,
            },
            cityData:{
                title:'请选择号码归属地',
                options:cityArea,
                fieldValue:'归属地(全部)',
                cascaderValue:'',
                fieldNames: {
                    text: 'name',
                    value: 'code',
                    children: 'children',
                },
                provinceCode:0,
                cityCode:0
            },
            LxData:{
                title:'请选择号码类型',
                options: <?php echo $rules; ?>,
                fieldValue:'类型(全部)',
                cascaderValue:'',
                fieldNames: {
                    text: 'ze_name',
                    value: 'ze_name'
                },
            },
            
        },
        created() {
            cityArea.splice(0,0,{code: "0",ess_code: "0",name: "全部"})
            cityArea.map((n,i)=>{
                if(n.children){
                    n.children.splice(0,0,{code: "0",ess_code: "0",name: "全部"})
                }
            })
            this.LxData.options.splice(0,0,{"ze_name":"全部"})
            var best_numbers = sessionStorage.getItem("best_numbers");
            if(best_numbers){
                this.bestNums = JSON.parse(best_numbers)
            }else{
                this.onRefresh();
            }
		},
		onReady() {
            
		},
		methods: {
            onLoad() {
                this.changeBestNum();
            },
            onRefresh() {
                // 清空列表数据
                this.finished = false;
                // 重新加载数据
                // 将 loading 设置为 true，表示处于加载状态
                this.loading = true;
                this.refreshing = true;
                this.onLoad();
            },
			gotoPage(url){
                if(this.api.getQueryString('xcx')){
                    window.location.href= url+'?xcx=1';
                }else{
                    window.location.href= url;
                }
            },
            gotoOrder(item){
                let url = '/card/apply_best?number='
                +item.mobile_number+
                '&provinceName='+item.data.area.provice.name+
                '&provinceCode='+item.data.area.provice.ess_code+
                '&cityCode='+item.data.area.city.code+
                '&cityName='+item.data.area.city.name+
                '&card_id='+item.card_id+
                '&card_name='+item.card_name+
                '&mobile_from='+item.mobile_from;
                url += (this.api.getQueryString('xcx') ? '&xcx=1' : '');
                this.api.isMiniProgram((res)=>{//判断是否是小程序页面的回调函数
                    console.log(res)
                    if (res) {//小程序页面
                        wx.miniProgram.navigateTo({url: '/pages/center/navigator?url=' + escape(window.location.origin+url)});
                    } else {
                        window.location.href= url;
                    }
                })
            },
            changeBestNum(){
                let city_ess_code = this.cityData.cityCode;
                let province_ess_code = this.cityData.provinceCode;
                let url = '/api/card/best_nums';
                if (this.refreshing) {
                    this.page = 1;
                }
                let data = {
                    p:province_ess_code,
                    c:city_ess_code,
                    search:this.searchVal,
                    lx:this.LxData.cascaderValue,
                    page:this.page
                }
                let that = this;
                
                
                $.post(url,data,function(res){
                    that.loading = false;
                    if(res.code == 0){
                        let Ndata = res.data.data;
                        if(res.data.last_page == data.page){
                            that.finished = true;
                        }
                        $.each(Ndata, function (i, v) {
                            var tel = v.mobile_number;
                            var ptype=1;
                            var lh = that.api.regPhone(tel);
                            if(lh){
                                var str_before = tel.split(lh)[0]; 
                                var str_after = tel.split(lh)[1]; 
                                tel=str_before+"<i style='color:#F00'>"+lh+"</i>"+str_after;  
                                is_lh = true;
                            }
                            v.show_mob = tel;
                        })
                        that.page++;
                        if (that.refreshing) {
                            that.bestNums = [];
                            that.refreshing = false;
                        }
                        that.bestNums = that.bestNums.concat(Ndata)
                        sessionStorage.setItem("best_numbers", JSON.stringify(that.bestNums));
                        //if(Ndata.length) that.bestNums = Ndata
                    }
                })
            },
            showCity(){
                this.selectData =  {
                    title:this.cityData.title,
                    show:true,
                    options:this.cityData.options,
                    fieldValue:this.cityData.fieldValue,
                    cascaderValue:this.cityData.cascaderValue,
                    fieldNames:this.cityData.fieldNames,
                    who:'cityData'
                }
            },
            showLx(){
                this.selectData =  {
                    title:this.LxData.title,
                    show:true,
                    options:this.LxData.options,
                    fieldValue:this.LxData.fieldValue,
                    cascaderValue:this.LxData.cascaderValue,
                    fieldNames:this.LxData.fieldNames,
                    who:'LxData'
                }
            },
            onChange({ value }) {
                
            },
            onFinish({ selectedOptions }) {
                this.selectData.show = false;
                
                if(this.selectData.who == 'cityData'){
                    this.selectData.fieldValue = selectedOptions.map((option) => option.name).join(' ');
                    this[this.selectData.who].fieldValue = this.selectData.fieldValue
                    this[this.selectData.who].cascaderValue = this.selectData.cascaderValue
                    this.cityData.provinceCode = selectedOptions[0].ess_code;
                    if(this.cityData.provinceCode == 0){
                        this[this.selectData.who].fieldValue = '归属地(全部)';
                        this.cityData.cityCode = 0;
                    }else{
                        this.cityData.cityCode = selectedOptions[1].ess_code;
                    }
                }
                if(this.selectData.who == 'LxData'){
                    this.selectData.fieldValue = selectedOptions.map((option) => option.ze_name).join('');
                    this[this.selectData.who].fieldValue = this.selectData.fieldValue
                    this[this.selectData.who].cascaderValue = this.selectData.cascaderValue
                    if(this[this.selectData.who].cascaderValue == '全部'){
                        this[this.selectData.who].cascaderValue = '';
                        this[this.selectData.who].fieldValue = '类型(全部)';
                    }
                }
                this.onRefresh();
            },
        }
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.card', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>