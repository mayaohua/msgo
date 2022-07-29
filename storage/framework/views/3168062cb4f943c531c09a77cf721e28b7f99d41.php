

<?php $__env->startSection('style'); ?>
    <style>
        .AAA .el-collapse-item__header.focusing:focus:not(:hover) {
            color: #303133;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div id="container"  style="position: relative;">
    <el-button type="text" style="position: absolute;right:60px;top:0;z-index:1;color:#409eff;" @click.stop="sysBillData">同步充值数据</el-button>
    <el-button type="text" style="position: absolute;right:10px;top:0;z-index:1;color:#67c23a;" @click.stop="caseDialog.dialogFormVisible = true;caseDialog.dialogFormData = caseDialog.dialogFormDefData">添加</el-button>
    <el-tabs v-model="activeId" @tab-click="handleClick" type="card">
        <el-tab-pane v-for="(list1,index) in billTypeList" :label="list1.type_name" :name="list1.id+''">
            <el-collapse accordion class="AAA">
                <el-collapse-item v-for="(list,index) in billCaseList" v-if="list.bill_type_id == list1.id" :name="index">
                    <template slot="title" style="width:100%;display: flex;justify-content: space-between;">
                        <div style="width:100%;display: flex;flex:1;">
                            <span>{{list.case_name}}</span>
                            <span style="margin-left:50px;">折扣比：<i>{{list.item_profit}}</i></span>
                            <span style="margin-left:50px;">介绍：<i>{{list.short_desc}}</i></span>
                            <span style="margin-left:50px;">充值状态：<i>{{list.stop_sale == 0 ?'开通':'关闭'}}</i></span>
                            <!-- <span v-if="list.stop_sale == 1">充值状态介绍：<i>{{list.stop_sale_tips}}</i></span> -->
                        </div>
                        <div style="width:150px;display: flex;justify-content: space-evenly;">
                            <el-link type="primary"   @click.stop="caseDialog.dialogFormData = list;caseDialog.dialogFormVisible = true">修改</el-link>
                            <template>
                                <el-popconfirm title="确定删除吗？" @confirm="delCase(list)">
                                    <el-link type="danger" slot="reference" @click.stop>删除</el-link>
                                </el-popconfirm>
                            </template>   
                            <el-link type="success"  @click.stop="activeCaseId=list.id;billDialog.dialogFormVisible = true;billDialog.dialogFormData = billDialog.dialogFormDefData">添加</el-link>
                        </div>
                    </template>
                    <div style="margin:10px;">
                        <div v-for="(list2,index2) in billList" v-if="list2.bill_case_id == list.id" style="margin-top:20px;">
                            <el-card shadow="never" class="box-card" :style="list2.stop_sale == 1 ? 'box-shadow: 0 2px 12px 0 rgb(255 0 0);':''">
                                <div style="display: flex;justify-content: space-between;">
                                    <div>
                                        <div style="display:inline-block;margin:10px 10px;">
                                            <label>名称</label>
                                            <el-input style="width:100px;" size="mini" v-model="list2.package"></el-input>
                                        </div>
                                        <div style="display:inline-block;margin:10px 10px;">
                                            <label>预计</label>
                                            <el-input style="width:100px;" size="mini" v-model="list2.yh_tips"></el-input>
                                        </div>
                                        <div style="display:inline-block;margin:10px 10px;">
                                            <label>是否热售</label>
                                            <el-input type="number" style="width:100px;" size="mini" v-model="list2.is_hot"></el-input>
                                        </div>
                                        <div style="display:inline-block;margin:10px 10px;">
                                            <label>商品编号</label>
                                            <el-input style="width:100px;" placeholder="商品编号" size="mini" v-model="list2.itemId"></el-input>
                                        </div>
                                        <div style="display:inline-block;margin:10px 10px;">
                                            <label>商品面值</label>
                                            <el-input type="number" style="width:100px;" placeholder="商品面值(单位厘)" size="mini" v-model="list2.itemFacePrice"></el-input>
                                        </div>
                                        <div style="display:inline-block;margin:10px 10px;">
                                            <label>折扣比例</label>
                                            <el-input style="width:100px;" placeholder="商品折扣比例（%）-1时取分类的折扣" size="mini" v-model="list2.itemProfit" @blur="setNumVal2(list2,'itemProfit')"></el-input>
                                        </div>
                                        <div style="display:inline-block;margin:10px 10px;">
                                            <label>平台销售利润比</label>
                                            <el-input  style="width:100px;" placeholder="平台销售利润比" size="mini" v-model="list2.app_profit" @blur="setNumVal2(list2,'app_profit')"></el-input>
                                        </div>
                                        <div style="display:inline-block;margin:10px 10px;">
                                            <label>允许分销</label>
                                            <el-input style="width:100px;" size="mini" type="number"  placeholder="状态 0为不允许  1为允许" v-model="billDialog.dialogFormData.user_can_sale"  autocomplete="off"></el-input>
                                        </div>
                                        <div style="display:inline-block;margin:10px 10px;">
                                            <label>分销利润比</label>
                                            <el-input  style="width:100px;" placeholder="分销利润比" size="mini" v-model="list2.user_profit" @blur="setNumVal2(list2,'user_profit')"></el-input>
                                        </div>
                                        <div style="display:inline-block;margin:10px 10px;">
                                            <label>分销平台利润比</label>
                                            <el-input  style="width:100px;" placeholder="分销平台利润比" size="mini" v-model="list2.user_app_profit" @blur="setNumVal2(list2,'user_app_profit')"></el-input>
                                        </div>
                                        <div style="display:inline-block;margin:10px 10px;">
                                            <label>是否停售</label>
                                            <el-input type="number" style="width:100px;" placeholder="状态 0为没有下架  1为下架" size="mini" v-model="list2.stop_sale"></el-input>
                                        </div>
                                        <div style="display:inline-block;margin:10px 10px;">
                                            <label>停售说明</label>
                                            <el-input style="width:100px;" placeholder="停售说明" size="mini" v-model="list2.stop_sale_tips"></el-input>
                                        </div>
                                        <div>
                                            <el-button style=" padding: 3px 0;margin-left:10px;" style="color:#67c23a;" type="text" @click="checkPrice(list2,index2)">检查</el-button> 
                                            <el-button style=" padding: 3px 0;margin-left:10px;" type="text" @click="saveBill(list2)">保存</el-button> 
                                            <span style=" padding: 3px 0;margin-left:10px;">
                                                <el-popconfirm title="确定删除吗？" @confirm="delBill(list2)">
                                                    <el-button  slot="reference" style="color:#f56c6c;" type="text" @click.stop>删除</el-button>
                                                </el-popconfirm>
                                            </span> 
                                        </div>  
                                        
                                    </div>
                                    <div style="width:550px;font-size:12px;" v-if="list2.sell_data != null">
                                        <p>商品售面值：{{list2.sell_data.facePrice}}元</p>
                                        <p>商品进货价：{{list2.sell_data.itemSalePrice}}元</p>
                                        <p>平台可出售利润：{{list2.sell_data.itemFreePrice}}元</p>
                                        <p>平台出售利润：{{list2.sell_data.AppFreePrice}}元</p>
                                        <p>可分销利润：{{list2.sell_data.ProfixFreePrice}}元</p>
                                        <p>分销者利润：{{list2.sell_data.UserFreePrice}}元</p>
                                        <p>分销出售平台利润：{{list2.sell_data.UserAppFreePrice}}元</p>
                                        <p>平台出售价：{{list2.sell_data.AppSalePrice}}元</p>
                                        <p>分销出售价：{{list2.sell_data.UserSalePrice}}元</p>
                                    </div>
                                </div>
                            </el-card>
                            
                        </div>
                    </div>
                </el-collapse-item>
            </el-collapse>
        </el-tab-pane>
    </el-tabs>
    <el-dialog title="添加分类"  width="80%" :visible.sync="caseDialog.dialogFormVisible">
        <el-form inline :model="caseDialog.dialogFormData" size="mini" label-width="80px" label-position="left">
            <el-form-item label="分类名称">
                <el-input v-model="caseDialog.dialogFormData.case_name" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="分类简介">
                <el-input v-model="caseDialog.dialogFormData.short_desc" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="分类介绍">
                <el-input type="textarea" v-model="caseDialog.dialogFormData.desc_content" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="折扣比例">
                <el-input v-model="caseDialog.dialogFormData.item_profit" placeholder="商品折扣比例（%）必须大于0" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="是否停售">
                <el-input v-model="caseDialog.dialogFormData.stop_sale" type="number" placeholder="状态 0为没有下架  1为下架" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="停售说明">
                <el-input v-model="caseDialog.dialogFormData.stop_sale_tips" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="允许分销">
                <el-input v-model="caseDialog.dialogFormData.user_can_sale" type="number" placeholder="状态 0为不允许  1为允许" autocomplete="off"></el-input>
            </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
            <el-button @click="caseDialog.dialogFormVisible = false">取 消</el-button>
            <el-button type="primary" @click="addCase">确 定</el-button>
        </div>
    </el-dialog>
    <el-dialog title="添加商品" :visible.sync="billDialog.dialogFormVisible" width="80%">
        <el-form inline :model="billDialog.dialogFormData" size="mini" label-width="80px" label-position="left">
            <el-form-item label="分类名称">
                <el-input v-model="billDialog.dialogFormData.package" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="预计">
                <el-input v-model="billDialog.dialogFormData.yh_tips" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="是否热售">
                <el-input type="number" v-model="billDialog.dialogFormData.is_hot" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="商品编号">
                <el-input  v-model="billDialog.dialogFormData.itemId" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="商品面值">
                <el-input type="number" v-model="billDialog.dialogFormData.itemFacePrice" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="折扣比例">
                <el-input  placeholder="商品折扣比例（%）-1时取分类的折扣" v-model="billDialog.dialogFormData.itemProfit"  @blur="setNumVal2(billDialog.dialogFormData,'itemProfit')" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="是否停售">
                <el-input type="number" v-model="billDialog.dialogFormData.stop_sale" type="number" placeholder="状态 0为没有下架  1为下架" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="停售说明">
                <el-input v-model="billDialog.dialogFormData.stop_sale_tips" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="平台销售利润比">
                <el-input   v-model="billDialog.dialogFormData.app_profit"  @blur="setNumVal2(billDialog.dialogFormData,'app_profit')" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="允许分销">
                <el-input type="number"  placeholder="状态 0为不允许  1为允许" v-model="billDialog.dialogFormData.user_can_sale"  autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="分销利润比">
                <el-input   v-model="billDialog.dialogFormData.user_profit" @blur="setNumVal2(billDialog.dialogFormData,'user_profit')"  autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="分销平台利润比">
                <el-input    v-model="billDialog.dialogFormData.user_app_profit"  @blur="setNumVal2(billDialog.dialogFormData,'user_app_profit')"  autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item v-if="billDialog.dialogFormData.sell_data != null">
                    <p>
                        <span>商品售面值：{{billDialog.dialogFormData.sell_data.facePrice}}元 </span>
                        <span>商品进货价：{{billDialog.dialogFormData.sell_data.itemSalePrice}}元 </span>
                    </p>
                    <p>
                        <span>平台可出售利润：{{billDialog.dialogFormData.sell_data.itemFreePrice}}元 </span>
                        <span>平台出售利润：{{billDialog.dialogFormData.sell_data.AppFreePrice}}元 </span>
                        <span>可分销利润：{{billDialog.dialogFormData.sell_data.ProfixFreePrice}}元</span>
                        <span>分销者利润：{{billDialog.dialogFormData.sell_data.UserFreePrice}}元 </span>
                        <span>分销出售平台利润：{{billDialog.dialogFormData.sell_data.UserAppFreePrice}}元 </span>
                    </p>
                    <p>
                        <span>平台出售价：{{billDialog.dialogFormData.sell_data.AppSalePrice}}元 </span>
                        <span>分销出售价：{{billDialog.dialogFormData.sell_data.UserSalePrice}}元 </span>
                    </p>
            </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
            <el-button @click="billDialog.dialogFormVisible = false">取消</el-button>
            <el-button type="success" @click="checkPriceAdd">检查</el-button>
            <el-button type="primary" @click="addBill">确定</el-button>
        </div>
    </el-dialog>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        new Vue({
            el: "#app",
            data: {
                caseDialog:{
                    dialogFormVisible:false,
                    dialogFormDefData:{
                        case_name:'',
                        short_desc:'',
                        desc_content:'',
                        stop_sale:0,
                        stop_sale_tips:'',
                        user_can_sale:1,
                        item_profit:10,
                    },
                    dialogFormData:{
                        case_name:'',
                        short_desc:'',
                        desc_content:'',
                        stop_sale:0,
                        stop_sale_tips:'',
                        user_can_sale:1,
                        item_profit:10
                    },
                },
                billDialog:{
                    dialogFormVisible:false,
                    dialogFormDefData:{
                        package:'',
                        yh_tips:'',
                        is_hot:0,
                        itemId:'',
                        itemProfit:0,
                        itemFacePrice:0,
                        app_sale_profit:0,
                        user_def_sale_profit:0,
                        min_sale_profit:0,
                        max_sale_profit:0,
                        stop_sale:0,
                        stop_sale_tips:'',
                        user_can_sale:1,
                        user_app_profit:10,
                        user_profit:10,
                        app_profit:10,
                        sell_data:null,
                    },
                    dialogFormData:{
                        package:'',
                        yh_tips:'',
                        is_hot:0,
                        itemId:'',
                        itemProfit:0,
                        itemFacePrice:0,
                        app_sale_profit:0,
                        user_def_sale_profit:0,
                        min_sale_profit:0,
                        max_sale_profit:0,
                        stop_sale:0,
                        stop_sale_tips:'',
                        user_can_sale:1,
                        user_app_profit:10,
                        user_profit:10,
                        app_profit:10,
                        sell_data:null
                    },
                },
                activeId: '1',
                activeIndex:0,
                activeCaseId:0,
                billTypeList: <?php echo $billTypeList; ?>,
                billCaseList: <?php echo $billCaseList; ?>,
                billList: <?php echo $billList; ?>,
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
                    this.$axios.post('/Bill/del/case',{id:item.id}).then((res) => {
                        if(res.code != 0) return;
                        this.billCaseList = this.billCaseList.filter(t => t.id != item.id)
                    })
                },
                addCase(){
                    // console.log(this.dialogFormData)
                    var obj={};
                    obj=JSON.parse(JSON.stringify(this.caseDialog.dialogFormData));
                    if(!obj.bill_type_id){
                        let aaa = this.billTypeList[this.activeIndex]
                        obj.bill_type_id = aaa.id
                        obj.isp = aaa.type_isp
                    }
                    this.$axios.post('/Bill/action/case',obj).then((res) => {
                        if(res.code != 0) return;
                        if(res.data.is_add){
                            obj.id = res.data.nid;
                            this.billCaseList.push(obj);
                        }
                        this.caseDialog.dialogFormVisible = false;
                        this.caseDialog.dialogFormData = this.caseDialog.dialogFormDefData
                    })
                },
                saveBill(item){
                    this.$axios.post('/Bill/action/bill',item).then((res) => {
                        if(res.code != 0) return;
                        
                    })
                },
                checkPrice(item,index){
                    this.$axios.post('/Bill/checkPrice',item).then((res) => {
                        if(res.code != 0) return;
                        this.billList.splice(index,1,res.data)
                    })
                },
                checkPriceAdd(){
                    var item = this.billDialog.dialogFormData
                    this.$axios.post('/Bill/checkPrice',item).then((res) => {
                        if(res.code != 0) return;
                        this.billDialog.dialogFormData = res.data
                    })
                },
                addBill(){
                    var obj={};
                    obj=JSON.parse(JSON.stringify(this.billDialog.dialogFormData));
                    if(!obj.bill_case_id){
                        obj.bill_case_id = this.activeCaseId
                    }
                    this.$axios.post('/Bill/action/bill',obj).then((res) => {
                        if(res.code != 0) return;
                        if(res.data.is_add){
                            obj.id = res.data.nid;
                            this.billList.push(obj);
                        }
                        this.billDialog.dialogFormVisible = false;
                        this.billDialog.dialogFormData = this.billDialog.dialogFormDefData
                    })
                },
                delBill(item){
                    this.$axios.post('/Bill/del/bill',{id:item.id}).then((res) => {
                        this.billList = this.billList.filter(t => t.id != item.id)
                    })
                },
                sysBillData(){
                    this.$axios.post('/Bill/sysBillData').then((res) => {
                        if(res.code == 0){
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        }
                    })
                }
            }
                
        })

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>