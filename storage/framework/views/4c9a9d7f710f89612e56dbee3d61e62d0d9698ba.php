<?php $__env->startSection('style'); ?>
<style>
    .ui-wx .item{
       margin-bottom:20px;
    }
    .ui-wx .item .el-form-item__content{
      display:flex;
     
    }
    .ui-wx .item .el-form-item__content .el-input{
      margin-right:10px;
    }
    .editorr .el-form-item__content{
      line-height:normal;
    }
</style>
<style>
.editor {
  line-height: normal !important;
  height: 500px;
}
.ql-snow .ql-tooltip[data-mode="link"]::before {
  content: "请输入链接地址:";
}
.ql-snow .ql-tooltip.ql-editing a.ql-action::after {
  border-right: 0px;
  content: "保存";
  padding-right: 0px;
}

.ql-snow .ql-tooltip[data-mode="video"]::before {
  content: "请输入视频地址:";
}

.ql-snow .ql-picker.ql-size .ql-picker-label::before,
.ql-snow .ql-picker.ql-size .ql-picker-item::before {
  content: "14px";
}
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="small"]::before,
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="small"]::before {
  content: "10px";
}
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="large"]::before,
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="large"]::before {
  content: "18px";
}
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="huge"]::before,
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="huge"]::before {
  content: "32px";
}

.ql-snow .ql-picker.ql-header .ql-picker-label::before,
.ql-snow .ql-picker.ql-header .ql-picker-item::before {
  content: "文本";
}
.ql-snow .ql-picker.ql-header .ql-picker-label[data-value="1"]::before,
.ql-snow .ql-picker.ql-header .ql-picker-item[data-value="1"]::before {
  content: "标题1";
}
.ql-snow .ql-picker.ql-header .ql-picker-label[data-value="2"]::before,
.ql-snow .ql-picker.ql-header .ql-picker-item[data-value="2"]::before {
  content: "标题2";
}
.ql-snow .ql-picker.ql-header .ql-picker-label[data-value="3"]::before,
.ql-snow .ql-picker.ql-header .ql-picker-item[data-value="3"]::before {
  content: "标题3";
}
.ql-snow .ql-picker.ql-header .ql-picker-label[data-value="4"]::before,
.ql-snow .ql-picker.ql-header .ql-picker-item[data-value="4"]::before {
  content: "标题4";
}
.ql-snow .ql-picker.ql-header .ql-picker-label[data-value="5"]::before,
.ql-snow .ql-picker.ql-header .ql-picker-item[data-value="5"]::before {
  content: "标题5";
}
.ql-snow .ql-picker.ql-header .ql-picker-label[data-value="6"]::before,
.ql-snow .ql-picker.ql-header .ql-picker-item[data-value="6"]::before {
  content: "标题6";
}

.ql-snow .ql-picker.ql-font .ql-picker-label::before,
.ql-snow .ql-picker.ql-font .ql-picker-item::before {
  content: "标准字体";
}
.ql-snow .ql-picker.ql-font .ql-picker-label[data-value="serif"]::before,
.ql-snow .ql-picker.ql-font .ql-picker-item[data-value="serif"]::before {
  content: "衬线字体";
}
.ql-snow .ql-picker.ql-font .ql-picker-label[data-value="monospace"]::before,
.ql-snow .ql-picker.ql-font .ql-picker-item[data-value="monospace"]::before {
  content: "等宽字体";
}
</style>
<link href="https://cdn.quilljs.com/1.3.4/quill.core.css" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.4/quill.snow.css" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.4/quill.bubble.css" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div id="container">
    <input type="file" ref='uploadDom' @change="getFile($event)" hidden accept=".png,.jpg,.jpeg">
    <el-tabs v-model="activeName" >
        <el-tab-pane label="分销设置" name="sell_form">
            <el-form label-position="top" :model="sellForm" ref="sellForm" :rules="rules" label-width="100px" >
              
              <el-form-item label="首页轮播图">
                <el-collapse accordion>
                  <el-collapse-item v-for="(item, index) in sellForm.bannerList">
                    <template slot="title">
                      <span>轮播 {{index+1}}</span><el-link type="danger" @click.stop="removeImgItem('sellForm','bannerList',item)" style="position: absolute;right: 35px;" >删除此项</el-link>
                    </template>
                    <div style="display: flex;align-items:center;" >
                      <el-link type="primary" @click="inputClick('sellForm','bannerList',index)" style="width: 180px;margin-right:10px;">上传图片</el-link>
                      <el-input  size="mini" style="margin-right: 10px;" v-model="item.src" placeholder="请输入图片地址"></el-input>
                      <el-input v-model="item.url" size="mini" placeholder="请输入链接地址"></el-input>
                    </div>
                  </el-collapse-item>
                </el-collapse>
                <el-button type="success" @click.prevent="addImgItem('sellForm','bannerList')"  size="small">增加一项</el-button>
              </el-form-item>
              <el-form-item label="首页公告">
                    <el-input v-model="sellForm.indexMsg" type="text" placeholder="请输入首页公告"></el-input>
              </el-form-item>
              <el-form-item label="汇总文字">
                    <el-input v-model="sellForm.hzText" type="textarea" placeholder="请输入首页汇总文字"></el-input>
              </el-form-item>
              <el-form-item label="汇总展示图片">
                  <div style="display: flex;align-items:center;" >
                      <el-link type="primary" @click="inputClick('sellForm','hzImg',-1)" style="width: 180px;margin-right:10px;">上传图片</el-link>
                      <el-input  size="mini" style="margin-right: 10px;" v-model="sellForm.hzImg" placeholder="请输入汇总展示图片"></el-input>
                    </div>              
              </el-form-item>
              <el-form-item label="汇总海报图片">
                  <div style="display: flex;align-items:center;" >
                      <el-link type="primary" @click="inputClick('sellForm','hzBanner',-1)" style="width: 180px;margin-right:10px;">上传图片</el-link>
                      <el-input  size="mini" style="margin-right: 10px;" v-model="sellForm.hzBanner" placeholder="请输入汇总海报图片"></el-input>
                    </div>              
              </el-form-item>
              <el-form-item label="默认卡号展示图片">
                  <div style="display: flex;align-items:center;" >
                      <el-link type="primary" @click="inputClick('sellForm','cardImg',-1)" style="width: 180px;margin-right:10px;">上传图片</el-link>
                      <el-input  size="mini" style="margin-right: 10px;" v-model="sellForm.cardImg" placeholder="请输入默认卡号展示图片"></el-input>
                    </div>              
              </el-form-item>
              <el-form-item label="默认卡号海报图片">
                  <div style="display: flex;align-items:center;" >
                      <el-link type="primary" @click="inputClick('sellForm','cardBanner',-1)" style="width: 180px;margin-right:10px;">上传图片</el-link>
                      <el-input  size="mini" style="margin-right: 10px;" v-model="sellForm.cardBanner" placeholder="请输入默认卡号海报图片"></el-input>
                    </div>              
              </el-form-item>
              <el-form-item label="分销介绍页面" class="editorr">
                    <quill-editor class='.editor' :options="editorOption" v-model="sellForm.jieshao_page"/>
              </el-form-item>
              <el-form-item label="分销咨询页面" class="editorr">
                    <quill-editor class='.editor' :options="editorOption" v-model="sellForm.zixun_page"/>
              </el-form-item>
              <el-form-item label="常见问题页面" class="editorr">
                    <quill-editor class='.editor' :options="editorOption" v-model="sellForm.wenti_page"/>
              </el-form-item>
              
              <el-form-item>
                    <el-button type="primary" @click="submitForm('sellForm')">立即提交</el-button>
                </el-form-item>
            </el-form>
        </el-tab-pane>
    </el-tabs>
</el-form>

<el-dialog
  title="提示"
  :visible.sync="tagTemp.dialogVisible"
  width="30%"
  :before-close="handleClose">
  <div>
      <el-form ref="form" label-position="top" :model="tagTemp.data" label-width="80px">
        <el-form-item label="分组名称">
            <el-input type="text" v-model="tagTemp.data.name"></el-input>
        </el-form-item>
        <el-form-item label="分组详细">
          <el-input type="textarea" v-model="tagTemp.data.desc"></el-input>
      </el-form-item>
    </el-form>
  </div>
  <span slot="footer" class="dialog-footer">
    <el-button @click="tagTemp.dialogVisible = false">取 消</el-button>
    <el-button type="primary" @click="addCaseGroup">确 定</el-button>
  </span>
</el-dialog>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<!-- Include the Quill library -->
<script src="https://cdn.quilljs.com/1.3.4/quill.js"></script>
<!-- Quill JS Vue -->
<script src="https://cdn.jsdelivr.net/npm/vue-quill-editor@3.0.6/dist/vue-quill-editor.js"></script>

<script type="text/javascript">
    Vue.use(VueQuillEditor)
    new Vue({
        el:"#app",
        data:{
            activeName: 'sell_form',
            sellForm :<?php echo $sellForm; ?>,
            tagTemp:{
              dialogVisible:false,
              pindex:0,
              cindex:0,
              data:{
                name:'',
                desc:''
              }
            },
            tempUpload: {
              index:0,
              imgPath:'',
              who:''
            },
            rules: {
              find_number: [
                { required: true, message: '查询数量必填', trigger: 'blur' },
              ]
          },
          editorOption: {
            //  富文本编辑器配置
            modules: {
              //工具栏定义的
              toolbar: [
                  ["bold", "italic", "underline", "strike"], // 加粗 斜体 下划线 删除线 -----['bold', 'italic', 'underline', 'strike']
                  ["blockquote", "code-block"], // 引用  代码块-----['blockquote', 'code-block']
                  [{ header: 1 }, { header: 2 }], // 1、2 级标题-----[{ header: 1 }, { header: 2 }]
                  [{ list: "ordered" }, { list: "bullet" }], // 有序、无序列表-----[{ list: 'ordered' }, { list: 'bullet' }]
                  [{ script: "sub" }, { script: "super" }], // 上标/下标-----[{ script: 'sub' }, { script: 'super' }]
                  [{ indent: "-1" }, { indent: "+1" }], // 缩进-----[{ indent: '-1' }, { indent: '+1' }]
                  [{ direction: "rtl" }], // 文本方向-----[{'direction': 'rtl'}]
                  [{ size: ["small", false, "large", "huge"] }], // 字体大小-----[{ size: ['small', false, 'large', 'huge'] }]
                  [{ header: [1, 2, 3, 4, 5, 6, false] }], // 标题-----[{ header: [1, 2, 3, 4, 5, 6, false] }]
                  [{ color: [] }, { background: [] }], // 字体颜色、字体背景颜色-----[{ color: [] }, { background: [] }]
                  [{ font: [] }], // 字体种类-----[{ font: [] }]
                  [{ align: [] }], // 对齐方式-----[{ align: [] }]
                  ["clean"], // 清除文本格式-----['clean']
                  ["image", "video", "link"] // 链接、图片、视频-----['link', 'image', 'video']
                ]
            },
            //主题
            theme: "snow",
            placeholder: "请输入正文"
          }
        },
        computed :{
          unChoseeCseList(){
            var _this = this;
            return function(item){
              for (let index = 0; index < _this.allCase.length; index++) {
                const element = _this.allCase[index];
                if(element.id === item.id){
                  let b = _this.getValues(item.items)
                  return _this.getUnChoseeValues(element.value,b);
                  break;
                }
              }
              return []
            }
          },
        },
        methods: {
          addCaseGroup(){
            if(this.tagTemp.data.name == null || this.tagTemp.data.name == '' ){
              this.$message.error('分组名称不能为空');return false;
            }
            if(this.tagTemp.edit){
              var d =this.wxForm.caseList[this.tagTemp.pindex].items[this.tagTemp.cindex];
              d.name = this.tagTemp.data.name
              d.desc = this.tagTemp.data.desc
            }else{
              this.wxForm.caseList[this.tagTemp.pindex].items.push({
                name:this.tagTemp.data.name,
                desc:this.tagTemp.data.desc,
                value:[]
              });
            }
            
            this.tagTemp.dialogVisible = false;
          },
          removeCaseGroup(index,ind){
            this.wxForm.caseList[index].items.splice(ind,1)
            // console.log(data)
          },
          handleTagClose(index,ind,i){
            this.wxForm.caseList[index].items[ind].value.splice(i,1)
          },
          handleAddTag(index,ind,item){
            this.wxForm.caseList[index].items[ind].value.push(item)
          },
           getValues(items){
              let arr = [];
              for (let index = 0; index < items.length; index++) {
                const element = items[index];
                arr = arr.concat(element.value)
              }
              return arr;
           },
           getUnChoseeValues(a,b){
             var arr = [];
             for (let index = 0; index < a.length; index++) {
               let element = a[index];
               let has = false;
               for (let aa = 0; aa < b.length; aa++) {
                 let ee = b[aa];
                 if(element.id === ee.id){
                   has = true;
                   break;
                 }
               }
               if(!has){
                 arr.push(element)
               }
               
             }
             return arr;
           },
           submitForm(formName){
                this.$refs[formName].validate((valid) => {
                if (valid) {
                    this.$axios.post('/Setting/index/'+formName,this[formName])
                } else {
                    return false;
                }
                });
           },
           addImgItem(tableName,itemName){
              this[tableName][itemName].push({
                src: '',
                url: '',
              });
           },
           removeImgItem(tableName,itemName,item){
             if(this[tableName][itemName].length == 1){
              this.$message({
                  type: 'error',
                  message: '至少保留一个'
              });return;
             }
             var index = this[tableName][itemName].indexOf(item)
              if (index !== -1) {
                this[tableName][itemName].splice(index, 1)
              }
           },
           getFile(event){
                var file = event.target.files;
                var imgName = file[0].name;
                this.tempUpload.imgPath = [];
                var idx = imgName.lastIndexOf(".");  
                if (idx != -1){
                    var ext = imgName.substr(idx+1).toUpperCase();   
                    ext = ext.toLowerCase( ); 
                    if (ext!='png' && ext!='jpg' && ext!='jpeg'){
                      this.$message({
                          type: 'wraing',
                          message: '请上传图片格式不正确'
                      });
                    }else{
                      this.tempUpload.imgPath = file[0];
                      this.uploadImgAction()
                    }   
                }
          },
          inputClick(tableName,itemName,index){
            this.tempUpload.index = index;
            this.tempUpload.tableName = tableName;
            this.tempUpload.itemName = itemName;
            this.$refs['uploadDom'].click();
          },
           uploadImgAction(){
            let config = {
              headers: {
                'Content-Type': 'multipart/form-data'
              }
            };
            var formData = new FormData();
            formData.append('fileUpload',this.tempUpload.imgPath)
            this.$axios.post('/Setting/upload',formData,config).then((res) => {
              if(this.tempUpload.index == -1){
                this[this.tempUpload.tableName][this.tempUpload.itemName]= res.data.path
                console.log(this.tempUpload.tableName,this.tempUpload.itemName)
              }else{
                this[this.tempUpload.tableName][this.tempUpload.itemName][this.tempUpload.index].src= res.data.path
              }
              this.$refs['uploadDom'].value = '';
            })
           }
        },
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>