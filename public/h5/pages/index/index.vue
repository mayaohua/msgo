<template>
	<view>
		<swiper class="screen-swiper square-dot" :indicator-dots="true" :circular="true" :autoplay="true"
			interval="5000" duration="500" indicator-color="#8799a3" indicator-active-color="#0081ff">
			<swiper-item v-for="(item,index) in swiperList" :key="index">
				<image :src="item.url" mode="aspectFill"></image>
			</swiper-item>
		</swiper>
		<view class="content">
			<view class="cu-form-group margin-top">
				<input :value=" input.phone " placeholder="请输入要充值的手机号码" maxlength="11"
        type="number" pattern="[0-9]*" :auto-focus="input.autoFocus" :focus="input.focus" @input="onInput" name="input"></input>
				<text @click="inputClear" class='cuIcon-close text-orange' style="margin-right: 10px;font-size: 20px;"></text>
				<view v-if="isp" class="cu-capsule radius" >
					<!-- <view class='cu-tag bg-blue '>
						{{isp.province+(isp.city?'-'+isp.city:'')+' ['+isp.sp+']'}}
					</view> -->
					<view class="cu-tag line-blue ui-isp">
						{{isp.province+(isp.city?'-'+isp.city:'')+' ['+isp.sp+']'}}
					</view>
				</view>
				
			</view>
			<scroll-view scroll-x class="bg-white nav" style="margin-top: 5px;">
				<view class="flex text-center">
					<view class="cu-item flex-sub" :class="index==TabCur?'text-orange cur':''"
						v-for="(item,index) in list" :key="index" @tap="tabSelect" :data-id="index">
						{{item.type_name}}
					</view>
				</view>
			</scroll-view>
			<view v-for="(item,index) in list" :key="index" style="margin-top: 5px;">
				<scroll-view v-show="index == TabCur">
					<view class="ui-content" v-for="(caseitem,caseindex) in item.billcases" :key="caseindex">
						<view class="ui-title">
							<view>
								<text class="cuIcon-title text-green"></text>{{caseitem.case_name}}
							</view>
							<view class="ui-info" :data-desc="caseitem.desc_content" @click="xiangqing">详情</view>
						</view>
						<view class="ui-items">
							<view class="ui-item" v-for="(billitem,billindex) in caseitem.bills" :key="billindex"
							@click="onSellPut" 
							  :data-desc="billitem.order_tips"
							  :data-cc="billitem.case_name"
							  :data-price="billitem.sale_price"
							  :data-package="billitem.package"
							  :data-yh_tips="billitem.yh_tips"
							  :data-id="billitem.id"
							  :data-bill_case_id="billitem.bill_case_id">
								<view class="ui-cont">
									<view class="small-desc">{{billitem.yh_tips}}</view>
									<view style="margin:5px 0;"><text class="text-red">面值：{{billitem.package}}</text>
									</view>
									<view>售价：{{billitem.sale_price}}</view>
								</view>
							</view>
						</view>
					</view>
				</scroll-view>
			</view>
		</view>
		<view class="cu-modal" :class="dialog.show?'show':''">
			<view class="cu-dialog">
				<view class="cu-bar bg-white justify-end">
					<view class="content" style="font-size: 18px;font-weight: bold;
					text-align: left;margin-left: 30px;width: 100%;">{{dialog.title}}</view>
				</view>
				<view class="padding-xl" style="text-align: left;background: white;padding: 10px 25px;
				border-top: 1px solid #eee;font-size: 15px;">
					<rich-text :nodes="dialog.content"></rich-text>
				</view>
				<view class="cu-bar bg-white justify-end" style="padding-right: 20px;padding-bottom: 10px;">
					<view class="action">
						<view class="text-green" @click="onDialogClose" style="font-weight: bold;font-size: 16px;"
						 v-if="dialog.cancelBtn">取消</view>
						<!-- v-if="dialog.cancelBtn" -->
						<view 
						style="font-weight: bold;margin-left: 30px;font-size: 16px;"
						@click="onDialogConfirm">{{dialog.confirmButtonText}}</view>

					</view>
				</view>
			</view>
		</view>
	</view>

</template>

<script>
	import api from '../../utils/api.js'
	export default {
		data() {
			return {
				list: [{
					"id": 1,
					"type_name": "\u79fb\u52a8",
					"type_isp": "10086",
					"type_where": "huafei",
					"billcases": [{
						"id": 1,
						"case_name": "\u5168\u56fd\u79fb\u52a8\u6162\u5145\u8bdd\u8d39",
						"short_desc": "\u5168\u56fd\u79fb\u52a8\u6162\u5145\u8bdd\u8d39\uff0872\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u6025\u5355\u52ff\u62cd\uff09",
						"desc_content": "<p>\u5168\u56fd\u79fb\u52a8\u8bdd\u8d39\u6162\u5145\u4ecb\u7ecd\uff1a <br>\u3010\u5145\u503c\u5bf9\u8c61\u3011\u5168\u56fd\u79fb\u52a8\u7528\u6237\u90fd\u53ef\u5145\u503c<br>\u3010\u6709\u6548\u671f\u9650\u3011\u8bdd\u8d39\u5230\u5e10\u65e0\u6709\u6548\u671f\uff0c\u53ef\u4efb\u610f\u4f7f\u7528<br>\u3010\u4f7f\u7528\u8303\u56f4\u3011\u53ef\u4ee5\u7528\u4e8e\u6263\u6708\u79df\u3001\u6263\u8bdd\u8d39\u3001\u5957\u9910\u8d39\u7b49<br>\u3010\u5230\u8d26\u65b9\u5f0f\u3011\u53ef\u80fd\u4f1a\u88ab\u62c6\u5206\u621030  50 100 200\u7684\u9762\u503c\u968f\u673a\u5230\u8d26\u3002  <br>\u3010\u5230\u8d26\u65f6\u95f4\u3011\u4e0b\u5355\u540e72\u5c0f\u65f6\u5185\u5230\u9f50\uff0c\u6025\u5355\u52ff\u62cd  <br>\u3010\u67e5\u8be2\u65b9\u5f0f\u3011\u5b98\u65b9\u53ef\u67e5\uff0c\u6b63\u5e38\u6709\u77ed\u4fe1\u63d0\u9192   <br>\u3010\u6ce8\u610f\u4e8b\u9879\u3011\u643a\u53f7\u8f6c\u7f51\/\u865a\u62df\u8fd0\u8425\u5546\u53f7\u7801\u65e0\u6cd5\u5145\u503c\u3002\u672c\u4ea7\u54c1\u4e0d\u63d0\u4f9b\u53d1\u7968\u3002\u5145\u9519\u53f7\u7801\u65e0\u6cd5\u9000\u6b3e\uff0c\u8bf7\u6ce8\u6838\u5b9e\u53f7\u7801\u540e\u518d\u4e0b\u5355\uff01<\/p>",
						"isp": "10086",
						"stop_sale": 0,
						"stop_sale_tips": null,
						"bill_type_id": 1,
						"bills": [{
							"id": 1,
							"package": "30\u5143",
							"is_hot": 1,
							"order_tips": "[\u6e29\u99a8\u63d0\u793a\uff1a72\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u505c\u673a\u6b20\u8d39\u53ef\u4ee5\u5145\u503c]",
							"yh_tips": "72\u5c0f\u65f6\u5185\u5230\u8d26",
							"stop_sale": 0,
							"stop_sale_tips": null,
							"itemId": "1000",
							"itemSalesPrice": "27450",
							"itemFacePrice": "30000",
							"app_sale_profit": "1.00",
							"user_def_sale_profit": "1.00",
							"min_sale_profit": "0.50",
							"max_sale_profit": "1.50",
							"bill_case_id": 1,
							"created_at": null,
							"updated_at": "2021-05-05 13:20:10",
							"sale_price": "28.45\u5143"
						}, {
							"id": 2,
							"package": "50\u5143",
							"is_hot": 1,
							"order_tips": "[\u6e29\u99a8\u63d0\u793a\uff1a72\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u505c\u673a\u6b20\u8d39\u53ef\u4ee5\u5145\u503c]",
							"yh_tips": "72\u5c0f\u65f6\u5185\u5230\u8d26",
							"stop_sale": 0,
							"stop_sale_tips": "",
							"itemId": "1001",
							"itemSalesPrice": "49300",
							"itemFacePrice": "50000",
							"app_sale_profit": "1",
							"user_def_sale_profit": "1",
							"min_sale_profit": "0.5",
							"max_sale_profit": "1",
							"bill_case_id": 1,
							"created_at": null,
							"updated_at": null,
							"sale_price": "50.30\u5143"
						}, {
							"id": 3,
							"package": "100\u5143",
							"is_hot": 1,
							"order_tips": "[\u6e29\u99a8\u63d0\u793a\uff1a72\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u505c\u673a\u6b20\u8d39\u53ef\u4ee5\u5145\u503c]",
							"yh_tips": "72\u5c0f\u65f6\u5185\u5230\u8d26",
							"stop_sale": 0,
							"stop_sale_tips": "",
							"itemId": "1001",
							"itemSalesPrice": "49300",
							"itemFacePrice": "50000",
							"app_sale_profit": "1",
							"user_def_sale_profit": "1",
							"min_sale_profit": "0.5",
							"max_sale_profit": "1",
							"bill_case_id": 1,
							"created_at": null,
							"updated_at": null,
							"sale_price": "50.30\u5143"
						}, {
							"id": 4,
							"package": "200\u5143",
							"is_hot": 1,
							"order_tips": "[\u6e29\u99a8\u63d0\u793a\uff1a72\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u505c\u673a\u6b20\u8d39\u53ef\u4ee5\u5145\u503c]",
							"yh_tips": "72\u5c0f\u65f6\u5185\u5230\u8d26",
							"stop_sale": 0,
							"stop_sale_tips": "",
							"itemId": "1001",
							"itemSalesPrice": "49300",
							"itemFacePrice": "50000",
							"app_sale_profit": "1",
							"user_def_sale_profit": "1",
							"min_sale_profit": "0.5",
							"max_sale_profit": "1",
							"bill_case_id": 1,
							"created_at": null,
							"updated_at": null,
							"sale_price": "50.30\u5143"
						}]
					}, {
						"id": 2,
						"case_name": "\u79fb\u52a8\u5feb\u5145\uff08\u5230\u8d26\u5feb\uff09",
						"short_desc": "\u5168\u56fd\u79fb\u52a8\u8bdd\u8d39\u5feb\u5145",
						"desc_content": "<p>\u3010\u5145\u503c\u5bf9\u8c61\u3011\u6240\u6709\u7528\u6237<br>\u3010\u8bdd\u8d39\u6027\u8d28\u3011\u5c5e\u4e8e\u5feb\u5145\u8bdd\u8d39 <br>\u3010\u4f7f\u7528\u8303\u56f4\u3011\u53ef\u4ee5\u7528\u4e8e\u6263\u57fa\u672c\u6708\u79df\u3001\u6263\u8bdd\u8d39\u3001\u5957\u9910\u8d39\u7b49, <\/p><p>\u3010\u5230\u5e10\u65f6\u95f4\u30110-30\u5206\u949f\u5185\u5230\u8d26<\/p><p>\u3010\u67e5\u8be2\u65b9\u5f0f\u3011\u81f4\u7535\u8fd0\u8425\u5546\u79fb\u52a810086\/\u7535\u4fe110000\/\u8054\u901a10010\u53ef\u67e5\uff0c\u6b63\u5e38\u6709\u77ed\u4fe1\u63d0\u9192<br>\u3010\u6ce8\u610f\u4e8b\u9879\u3011\u643a\u53f7\u8f6c\u7f51\/\u865a\u62df\u8fd0\u8425\u5546\u53f7\u7801\u65e0\u6cd5\u5145\u503c\u3002\u5145\u9519\u53f7\u7801\u65e0\u6cd5\u9000\u6b3e\uff0c\u8bf7\u6ce8\u6838\u5b9e\u53f7\u7801\u540e\u518d\u4e0b\u5355\uff01\u4e2a\u522b\u5ef6\u8fdf\u521924\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u672c\u4ea7\u54c1\u6682\u4e0d\u63d0\u4f9b\u53d1\u7968<\/p><p><br><\/p>",
						"isp": "10086",
						"stop_sale": 0,
						"stop_sale_tips": "",
						"bill_type_id": 1,
						"bills": [{
							"id": 5,
							"package": "50\u5143",
							"is_hot": 1,
							"order_tips": "[\u6e29\u99a8\u63d0\u793a\uff1a72\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u505c\u673a\u6b20\u8d39\u53ef\u4ee5\u5145\u503c]",
							"yh_tips": "72\u5c0f\u65f6\u5185\u5230\u8d26",
							"stop_sale": 0,
							"stop_sale_tips": null,
							"itemId": "1001",
							"itemSalesPrice": "49300",
							"itemFacePrice": "50000",
							"app_sale_profit": "0.5",
							"user_def_sale_profit": "0.15",
							"min_sale_profit": "0.1",
							"max_sale_profit": "0.2",
							"bill_case_id": 2,
							"created_at": null,
							"updated_at": "2021-05-05 12:10:47",
							"sale_price": "49.80\u5143"
						}, {
							"id": 6,
							"package": "100\u5143",
							"is_hot": 1,
							"order_tips": "[\u6e29\u99a8\u63d0\u793a\uff1a72\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u505c\u673a\u6b20\u8d39\u53ef\u4ee5\u5145\u503c]",
							"yh_tips": "72\u5c0f\u65f6\u5185\u5230\u8d26",
							"stop_sale": 0,
							"stop_sale_tips": "",
							"itemId": "1001",
							"itemSalesPrice": "49300",
							"itemFacePrice": "50000",
							"app_sale_profit": "1",
							"user_def_sale_profit": "1",
							"min_sale_profit": "0.5",
							"max_sale_profit": "1",
							"bill_case_id": 2,
							"created_at": null,
							"updated_at": null,
							"sale_price": "50.30\u5143"
						}, {
							"id": 7,
							"package": "200\u5143",
							"is_hot": 1,
							"order_tips": "[\u6e29\u99a8\u63d0\u793a\uff1a72\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u505c\u673a\u6b20\u8d39\u53ef\u4ee5\u5145\u503c]",
							"yh_tips": "72\u5c0f\u65f6\u5185\u5230\u8d26",
							"stop_sale": 0,
							"stop_sale_tips": "",
							"itemId": "1001",
							"itemSalesPrice": "49300",
							"itemFacePrice": "50000",
							"app_sale_profit": "1",
							"user_def_sale_profit": "1",
							"min_sale_profit": "0.5",
							"max_sale_profit": "1",
							"bill_case_id": 2,
							"created_at": null,
							"updated_at": null,
							"sale_price": "50.30\u5143"
						}]
					}]
				}, {
					"id": 2,
					"type_name": "\u7535\u4fe1",
					"type_isp": "10000",
					"type_where": "huafei",
					"billcases": [{
						"id": 3,
						"case_name": "\u5168\u56fd\u7535\u4fe1\u6162\u5145\u8bdd\u8d39",
						"short_desc": "\u5168\u56fd\u7535\u4fe1\u6162\u5145\u8bdd\u8d39\uff0872\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u6025\u5355\u52ff\u62cd\uff09",
						"desc_content": "<p>\u5168\u56fd\u7535\u4fe1\u8bdd\u8d39\u6162\u5145\u4ecb\u7ecd\uff1a <br>\u3010\u5145\u503c\u5bf9\u8c61\u3011\u5168\u56fd\u7535\u4fe1\u7528\u6237<br>\u3010\u6709\u6548\u671f\u9650\u3011\u8bdd\u8d39\u5230\u5e10\u65e0\u6709\u6548\u671f\uff0c\u53ef\u4efb\u610f\u4f7f\u7528<br>\u3010\u4f7f\u7528\u8303\u56f4\u3011\u53ef\u4ee5\u7528\u4e8e\u6263\u6708\u79df\u3001\u6263\u8bdd\u8d39\u3001\u5957\u9910\u8d39\u7b49<br>\u3010\u5230\u8d26\u65b9\u5f0f\u3011\u53ef\u80fd\u4f1a\u88ab\u62c6\u5206\u621030  50 100 200\u7684\u9762\u503c\u968f\u673a\u5230\u8d26\u3002  <br>\u3010\u5230\u8d26\u65f6\u95f4\u3011\u4e0b\u5355\u540e72\u5c0f\u65f6\u5185\u5230\u9f50\uff0c\u6025\u5355\u52ff\u62cd<br>\u3010\u67e5\u8be2\u65b9\u5f0f\u301110000\u5b98\u65b9\u53ef\u67e5\uff0c\u6b63\u5e38\u6709\u77ed\u4fe1\u63d0\u9192  <br>\u3010\u6ce8\u610f\u4e8b\u9879\u3011\u643a\u53f7\u8f6c\u7f51\/\u865a\u62df\u8fd0\u8425\u5546\u53f7\u7801\u65e0\u6cd5\u5145\u503c\u3002\u672c\u4ea7\u54c1\u4e0d\u63d0\u4f9b\u53d1\u7968\u3002\u5145\u9519\u53f7\u7801\u65e0\u6cd5\u9000\u6b3e\uff0c\u8bf7\u6ce8\u6838\u5b9e\u53f7\u7801\u540e\u518d\u4e0b\u5355\uff01<\/p>",
						"isp": "10000",
						"stop_sale": 0,
						"stop_sale_tips": null,
						"bill_type_id": 2,
						"bills": [{
							"id": 8,
							"package": "30\u5143",
							"is_hot": 1,
							"order_tips": "[\u6e29\u99a8\u63d0\u793a\uff1a72\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u505c\u673a\u6b20\u8d39\u53ef\u4ee5\u5145\u503c]",
							"yh_tips": "72\u5c0f\u65f6\u5185\u5230\u8d26",
							"stop_sale": 0,
							"stop_sale_tips": "",
							"itemId": "1000",
							"itemSalesPrice": "27300",
							"itemFacePrice": "30000",
							"app_sale_profit": "1",
							"user_def_sale_profit": "1",
							"min_sale_profit": "0.5",
							"max_sale_profit": "1",
							"bill_case_id": 3,
							"created_at": null,
							"updated_at": null,
							"sale_price": "28.30\u5143"
						}, {
							"id": 9,
							"package": "50\u5143",
							"is_hot": 1,
							"order_tips": "[\u6e29\u99a8\u63d0\u793a\uff1a72\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u505c\u673a\u6b20\u8d39\u53ef\u4ee5\u5145\u503c]",
							"yh_tips": "72\u5c0f\u65f6\u5185\u5230\u8d26",
							"stop_sale": 0,
							"stop_sale_tips": "",
							"itemId": "1001",
							"itemSalesPrice": "49300",
							"itemFacePrice": "50000",
							"app_sale_profit": "1",
							"user_def_sale_profit": "1",
							"min_sale_profit": "0.5",
							"max_sale_profit": "1",
							"bill_case_id": 3,
							"created_at": null,
							"updated_at": null,
							"sale_price": "50.30\u5143"
						}, {
							"id": 10,
							"package": "100\u5143",
							"is_hot": 1,
							"order_tips": "[\u6e29\u99a8\u63d0\u793a\uff1a72\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u505c\u673a\u6b20\u8d39\u53ef\u4ee5\u5145\u503c]",
							"yh_tips": "72\u5c0f\u65f6\u5185\u5230\u8d26",
							"stop_sale": 0,
							"stop_sale_tips": "",
							"itemId": "1001",
							"itemSalesPrice": "49300",
							"itemFacePrice": "50000",
							"app_sale_profit": "1",
							"user_def_sale_profit": "1",
							"min_sale_profit": "0.5",
							"max_sale_profit": "1",
							"bill_case_id": 3,
							"created_at": null,
							"updated_at": null,
							"sale_price": "50.30\u5143"
						}, {
							"id": 11,
							"package": "200\u5143",
							"is_hot": 1,
							"order_tips": "[\u6e29\u99a8\u63d0\u793a\uff1a72\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u505c\u673a\u6b20\u8d39\u53ef\u4ee5\u5145\u503c]",
							"yh_tips": "72\u5c0f\u65f6\u5185\u5230\u8d26",
							"stop_sale": 0,
							"stop_sale_tips": "",
							"itemId": "1001",
							"itemSalesPrice": "49300",
							"itemFacePrice": "50000",
							"app_sale_profit": "1",
							"user_def_sale_profit": "1",
							"min_sale_profit": "0.5",
							"max_sale_profit": "1",
							"bill_case_id": 3,
							"created_at": null,
							"updated_at": null,
							"sale_price": "50.30\u5143"
						}]
					}, {
						"id": 4,
						"case_name": "\u7535\u4fe1\u5feb\u5145\uff08\u5230\u8d26\u5feb\uff09",
						"short_desc": "\u5168\u56fd\u7535\u4fe1\u8bdd\u8d39\u5feb\u5145",
						"desc_content": "<p>\u3010\u5145\u503c\u5bf9\u8c61\u3011\u6240\u6709\u7528\u6237<br>\u3010\u8bdd\u8d39\u6027\u8d28\u3011\u5c5e\u4e8e\u5feb\u5145\u8bdd\u8d39 <br>\u3010\u4f7f\u7528\u8303\u56f4\u3011\u53ef\u4ee5\u7528\u4e8e\u6263\u57fa\u672c\u6708\u79df\u3001\u6263\u8bdd\u8d39\u3001\u5957\u9910\u8d39\u7b49, <\/p><p>\u3010\u5230\u5e10\u65f6\u95f4\u30110-30\u5206\u949f\u5185\u5230\u8d26<\/p><p>\u3010\u67e5\u8be2\u65b9\u5f0f\u3011\u81f4\u7535\u8fd0\u8425\u5546\u79fb\u52a810086\/\u7535\u4fe110000\/\u8054\u901a10010\u53ef\u67e5\uff0c\u6b63\u5e38\u6709\u77ed\u4fe1\u63d0\u9192<br>\u3010\u6ce8\u610f\u4e8b\u9879\u3011\u643a\u53f7\u8f6c\u7f51\/\u865a\u62df\u8fd0\u8425\u5546\u53f7\u7801\u65e0\u6cd5\u5145\u503c\u3002\u5145\u9519\u53f7\u7801\u65e0\u6cd5\u9000\u6b3e\uff0c\u8bf7\u6ce8\u6838\u5b9e\u53f7\u7801\u540e\u518d\u4e0b\u5355\uff01\u4e2a\u522b\u5ef6\u8fdf\u521924\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u672c\u4ea7\u54c1\u6682\u4e0d\u63d0\u4f9b\u53d1\u7968<\/p><p><br><\/p>",
						"isp": "10000",
						"stop_sale": 0,
						"stop_sale_tips": "",
						"bill_type_id": 2,
						"bills": [{
							"id": 12,
							"package": "50\u5143",
							"is_hot": 1,
							"order_tips": "[\u6e29\u99a8\u63d0\u793a\uff1a72\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u505c\u673a\u6b20\u8d39\u53ef\u4ee5\u5145\u503c]",
							"yh_tips": "72\u5c0f\u65f6\u5185\u5230\u8d26",
							"stop_sale": 0,
							"stop_sale_tips": "",
							"itemId": "1001",
							"itemSalesPrice": "49300",
							"itemFacePrice": "50000",
							"app_sale_profit": "1",
							"user_def_sale_profit": "1",
							"min_sale_profit": "0.5",
							"max_sale_profit": "1",
							"bill_case_id": 4,
							"created_at": null,
							"updated_at": null,
							"sale_price": "50.30\u5143"
						}, {
							"id": 13,
							"package": "100\u5143",
							"is_hot": 1,
							"order_tips": "[\u6e29\u99a8\u63d0\u793a\uff1a72\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u505c\u673a\u6b20\u8d39\u53ef\u4ee5\u5145\u503c]",
							"yh_tips": "72\u5c0f\u65f6\u5185\u5230\u8d26",
							"stop_sale": 0,
							"stop_sale_tips": "",
							"itemId": "1001",
							"itemSalesPrice": "49300",
							"itemFacePrice": "50000",
							"app_sale_profit": "1",
							"user_def_sale_profit": "1",
							"min_sale_profit": "0.5",
							"max_sale_profit": "1",
							"bill_case_id": 4,
							"created_at": null,
							"updated_at": null,
							"sale_price": "50.30\u5143"
						}, {
							"id": 14,
							"package": "200\u5143",
							"is_hot": 1,
							"order_tips": "[\u6e29\u99a8\u63d0\u793a\uff1a72\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u505c\u673a\u6b20\u8d39\u53ef\u4ee5\u5145\u503c]",
							"yh_tips": "72\u5c0f\u65f6\u5185\u5230\u8d26",
							"stop_sale": 0,
							"stop_sale_tips": "",
							"itemId": "1001",
							"itemSalesPrice": "49300",
							"itemFacePrice": "50000",
							"app_sale_profit": "1",
							"user_def_sale_profit": "1",
							"min_sale_profit": "0.5",
							"max_sale_profit": "1",
							"bill_case_id": 4,
							"created_at": null,
							"updated_at": null,
							"sale_price": "50.30\u5143"
						}]
					}]
				}, {
					"id": 3,
					"type_name": "\u8054\u901a",
					"type_isp": "10010",
					"type_where": "huafei",
					"billcases": [{
						"id": 5,
						"case_name": "\u5168\u56fd\u8054\u901a\u6162\u5145\u8bdd\u8d39",
						"short_desc": "\u5168\u56fd\u8054\u901a\u6162\u5145\u8bdd\u8d39\uff0872\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u6025\u5355\u52ff\u62cd\uff09",
						"desc_content": "<p>\u3010\u5145\u503c\u5bf9\u8c61\u3011\u6240\u6709\u7528\u6237<br>\u3010\u8bdd\u8d39\u6027\u8d28\u3011\u5c5e\u4e8e\u5feb\u5145\u8bdd\u8d39 <br>\u3010\u4f7f\u7528\u8303\u56f4\u3011\u53ef\u4ee5\u7528\u4e8e\u6263\u57fa\u672c\u6708\u79df\u3001\u6263\u8bdd\u8d39\u3001\u5957\u9910\u8d39\u7b49, <\/p><p>\u3010\u5230\u5e10\u65f6\u95f4\u30110-30\u5206\u949f\u5185\u5230\u8d26<\/p><p>\u3010\u67e5\u8be2\u65b9\u5f0f\u3011\u81f4\u7535\u8fd0\u8425\u5546\u79fb\u52a810086\/\u7535\u4fe110000\/\u8054\u901a10010\u53ef\u67e5\uff0c\u6b63\u5e38\u6709\u77ed\u4fe1\u63d0\u9192<br>\u3010\u6ce8\u610f\u4e8b\u9879\u3011\u643a\u53f7\u8f6c\u7f51\/\u865a\u62df\u8fd0\u8425\u5546\u53f7\u7801\u65e0\u6cd5\u5145\u503c\u3002\u5145\u9519\u53f7\u7801\u65e0\u6cd5\u9000\u6b3e\uff0c\u8bf7\u6ce8\u6838\u5b9e\u53f7\u7801\u540e\u518d\u4e0b\u5355\uff01\u4e2a\u522b\u5ef6\u8fdf\u521924\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u672c\u4ea7\u54c1\u6682\u4e0d\u63d0\u4f9b\u53d1\u7968<\/p><p><br><\/p>",
						"isp": "10010",
						"stop_sale": 0,
						"stop_sale_tips": null,
						"bill_type_id": 3,
						"bills": [{
							"id": 15,
							"package": "30\u5143",
							"is_hot": 1,
							"order_tips": "[\u6e29\u99a8\u63d0\u793a\uff1a72\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u505c\u673a\u6b20\u8d39\u53ef\u4ee5\u5145\u503c]",
							"yh_tips": "72\u5c0f\u65f6\u5185\u5230\u8d26",
							"stop_sale": 0,
							"stop_sale_tips": null,
							"itemId": "1000",
							"itemSalesPrice": "27300",
							"itemFacePrice": "30000",
							"app_sale_profit": "1",
							"user_def_sale_profit": "1",
							"min_sale_profit": "0.5",
							"max_sale_profit": "1",
							"bill_case_id": 5,
							"created_at": null,
							"updated_at": "2021-05-06 09:47:36",
							"sale_price": "28.30\u5143"
						}, {
							"id": 16,
							"package": "50\u5143",
							"is_hot": 1,
							"order_tips": "[\u6e29\u99a8\u63d0\u793a\uff1a72\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u505c\u673a\u6b20\u8d39\u53ef\u4ee5\u5145\u503c]",
							"yh_tips": "72\u5c0f\u65f6\u5185\u5230\u8d26",
							"stop_sale": 0,
							"stop_sale_tips": "",
							"itemId": "1001",
							"itemSalesPrice": "49300",
							"itemFacePrice": "50000",
							"app_sale_profit": "1",
							"user_def_sale_profit": "1",
							"min_sale_profit": "0.5",
							"max_sale_profit": "1",
							"bill_case_id": 5,
							"created_at": null,
							"updated_at": null,
							"sale_price": "50.30\u5143"
						}, {
							"id": 17,
							"package": "100\u5143",
							"is_hot": 1,
							"order_tips": "[\u6e29\u99a8\u63d0\u793a\uff1a72\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u505c\u673a\u6b20\u8d39\u53ef\u4ee5\u5145\u503c]",
							"yh_tips": "72\u5c0f\u65f6\u5185\u5230\u8d26",
							"stop_sale": 0,
							"stop_sale_tips": "",
							"itemId": "1001",
							"itemSalesPrice": "49300",
							"itemFacePrice": "50000",
							"app_sale_profit": "1",
							"user_def_sale_profit": "1",
							"min_sale_profit": "0.5",
							"max_sale_profit": "1",
							"bill_case_id": 5,
							"created_at": null,
							"updated_at": null,
							"sale_price": "50.30\u5143"
						}, {
							"id": 18,
							"package": "200\u5143",
							"is_hot": 1,
							"order_tips": "[\u6e29\u99a8\u63d0\u793a\uff1a72\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u505c\u673a\u6b20\u8d39\u53ef\u4ee5\u5145\u503c]",
							"yh_tips": "72\u5c0f\u65f6\u5185\u5230\u8d26",
							"stop_sale": 0,
							"stop_sale_tips": "",
							"itemId": "1001",
							"itemSalesPrice": "49300",
							"itemFacePrice": "50000",
							"app_sale_profit": "1",
							"user_def_sale_profit": "1",
							"min_sale_profit": "0.5",
							"max_sale_profit": "1",
							"bill_case_id": 5,
							"created_at": null,
							"updated_at": null,
							"sale_price": "50.30\u5143"
						}]
					}, {
						"id": 6,
						"case_name": "\u8054\u901a\u5feb\u5145\uff08\u5230\u8d26\u5feb\uff09",
						"short_desc": "\u5168\u56fd\u8054\u901a\u8bdd\u8d39\u5feb\u5145",
						"desc_content": "<p>\u3010\u5145\u503c\u5bf9\u8c61\u3011\u6240\u6709\u7528\u6237<br>\u3010\u8bdd\u8d39\u6027\u8d28\u3011\u5c5e\u4e8e\u5feb\u5145\u8bdd\u8d39 <br>\u3010\u4f7f\u7528\u8303\u56f4\u3011\u53ef\u4ee5\u7528\u4e8e\u6263\u57fa\u672c\u6708\u79df\u3001\u6263\u8bdd\u8d39\u3001\u5957\u9910\u8d39\u7b49, <\/p><p>\u3010\u5230\u5e10\u65f6\u95f4\u30110-30\u5206\u949f\u5185\u5230\u8d26<\/p><p>\u3010\u67e5\u8be2\u65b9\u5f0f\u3011\u81f4\u7535\u8fd0\u8425\u5546\u79fb\u52a810086\/\u7535\u4fe110000\/\u8054\u901a10010\u53ef\u67e5\uff0c\u6b63\u5e38\u6709\u77ed\u4fe1\u63d0\u9192<br>\u3010\u6ce8\u610f\u4e8b\u9879\u3011\u643a\u53f7\u8f6c\u7f51\/\u865a\u62df\u8fd0\u8425\u5546\u53f7\u7801\u65e0\u6cd5\u5145\u503c\u3002\u5145\u9519\u53f7\u7801\u65e0\u6cd5\u9000\u6b3e\uff0c\u8bf7\u6ce8\u6838\u5b9e\u53f7\u7801\u540e\u518d\u4e0b\u5355\uff01\u4e2a\u522b\u5ef6\u8fdf\u521924\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u672c\u4ea7\u54c1\u6682\u4e0d\u63d0\u4f9b\u53d1\u7968<\/p><p><br><\/p>",
						"isp": "10010",
						"stop_sale": 0,
						"stop_sale_tips": "",
						"bill_type_id": 3,
						"bills": [{
							"id": 19,
							"package": "50\u5143",
							"is_hot": 1,
							"order_tips": "[\u6e29\u99a8\u63d0\u793a\uff1a72\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u505c\u673a\u6b20\u8d39\u53ef\u4ee5\u5145\u503c]",
							"yh_tips": "72\u5c0f\u65f6\u5185\u5230\u8d26",
							"stop_sale": 0,
							"stop_sale_tips": "",
							"itemId": "1001",
							"itemSalesPrice": "49300",
							"itemFacePrice": "50000",
							"app_sale_profit": "1",
							"user_def_sale_profit": "1",
							"min_sale_profit": "0.5",
							"max_sale_profit": "1",
							"bill_case_id": 6,
							"created_at": null,
							"updated_at": null,
							"sale_price": "50.30\u5143"
						}, {
							"id": 20,
							"package": "100\u5143",
							"is_hot": 1,
							"order_tips": "[\u6e29\u99a8\u63d0\u793a\uff1a72\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u505c\u673a\u6b20\u8d39\u53ef\u4ee5\u5145\u503c]",
							"yh_tips": "72\u5c0f\u65f6\u5185\u5230\u8d26",
							"stop_sale": 0,
							"stop_sale_tips": "",
							"itemId": "1001",
							"itemSalesPrice": "49300",
							"itemFacePrice": "50000",
							"app_sale_profit": "1",
							"user_def_sale_profit": "1",
							"min_sale_profit": "0.5",
							"max_sale_profit": "1",
							"bill_case_id": 6,
							"created_at": null,
							"updated_at": null,
							"sale_price": "50.30\u5143"
						}, {
							"id": 21,
							"package": "200\u5143",
							"is_hot": 1,
							"order_tips": "[\u6e29\u99a8\u63d0\u793a\uff1a72\u5c0f\u65f6\u5185\u5230\u8d26\uff0c\u505c\u673a\u6b20\u8d39\u53ef\u4ee5\u5145\u503c]",
							"yh_tips": "72\u5c0f\u65f6\u5185\u5230\u8d26",
							"stop_sale": 0,
							"stop_sale_tips": "",
							"itemId": "1001",
							"itemSalesPrice": "49300",
							"itemFacePrice": "50000",
							"app_sale_profit": "1",
							"user_def_sale_profit": "1",
							"min_sale_profit": "0.5",
							"max_sale_profit": "1",
							"bill_case_id": 6,
							"created_at": null,
							"updated_at": null,
							"sale_price": "50.30\u5143"
						}]
					}]
				}],
				swiperList: [{
					id: 0,
					type: 'image',
					url: 'https://ossweb-img.qq.com/images/lol/web201310/skin/big84000.jpg'
				}, {
					id: 1,
					type: 'image',
					url: 'https://ossweb-img.qq.com/images/lol/web201310/skin/big37006.jpg',
				}, {
					id: 2,
					type: 'image',
					url: 'https://ossweb-img.qq.com/images/lol/web201310/skin/big39000.jpg'
				}, {
					id: 3,
					type: 'image',
					url: 'https://ossweb-img.qq.com/images/lol/web201310/skin/big10001.jpg'
				}, {
					id: 4,
					type: 'image',
					url: 'https://ossweb-img.qq.com/images/lol/web201310/skin/big25011.jpg'
				}, {
					id: 5,
					type: 'image',
					url: 'https://ossweb-img.qq.com/images/lol/web201310/skin/big21016.jpg'
				}, {
					id: 6,
					type: 'image',
					url: 'https://ossweb-img.qq.com/images/lol/web201310/skin/big99008.jpg'
				}],
				TabCur: 0,
				dialog: {
					show: false,
					content: '',
					cancelBtn: false,
					title: '',
					confirmButtonText: '',
				},
				input:{
				  phone:'',
				  focus:true,
				  autoFocus:false,
				},
				tempList:[],
				isp:false,
				orderData:false,
			};
		},
		onLoad() {
			this.init(false)
			this.tempList = this.list

		},
		onReady() {
			uni.hideLoading()
		},
		methods: {
			init(data){
				api.getDataList('/Bill/all',data, res => {
					console.log(this.list)
					this.list = res.data;
					this.TabCur = 0;
				})
			},
			inputClear(){
				this.input = {
					phone:'',
					focus:true,
					autoFocus:false,
				}
				this.list = this.tempList;
				this.isp = false;
			  },
			  onInput(event){
				  this.input.phone = event.detail.value
			    if(event.detail.value.length === 11){
					this.input.focus = false
					this.input.autoFocus = false
					api.getDataList('/Bill/mobile',{mobile:event.detail.value}, res => {
						this.list = res.data.list;
						this.TabCur = 0;
						this.isp = res.data.ips;
					})
			    }else{
			      this.list = this.tempList
				  this.isp = false;
			    }
			  },
			xiangqing(detail) {
				this.dialog = {
					'show': true,
					'content': detail.target.dataset.desc,
					'cancelBtn': false,
					'title': '产品详情',
					'confirmButtonText': '确定'
				};
			},
			onDialogClose() {
				this.dialog.show = false;
			},
			onDialogConfirm(event) {
				if (!this.dialog.cancelBtn) {
					this.onDialogClose();
					return;
				}
				console.log('OK')
			},
			tabSelect(e) {
				this.TabCur = e.currentTarget.dataset.id;
			},
			onSellPut(event){
			    if(this.input.phone == null || this.input.phone.length != 11){
			      this.input.focus = true
			      this.input.autoFocus = true
			      return;
			    }
			    let st_obj = event.currentTarget.dataset;
			    st_obj.desc = st_obj.desc.replace(/\[/g,'<i style="color: red;font-style:normal;">');
			    st_obj.desc = st_obj.desc.replace(/\]/g,'</i>');
			    let p_sty = 'style="display: flex;justify-content: space-between;margin:2px 0;"'
			    let t_sty = 'style="width:60px;color:#666;"';
			    let s_sty='style="text-align:right;"';
			    var str = `
			    <p ${p_sty}><span ${t_sty}>充值号码</span><span ${s_sty}>${this.input.phone}</span></p>
			    <p ${p_sty}><span ${t_sty}>套餐</span><span ${s_sty}>${st_obj.cc}</span></p>
			    <p ${p_sty}><span ${t_sty}>预计</span><span ${s_sty}>${st_obj.yh_tips}</span></p>
			    
			    <p ${p_sty}><span ${t_sty}>面值</span><span ${s_sty}>${st_obj.package}</span></p>
			    <p ${p_sty}><span ${t_sty}>售价</span><span ${s_sty}>${st_obj.price}</span></p>
			    <p style="margin-top:5px;">${st_obj.desc}</span></p>
			    `;
				this.dialog = {
					'show': true,
					'content': str,
					'cancelBtn': true,
					'title': '产品详情',
					'confirmButtonText': '确定'
				};
				this.orderData = {
					'tc':st_obj.cc,
					'yh_tips':st_obj.yh_tips,
					'package':st_obj.package,
					'price':st_obj.price,
					'desc':st_obj.desc,
					'flow_id':st_obj.flow_id,
					'id':st_obj.id,
				}
			  },
		},
	}
</script>

<style>
	.ui-content {
		width: 100%;
		margin-bottom: 20px;
	}
	.ui-isp::after{
		border: 0.5px solid currentColor!important;
	}
	.ui-title {
		display: flex;
		/* position: relative; */
		align-items: center;
		justify-content: space-between;
		min-height: 50px;
		background-color: #ffffff;
		color: #666666;
		font-size: 14px;
		padding: 0 10px;
	}

	.ui-info {
		color: #999;
	}

	.ui-items {
		display: flex;
		flex-wrap: wrap;
		padding: 0 10px;
	}

	.ui-item {
		width: 33.333%;
		font-size: 14px;
		margin-top: 5px;
		color: #1aad19;
	}

	.ui-cont {
		border: 1px solid #1aad19;
		box-sizing: border-box;
		border-radius: 5px;
		transform: scale(0.95);
		padding-bottom: 5px;

	}

	.text-red {
		color: red;
		text-decoration: line-through;
	}

	.ui-cont view {
		text-align: center;
	}

	.small-desc {
		color: white;
		padding: 1px;
		border-radius: 5px;
		border-bottom-left-radius: 0;
		border-top-right-radius: 0;
		background-color: #1aad19;
		/* line-height: 16px; */
		font-size: 14px;
		display: inline;
	}
</style>
