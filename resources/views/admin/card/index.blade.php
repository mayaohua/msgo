@extends('layouts.admin')

@section('style')
    <style>
        .AAA .el-collapse-item__header.focusing:focus:not(:hover) {
            color: #303133;
        }
        .table-center{
            margin:10px;
            font-size: 13px;
            color: #303133;
            line-height: 1.769230769230769;
        }
    </style>
@endsection
@section('content')
    <div id="container">
        <input type="file"  ref='uploadDom' @change="getFile($event)" hidden accept=".png,.jpg,.jpeg">
        <input type="file" multiple ref='uploadsDom' @change="getFile($event)" hidden accept=".png,.jpg,.jpeg">
    <el-card class="box-card" shadow="never">
        <div slot="header" class="clearfix">
            <span>卡种商品</span>
            <el-button style="float: right; padding: 3px 0;color:rgb(103, 194, 58)" @click="caseDialog.dialogFormVisible = true;caseDialog.dialogFormData = caseDialog.dialogFormDefData" type="text">添加卡种</el-button>
        </div>
        <el-tabs v-model="activeId" @tab-click="handleClick" type="card">
            <el-tab-pane v-for="(list1,index1) in cardCaseList" :label="list1.case_name" :name="list1.id+''">
                <el-button style="padding: 3px 10px;" @click="caseDialog.dialogFormData = list1;caseDialog.dialogFormVisible = true"  type="primary">修改卡种</el-button>
                <template>
                    <el-popconfirm title="确定删除吗？" @confirm="delCase(list1)">
                        <el-button slot="reference" @click.stop style="padding: 3px 10px;" type="danger">删除卡种</el-button>
                    </el-popconfirm>
                </template>   
                
                <el-button @click="activeCaseId=list1.id;cardDialog.dialogFormVisible = true;cardDialog.dialogFormData = cardDialog.dialogFormDefData" size="mini" type="success" plain>添加套餐</el-button>
                <div class="table-center">
                    <div v-for="(list2,index2) in cardList" v-if="list2.card_case_id == list1.id" style="margin-top:20px;">
                        <el-card shadow="never" class="box-card" :style="list2.stop_sale == 1 ? 'box-shadow: 0 2px 12px 0 rgb(255 0 0);':''">
                            <div style="display: flex;justify-content: space-between;">
                                <div>
                                    <div style="display:inline-block;margin:10px 10px;">
                                        <label>套餐名称</label>
                                        <el-input style="width:150px;" size="mini" v-model="list2.card_name"></el-input>
                                    </div>
                                    <div style="display:inline-block;margin:10px 10px;">
                                        <label>套餐图标</label>
                                        <i class="el-icon-upload" @click="inputClick('cardList','card_icon',index2)" style="margin-right:0 10px;cursor: pointer;"></i>
                                        <el-input  type="textarea" style="width:150px;" size="mini" v-model="list2.card_icon"></el-input>
                                    </div>
                                    <div style="display:inline-block;margin:10px 10px;">
                                        <label>卡片图片</label>
                                        <i class="el-icon-upload" @click="inputClick('cardList','card_item_img',index2)" style="margin-right:0 10px;cursor: pointer;"></i>
                                        <el-input  type="textarea" style="width:150px;" placeholder="套餐卡片图片" size="mini" v-model="list2.card_item_img"></el-input>
                                    </div>
                                    <div style="display:inline-block;margin:10px 10px;">
                                        <label>productId</label>
                                        <el-input style="width:150px;" placeholder="" size="mini" v-model="list2.card_product_id"></el-input>
                                    </div>
                                    <div style="display:inline-block;margin:10px 10px;">
                                        <label>productType</label>
                                        <el-input style="width:150px;" placeholder="" size="mini" v-model="list2.card_product_type"></el-input>
                                    </div>
                                    <div style="display:inline-block;margin:10px 10px;">
                                        <label>文字介绍</label>
                                        <el-input  type="textarea" style="width:150px;" placeholder="" size="mini" v-model="list2.text_short_desc"></el-input>
                                    </div>
                                    <div style="display:inline-block;margin:10px 10px;">
                                        <label>图片介绍</label>
                                        <i class="el-icon-upload" @click="inputClick('cardList','img_short_desc',index2)" style="margin-right:0 10px;cursor: pointer;"></i>
                                        <el-input  type="textarea" style="width:150px;" placeholder="" size="mini" v-model="list2.img_short_desc"></el-input>
                                    </div>
                                    <div style="display:inline-block;margin:10px 10px;">
                                        <label>分销价格</label>
                                        <el-input  placeholder="分销价格" type="text" style="width:150px;"  size="mini" v-model="list2.sell_price" ></el-input>
                                    </div>
                                    <div style="display:inline-block;margin:10px 10px;">
                                        <label>首月资费</label>
                                        <el-input  placeholder="请输入json格式的配置" type="textarea" style="width:150px;"  size="mini" v-model="list2.first_month_fee" ></el-input>
                                    </div>
                                    <div style="display:inline-block;margin:10px 10px;">
                                        <label>其他参数</label>
                                        <el-input  placeholder="请输入json格式的配置" type="textarea" style="width:150px;"  size="mini" v-model="list2.card_other_datas" ></el-input>
                                    </div>
                                    <div style="display:inline-block;margin:10px 10px;">
                                        <label>停售说明</label>
                                        <el-input  placeholder="停售说明" type="textarea" style="width:150px;"  size="mini" v-model="list2.stop_sale_tips" ></el-input>
                                    </div>
                                    <div style="display:inline-block;margin:10px 10px;">
                                        <label>是否停售</label>
                                        <el-switch active-value="1" inactive-value="0" active-color="#ff4949" v-model="list2.stop_sale"></el-switch>
                                    </div>
                                    <div style="display:inline-block;margin:10px 10px;">
                                        <label>允许分销</label>
                                        <el-switch active-value="1" inactive-value="0" v-model="list2.user_can_sale"></el-switch>
                                    </div>
                                    
                                    <div style="display:inline-block;margin:10px 10px;">
                                        <label>是否推荐</label>
                                        <el-switch active-value="1" inactive-value="0" v-model="list2.is_hot"></el-switch>
                                        <!-- <el-input type="number" style="width:150px;" size="mini" v-model="list2.is_hot"></el-input> -->
                                    </div>
                                    <div>
                                        <el-button style=" padding: 3px 0;margin-left:10px;" type="text" @click="saveBill(list2)">保存</el-button> 
                                        <span style=" padding: 3px 0;margin-left:10px;">
                                            <el-popconfirm title="确定删除吗？" @confirm="delBill(list2)">
                                                <el-button  slot="reference" style="color:#f56c6c;" type="text" @click.stop>删除</el-button>
                                            </el-popconfirm>
                                        </span> 
                                    </div>  
                                    
                                </div>
                            </div>
                        </el-card>
                        
                    </div>
                </div>
            </el-tab-pane>
        </el-tabs>
    </el-card>
    
     <el-dialog title="添加卡种"  width="80%" :visible.sync="caseDialog.dialogFormVisible">
        <el-form inline :model="caseDialog.dialogFormData" size="mini"  label-position="left">
            <el-form-item label="卡种名称">
                <el-input v-model="caseDialog.dialogFormData.case_name" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item>
                <span slot="label">
                卡种图标
                <i class="el-icon-upload" @click="inputClick('caseDialog','case_icon',-1)" style="margin-right:0 10px;cursor: pointer;"></i></span>
                <el-input type="textarea"  v-model="caseDialog.dialogFormData.case_icon" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="文字介绍">
                <el-input placeholder="卡种文字介绍" type="textarea" v-model="caseDialog.dialogFormData.text_short_desc" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="顶部图片">
                <span slot="label">
                顶部图片
                <i class="el-icon-upload2" @click="inputClick('caseDialog','desc_top_imgs',-1,1)" title="多文件按顺序上传" style="margin-right:0 10px;cursor: pointer;"></i>
                </span>
                <el-input placeholder="图片地址列表，多个图片用,隔开" type="textarea" v-model="caseDialog.dialogFormData.desc_top_imgs" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="低部图片">
                <span slot="label">
                低部图片
                <i class="el-icon-upload2" @click="inputClick('caseDialog','desc_bottom_imgs',-1,1)" title="多文件按顺序上传" style="margin-right:0 10px;cursor: pointer;"></i>
                </span>
                <el-input placeholder="图片地址列表，多个图片用,隔开" type="textarea" v-model="caseDialog.dialogFormData.desc_bottom_imgs" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="停售说明">
                <el-input type="textarea" v-model="caseDialog.dialogFormData.stop_sale_tips" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="分销完成条件">
                <el-input type="textarea" v-model="caseDialog.dialogFormData.sell_factor" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="分销说明">
                <el-input type="textarea" v-model="caseDialog.dialogFormData.sell_info" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="分销海报图片">
                <span slot="label">
                分销海报图片
                <i class="el-icon-upload" @click="inputClick('caseDialog','sell_banner_img',-1)" style="margin-right:0 10px;cursor: pointer;"></i></span>
                <el-input type="textarea" v-model="caseDialog.dialogFormData.sell_banner_img" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="分销展示图片">
                <span slot="label">
                分销展示图片
                <i class="el-icon-upload" @click="inputClick('caseDialog','sell_item_img',-1)" style="margin-right:0 10px;cursor: pointer;"></i></span>
                <el-input type="textarea" v-model="caseDialog.dialogFormData.sell_item_img" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="其他参数">
                <el-input placeholder="请输入json格式的配置" type="textarea" v-model="caseDialog.dialogFormData.case_other_datas" autocomplete="off" ></el-input>
            </el-form-item>
            <el-form-item label="分销展示价格">
                <el-input type="textarea" v-model="caseDialog.dialogFormData.sell_price" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="展示列表">
                <el-switch active-value="1" inactive-value="0" v-model="caseDialog.dialogFormData.is_show_cards "></el-switch>
            </el-form-item>
            <el-form-item label="是否停售">
                <el-switch active-value="1" inactive-value="0" active-color="#ff4949" v-model="caseDialog.dialogFormData.stop_sale"></el-switch>
            </el-form-item>
            <el-form-item label="允许分销">
                <el-switch active-value="1" inactive-value="0" v-model="caseDialog.dialogFormData.user_can_sale"></el-switch>
            </el-form-item>
            <el-form-item label="精品可用">
                <el-switch active-value="1" inactive-value="0" v-model="caseDialog.dialogFormData.best_show"></el-switch>
            </el-form-item>
            <el-form-item label="扫号可用">
                <el-switch active-value="1" inactive-value="0" v-model="caseDialog.dialogFormData.scan_show"></el-switch>
            </el-form-item>
            
        </el-form>
        <div slot="footer" class="dialog-footer">
            <el-button @click="caseDialog.dialogFormVisible = false">取 消</el-button>
            <el-button type="primary" @click="addCase">确 定</el-button>
        </div>
    </el-dialog>
    <el-dialog title="添加套餐" :visible.sync="cardDialog.dialogFormVisible" width="80%">
        <el-form inline :model="cardDialog.dialogFormData" size="mini" label-position="left">
            <el-form-item label="套餐名称">
                <el-input v-model="cardDialog.dialogFormData.card_name" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item>
                <span slot="label">
                套餐图标
                <i class="el-icon-upload" @click="inputClick('cardDialog','card_icon',-1)" style="margin-right:0 10px;cursor: pointer;"></i></span>
                <el-input  type="textarea" v-model="cardDialog.dialogFormData.card_icon" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item>
                <span slot="label">
                列表图片
                <i class="el-icon-upload" @click="inputClick('cardDialog','card_item_img',-1)" style="margin-right:0 10px;cursor: pointer;"></i></span>
                <el-input  type="textarea"  v-model="cardDialog.dialogFormData.card_item_img" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="图片介绍">
                <span slot="label">
                图片介绍
                <i class="el-icon-upload" @click="inputClick('cardDialog','img_short_desc',-1)" style="margin-right:0 10px;cursor: pointer;"></i></span>
                <el-input  type="textarea" placeholder="图片地址" v-model="cardDialog.dialogFormData.img_short_desc" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="文字介绍">
                <el-input type="textarea" placeholder="套餐介绍" v-model="cardDialog.dialogFormData.text_short_desc" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="productId">
                <el-input  v-model="cardDialog.dialogFormData.card_product_id" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="productType">
                <el-input  v-model="cardDialog.dialogFormData.card_product_type" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="分销价格">
                <el-input placeholder="分销价格" v-model="cardDialog.dialogFormData.sell_price" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="首月资费">
                <el-input placeholder="请输入json格式的配置" type="textarea" v-model="cardDialog.dialogFormData.first_month_fee" autocomplete="off" ></el-input>
            </el-form-item>
            <el-form-item label="其他参数">
                <el-input placeholder="请输入json格式的配置" type="textarea" v-model="cardDialog.dialogFormData.card_other_datas" autocomplete="off" ></el-input>
            </el-form-item>
            <el-form-item label="停售说明">
                <el-input type="textarea" v-model="cardDialog.dialogFormData.stop_sale_tips" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="是否停售">
                <el-switch active-value="1" inactive-value="0" active-color="#ff4949" v-model="cardDialog.dialogFormData.stop_sale"></el-switch>
            </el-form-item>
            <el-form-item label="允许分销">
                <el-switch active-value="1" inactive-value="0" v-model="cardDialog.dialogFormData.user_can_sale"></el-switch>
            </el-form-item>
            <el-form-item label="是否推荐">
                <el-switch active-value="1" inactive-value="0" v-model="cardDialog.dialogFormData.is_hot"></el-switch>
            </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
            <el-button @click="cardDialog.dialogFormVisible = false">取消</el-button>
            <el-button type="primary" @click="addBill">确定</el-button>
        </div>
    </el-dialog>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        new Vue({
            el: "#app",
            data: {
                tempUpload: {
                    index:0,
                    imgPath:[],
                    who:'',
                    more:false
                },
                caseDialog:{
                    dialogFormVisible:false,
                    dialogFormDefData:{
                        'case_name' : '',
                        'case_icon' : '',
                        'text_short_desc' : '',
                        'desc_top_imgs' : '',
                        'desc_bottom_imgs' : '',
                        'is_show_cards' : '1',
                        'stop_sale' : ' 0',
                        'stop_sale_tips' : '',
                        'user_can_sale' : '1',
                        'best_show' : '1',
                        'scan_show' : '1',
                        'case_other_datas' : '',
                        'sell_factor':'',
                        'sell_info':'',
                        'sell_price':'',
                        'sell_banner_img':'',
                        'sell_item_img':''
                    },
                    dialogFormData:{
                        'case_name' : '',
                        'case_icon' : '',
                        'text_short_desc' : '',
                        'desc_top_imgs' : '',
                        'desc_bottom_imgs' : '',
                        'is_show_cards' : '1',
                        'stop_sale' : ' 0',
                        'stop_sale_tips' : '',
                        'user_can_sale' : '1',
                        'best_show' : '1',
                        'scan_show' : '1',
                        'case_other_datas' : '',
                        'sell_factor':'',
                        'sell_info':'',
                        'sell_price':'',
                        'sell_banner_img':'',
                        'sell_item_img':''
                    },
                },
                cardDialog:{
                    dialogFormVisible:false,
                    dialogFormDefData:{
                        'card_name' : '',
                        'card_icon' : '',
                        'card_item_img' : '',
                        'card_product_id' : '',
                        'card_product_type' : '',
                        'first_month_fee' : '',
                        'is_hot' : '0',
                        'text_short_desc' : '',
                        'img_short_desc' : '',
                        'stop_sale' : '0',
                        'stop_sale_tips' : '',
                        'user_can_sale'  : '1',
                        'card_other_datas' : '',
                        'sell_price':0
                    },
                    dialogFormData:{
                        'card_name' : '',
                        'card_icon' : '',
                        'card_item_img' : '',
                        'card_product_id' : '',
                        'card_product_type' : '',
                        'first_month_fee' : '',
                        'is_hot' : '0',
                        'text_short_desc' : '',
                        'img_short_desc' : '',
                        'stop_sale' : '0',
                        'stop_sale_tips' : '',
                        'user_can_sale'  : '1',
                        'card_other_datas' : '',
                        'sell_price':0
                    },
                },
                activeId: '1',
                activeIndex:0,
                activeCaseId:0,
                cardCaseList: {!! $cardCaseList !!},
                cardList: {!! $cardList !!},
                is_check:false
            },
            computed:{
                inputModel() {
                    return function(value) {
                        return value
                    }
                }
            },
            created(){
                
            },
            methods: {
                setNumVal2(data,who){
                    data[who] = parseFloat(data[who]).toFixed(2)
                    // data[who] = data[who].toFixed(2)
                },
                oninput(e) {
                    console.log(e)
                    // 通过正则过滤小数点后两位
                    // e.target.value = (e.target.value.match(/^\d*(\.?\d{0,2})/g)[0]) || null
                    // console.log('e',e.target.value)
                },
                handleClick(tab, event) {
                    this.activeIndex = tab.index
                },
                delCase(item){
                    this.$axios.post('/Card/del/case',{id:item.id}).then((res) => {
                        if(res.code != 0) return;
                        this.cardCaseList = this.cardCaseList.filter(t => t.id != item.id)
                    })
                },
                addCase(){
                    var obj={};
                    obj=JSON.parse(JSON.stringify(this.caseDialog.dialogFormData));
                    if(!obj.card_case_id){
                        let aaa = this.cardCaseList[this.activeIndex]
                        obj.card_case_id = aaa.id
                    }
                    this.$axios.post('/Card/action/case',obj).then((res) => {
                        if(res.code != 0) return;
                        if(res.data.is_add){
                            obj.id = res.data.nid;
                            this.cardCaseList.push(obj);
                        }
                        this.caseDialog.dialogFormVisible = false;
                        this.caseDialog.dialogFormData = this.caseDialog.dialogFormDefData
                    })
                },
                saveBill(item){
                    this.$axios.post('/Card/action/card',item).then((res) => {
                        if(res.code != 0) return;
                        
                    })
                },
                addBill(){
                    var obj={};
                    obj=JSON.parse(JSON.stringify(this.cardDialog.dialogFormData));
                    if(!obj.card_case_id){
                        obj.card_case_id = this.activeCaseId
                    }
                   
                    this.$axios.post('/Card/action/card',obj).then((res) => {
                        if(res.code != 0) return;
                        if(res.data.is_add){
                            obj.id = res.data.nid;
                            this.cardList.push(obj);
                        }
                        this.cardDialog.dialogFormVisible = false;
                        this.cardDialog.dialogFormData = this.cardDialog.dialogFormDefData
                    })
                },
                delBill(item){
                    this.$axios.post('/Card/del/card',{id:item.id}).then((res) => {
                        this.cardList = this.cardList.filter(t => t.id != item.id)
                    })
                },
                getFile(event){
                        var files = event.target.files;
                        var filePathArr = [];
                        for(var i = 0;i<files.length;i++){
                            var imgName = files[i].name;
                            this.tempUpload.imgPath = [];
                            var idx = imgName.lastIndexOf(".");  
                            if (idx != -1){
                                var ext = imgName.substr(idx+1).toUpperCase();   
                                ext = ext.toLowerCase( ); 
                                if (ext!='png' && ext!='jpg' && ext!='jpeg'){
                                    this.$message({
                                        type: 'wraing',
                                        message: '请上传图片格式不正确'
                                    });return;
                                }else{
                                    filePathArr[i] = files[i];
                                }   
                            }
                        }
                        this.tempUpload.imgPath = filePathArr;
                        this.uploadImgAction()
                },
                inputClick(tableName,itemName,index,more){
                    
                    this.tempUpload.index = index;
                    this.tempUpload.tableName = tableName;
                    this.tempUpload.itemName = itemName;
                    if(more == 1){
                        this.tempUpload.more = true;
                        this.$refs['uploadsDom'].click();
                    }else{
                        this.tempUpload.more = false;
                        this.$refs['uploadDom'].click();
                    }
                    
                },
                uploadImgAction(){
                    console.log(this.tempUpload);//return;
                    let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                    };
                    var formData = new FormData();
                    this.tempUpload.imgPath.forEach(function (file,index) {
                        formData.append('fileUpload['+index+']', file, file.name);
                    })
                    //formData.append('fileUpload',this.tempUpload.imgPath);
                    formData.append('filemore',this.tempUpload.more);
                    formData.append('domain',1)
                    this.$axios.post('/upload',formData,config).then((res) => {
                        if(this.tempUpload.index == -1){
                            this[this.tempUpload.tableName]['dialogFormData'][this.tempUpload.itemName]= res.data.path
                            console.log(this.tempUpload.tableName,this.tempUpload.itemName)
                        }else{
                            this[this.tempUpload.tableName][this.tempUpload.index][this.tempUpload.itemName] = res.data.path
                        }
                        this.$refs['uploadDom'].value = '';
                    })
                }
            }
                
        })
    </script>
@endsection
