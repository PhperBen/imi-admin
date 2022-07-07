<template>
	<el-container>
		<el-aside width="200px" v-if="groupShow" v-auth="'system.config_group.read'" v-loading="showGrouploading">
			<el-container>
				<el-header>
					<el-input placeholder="搜索" v-model="groupFilterText" clearable></el-input>
				</el-header>
				<el-main class="nopadding">
					<el-tree ref="group" class="menu" node-key="id" :props="groupProps" :data="group" :current-node-key="''" :highlight-current="true" :expand-on-click-node="false" :filter-node-method="groupFilterNode" @node-click="groupClick"></el-tree>
				</el-main>
                <el-footer style="height:51px;">
					<el-button type="primary" size="default" icon="el-icon-menu" style="width: 100%;" @click="conigGroup">分组管理</el-button>
				</el-footer>
			</el-container>
		</el-aside>
		<el-container v-if="isConfig" v-loading="cardLoading">
            <el-main class="nopadding">
			<el-card shadow="never" body-style="padding: 10px 20px 10px 20px;" style="border:none;border-radius:0px;">
                <el-form ref="form" :model="inputs" label-position="left" label-width="200px" size="default">
                    <el-tabs v-model="tabActive" tab-position="top">
                        <template v-for="(item,k) in config" :key="k">
                            <el-tab-pane :name="'v'+k" :label="item.val">
                                <template v-for="input in item.config" :key="input.id">
                                    <template v-if="input.type == 'array'">
                                        <el-form-item :label="input.name">
                                            <el-table :data="inputs[input.key]" drag-sort stripe border>
                                                <el-table-column prop="#" width="50">
                                                    <template #header>
                                                        <el-button type="success" icon="el-icon-plus" size="small" circle @click="table_add(input.key)"></el-button>
                                                    </template>
                                                    <template #default="scope">
                                                        <el-popconfirm v-if="!scope.row.isSet" title="确定删除吗？" @confirm="table_del(input.key, scope.row, scope.$index)">
                                                            <template #reference>
                                                                <el-button type="danger" size="small" icon="el-icon-delete" circle></el-button>
                                                            </template>
                                                        </el-popconfirm>
                                                    </template>
                                                </el-table-column>
                                                <el-table-column prop="label" label="键名">
                                                    <template #default="scope">
                                                        <el-input v-model="scope.row.key"></el-input>
                                                    </template>
                                                </el-table-column>
                                                <el-table-column prop="prop" label="键值">
                                                    <template #default="scope">
                                                        <el-input v-model="scope.row.val"></el-input>
                                                    </template>
                                                </el-table-column>
                                            </el-table>

                                        </el-form-item>
                                    </template>
                                    <template v-else-if="input.type == 'string'">
                                        <el-form-item :label="input.name">
                                            <el-input v-model="inputs[input.key]"></el-input>
                                            <div class="el-form-item-msg" v-if="input.tip">{{input.tip}}</div>
                                        </el-form-item>
                                    </template>
                                    <template v-else-if="input.type == 'file'">
                                        <el-form-item :label="input.name">
                                        <el-input v-model="inputs[input.key]">
                                            <template #append>
                                                <el-button @click="upload(input.key,false)" icon="el-icon-folder-add"></el-button>
                                            </template>
                                        </el-input>
                                        <div class="el-form-item-msg" v-if="input.tip">{{input.tip}}</div>
                                        </el-form-item>
                                    </template>
                                    <template v-else-if="input.type == 'text'">
                                        <el-form-item :label="input.name">
                                            <el-input type="textarea" v-model="inputs[input.key]"></el-input>
                                            <div class="el-form-item-msg" v-if="input.tip">{{input.tip}}</div>

                                        </el-form-item>
                                    </template>
                                    <template v-else-if="input.type == 'editor'">
                                        <el-form-item :label="input.name">
                                            <sc-editor v-model="inputs[input.key]" placeholder=""></sc-editor>
                                        </el-form-item>
                                    </template>
                                    <template v-else-if="input.type == 'number'">
                                        <el-form-item :label="input.name">
                                            <el-input-number v-model="inputs[input.key]"></el-input-number>
                                        </el-form-item>
                                    </template>
                                    <template v-else-if="input.type == 'date'">
                                        <el-form-item :label="input.name">
                                            <el-date-picker v-model="inputs[input.key]" type="date"></el-date-picker>
                                        </el-form-item>
                                    </template>
                                    <template v-else-if="input.type == 'time'">
                                        <el-form-item :label="input.name">
                                            <el-time-picker format="HH:mm:ss" v-model="inputs[input.key]"></el-time-picker>
                                        </el-form-item>
                                    </template>
                                    <template v-else-if="input.type == 'datetime'">
                                        <el-form-item :label="input.name">
                                            <el-date-picker v-model="inputs[input.key]" type="datetime"></el-date-picker>
                                        </el-form-item>
                                    </template>
                                    <template v-else-if="input.type == 'datetimerange'">
                                        <el-form-item :label="input.name">
                                            <el-date-picker v-model="inputs[input.key]" type="datetimerange" range-separator="至" start-placeholder="开始日期" end-placeholder="结束日期"></el-date-picker>
                                        </el-form-item>
                                    </template>
                                    <template v-else-if="input.type == 'select'">
                                        <el-form-item :label="input.name">
                                            <el-select v-model="inputs[input.key]" style="width:100%" placeholder="请选择">
                                                <el-option v-for="(select,a) in input.variable" :key="a" :label="select" :value="a"></el-option>
                                            </el-select>
                                        </el-form-item>
                                    </template>
                                    <template v-else-if="input.type == 'selects'">
                                        <el-form-item :label="input.name">
                                            <el-select v-model="inputs[input.key]" style="width:100%" placeholder="请选择" multiple>
                                                <el-option v-for="(select,b) in input.variable" :key="b" :label="select" :value="b"></el-option>
                                            </el-select>
                                        </el-form-item>
                                    </template>
                                    <template v-else-if="input.type == 'image'">
                                        <el-form-item :label="input.name">
                                        <el-input v-model="inputs[input.key]">
                                            <template #append>
                                                <el-button @click="upload(input.key,false)" icon="el-icon-folder-add"></el-button>
                                            </template>
                                        </el-input>
                                        <div class="el-form-item-msg" v-if="input.tip">{{input.tip}}</div>
                                        </el-form-item>
                                    </template>
                                    <template v-else-if="input.type == 'images'">
                                         <el-form-item :label="input.name">
                                        <el-input v-model="inputs[input.key]">
                                            <template #append>
                                                <el-button @click="upload(input.key,true)" icon="el-icon-folder-add"></el-button>
                                            </template>
                                        </el-input>
                                        <div class="el-form-item-msg" v-if="input.tip">{{input.tip}}</div>
                                        </el-form-item>
                                    </template>
                                    <template v-else-if="input.type == 'switch'">
                                        <el-form-item :label="input.name">
                                            <el-switch v-model="inputs[input.key]" active-value="1" inactive-value="0"></el-switch>
                                        </el-form-item>
                                    </template>
                                    <template v-else-if="input.type == 'checkbox'">
                                        <el-form-item :label="input.name">
                                            <el-checkbox-group v-model="inputs[input.key]">
                                                <el-checkbox v-for="(checkbox,c) in input.variable" :key="c" :label="c">{{checkbox}}</el-checkbox>
                                            </el-checkbox-group>
                                        </el-form-item>
                                    </template>
                                    <template v-else-if="input.type == 'radio'">
                                        <el-form-item :label="input.name">
                                            <el-radio v-model="inputs[input.key]" v-for="(radio,d) in input.variable" :key="d" :label="d">{{radio}}</el-radio>
                                        </el-form-item>
                                    </template>
                                    <template v-else-if="input.type == 'slider'">
                                        <el-form-item :label="input.name">
                                            <el-slider v-model="inputs[input.key]"></el-slider>
                                        </el-form-item>
                                    </template>
                                    <template v-else-if="input.type == 'color'">
                                        <el-form-item :label="input.name">
                                            <el-color-picker v-model="inputs[input.key]" size="default"></el-color-picker>
                                        </el-form-item>
                                    </template>
                                    <template v-else-if="input.type == 'tableselect'">
                                        <el-form-item :label="input.name">
                                            <sc-table-select v-model="inputs[input.key]" :apiObj="apiObj[input.key]" :table-width="600" :props="props[input.key]">
                                                <el-table-column v-for="tableselect in input.variable" :key="tableselect" :prop="tableselect"></el-table-column>
                                            </sc-table-select>
                                        </el-form-item>
                                    </template>
                                    <template v-else-if="input.type == 'tableselects'">
                                        <el-form-item :label="input.name">
                                            <sc-table-select v-model="inputs[input.key]" :apiObj="apiObj[input.key]" :table-width="600" multiple :props="props[input.key]">
                                                <el-table-column v-for="tableselect in input.variable" :key="tableselect" :prop="tableselect"></el-table-column>
                                            </sc-table-select>
                                        </el-form-item>
                                    </template>
                                </template>
                                <el-form-item>
                                    <el-button type="primary" @click="submit" :loading="loading">保 存</el-button>
                                </el-form-item>
                            </el-tab-pane>
                        </template>
                        <el-tab-pane name="create" v-auth="'system.config.create'">
                            <template #label>
                            <span style="font-size:16px;font-weigh:bold"><el-icon-plus style="width: 1em; height: 1em;"/></span>
                            </template>
                            <form>
                            <el-form-item label="分类列表">
                                <el-select v-model="add.pid" placeholder="请选择分类" style="width:100%">
                                    <el-option v-for="item in config" :key="item.key" :label="item.val" :value="item.key"></el-option>
                                </el-select>
                            </el-form-item>
                            <el-form-item label="类型列表">
                                <el-select v-model="add.type" placeholder="请选择类型" style="width:100%">
                                    <el-option key="string" label="字符" value="string"></el-option>
                                    <el-option key="text" label="文本" value="text"></el-option>
                                    <el-option key="editor" label="编辑器" value="editor"></el-option>
                                    <el-option key="number" label="数字" value="number"></el-option>
                                    <el-option key="date" label="日期" value="date"></el-option>
                                    <el-option key="time" label="时间" value="time"></el-option>
                                    <el-option key="datetime" label="日期时间" value="datetime"></el-option>
                                    <el-option key="datetimerange" label="日期时间区间" value="datetimerange"></el-option>
                                    <el-option key="select" label="下拉框" value="select"></el-option>
                                    <el-option key="selects" label="多选下拉框" value="selects"></el-option>
                                    <el-option key="image" label="图片" value="image"></el-option>
                                    <el-option key="images" label="图片多选" value="images"></el-option>
                                    <el-option key="file" label="文件" value="file"></el-option>
                                    <el-option key="switch" label="开关" value="switch"></el-option>
                                    <el-option key="checkbox" label="复选框" value="checkbox"></el-option>
                                    <el-option key="radio" label="单选框" value="radio"></el-option>
                                    <el-option key="array" label="数组" value="array"></el-option>
                                    <el-option key="tableselect" label="列表选择" value="tableselect"></el-option>
                                    <el-option key="tableselects" label="列表选择多选" value="tableselects"></el-option>
                                </el-select>
                            </el-form-item>
                            <el-form-item label="显示名称">
                                <el-input v-model="add.name" placeholder="用于后台显示"></el-input>
                            </el-form-item>
                            <el-form-item label="配置名称">
                                <el-input v-model="add.key" placeholder="config(名称)，英文"></el-input>
                            </el-form-item>
                            <el-form-item label="默认值">
                                <el-input v-model="add.value" placeholder="选填，建议填写"></el-input>
                            </el-form-item>
                            <el-form-item label="提示信息">
                                <el-input v-model="add.tip" placeholder="用于后台显示"></el-input>
                            </el-form-item>
                            <el-form-item label="变量内容">
                                <el-input type="textarea" rows="12" v-model="add.variable" placeholder="下拉，多选下拉，单选，复选，列表选择（多）需要填写
除了列表选择（多）外格式为json对象或数组
例如：单选 值为0/1的开启关闭：['关闭','开启']
例如：单选/复选/下拉 值为a/b：{'a':'我是a','b':'我=b'}

列表选择（多）格式：system/config/read,name/id/search,id/name
译：system/config/read  = this.$API.system.config.read.get(),
译：name/id/id              = label字段/value字段/模糊搜索提交参数名称
译：id/name                  = 显示字段/显示字段

以英文逗号分隔 / 间隔，第一个参数可以有无限个“/”为api接口地址
第二个参数固定间隔三个参数，第三个参数可以无限“/”为显示在列表的字段"></el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-button type="success" @click="addSubmit" :loading="loading">确认添加</el-button>
                            </el-form-item>
                            </form>
                        </el-tab-pane>
                    </el-tabs>
                </el-form>
            </el-card>
            </el-main>
		</el-container>
	</el-container>
	<group-dialog v-if="dialog.group" ref="groupDialog" @closed="groupClosed"></group-dialog>
	<attachment-dialog v-if="dialog.attachment" :multiple="upload_multiple" ref="attachmentDialog" @success="uploadSuccess" @closed="groupClosed"></attachment-dialog>

</template>

<script>
    import groupDialog from '@/views/system/config_group/index'
    import attachmentDialog from '@/views/system/attachment/select'
    import { defineAsyncComponent } from 'vue';
	import { ref } from 'vue'
	const scEditor = defineAsyncComponent(() => import('@/components/scEditor'));
	export default {
		name: 'user',
        components: {
			groupDialog,
            scEditor,
            attachmentDialog
		},
		data() {
			return {
				tabActive:"",
                upload_multiple:false,
				dialog: {
					group: false,
                    attachment:false
				},
				showGrouploading: false,
				groupFilterText: '',
                isConfig:false,
				group: [],
                group_children:[],
				apiObj: this.$API.auth.admin.read,
				selection: [],
				search: {
					name: null
				},
                cardLoading:false,
                add:{
					name:"",
					pid:"",
					type:"",
					key:"",
					value:"",
					tip:"",
					variable:"",
				},
                groupShow:true,
                groupProps: {
					value: "id",
					emitPath: false,
					label: 'name',
					checkStrictly: true
				},
                config: [],
				inputs: {},
				props: [],
				loading:false,
                fullLoading:false,
				upload_visible:false,
				upload_key:'',
			}
		},
		watch: {
			groupFilterText(val) {
				this.$refs.group.filter(val);
			}
		},
		mounted() {
			this.tabActive = ref('v0')
			this.getGroup(true)
		},
		methods: {
            upload(key,multiple){
                this.dialog.attachment = true;
                this.$nextTick(() => {
					this.$refs.attachmentDialog.open()
				})
                this.upload_key = key;
                this.upload_multiple = multiple;
            },
            uploadSuccess(value){
                if(value instanceof Array){
                    this.inputs[this.upload_key] = value.join();
                }else{
                    this.inputs[this.upload_key] = value;
                }
                this.dialog.attachment = false;
            },
            addSubmit:function(){
				this.loading = true;
				this.$API.system.config.create.post(this.add).then(res=>{
					this.loading = false;
					if (res.code == 200) {
						this.$message.success(res.message)
					}else{
						this.$message.error(res.message)
					}
				});
			},
			submit: function(){
				this.loading = true;
				this.$API.system.config.update.post(this.inputs).then(res=>{
					this.loading = false;
					if (res.code == 200) {
						this.$message.success(res.message)
					}else{
						this.$message.error(res.message)
					}
				});
			},
            groupClosed(){
                this.dialog.group=false
                this.getGroup()
            },
            conigGroup(){
                this.dialog.group = true;
                this.$nextTick(() => {
					this.$refs.groupDialog.open()
				})
            },
			//加载树数据
			async getGroup(first){
                this.fullLoading = this.$loading()
				this.showGrouploading = true;
				var res = await this.$API.system.config.group.read.get();
				this.showGrouploading = false;
                var groups = []
                var group_children = [];
                for(const i in res.data){
                    groups[i] = {name:res.data[i].name,id:res.data[i].id}
                    group_children[res.data[i].id] = res.data[i].children;
                }
                this.group = groups;
                this.group_children = group_children;
                if(groups.length == 0){
                    this.groupShow = false;
                }
                if(first === true){
                    if(this.group && this.group.length > 0){
                        this.isConfig = true;
                        this.groupClick({id:this.group[0].id})
                        return false;
                    }
                }
                this.fullLoading.close();
			},
			//树过滤
			groupFilterNode(value, data){
				if (!value) return true;
				return data.name.indexOf(value) !== -1;
			},
			//树点击事件
			groupClick(data){
                this.cardLoading = true;
				var group_id = data.id;
                var children = this.group_children[group_id];
                if(!children || children.length == 0){
                    this.$message.warning('分组下没有二级分类');
                    this.cardLoading = false;
                    if(this.fullLoading)this.fullLoading.close();
                    return false;
                }
                this.$API.system.config.read.get({group_id:group_id}).then(res=>{
                    var data = res.data;
                    this.config = data;
					data.forEach((res,resIndex) => {
						res.config.forEach((item,itemIndex) => {
							if (item.type == 'array') {
								this.inputs[item.key] = item.value ? (item.value) : [];
							}else if(item.type == 'number' || item.type == 'slider'){
								this.inputs[item.key] = parseInt(item.value);
							}else if(item.type == 'select' || item.type == 'selects'){
								this.config[resIndex].config[itemIndex].variable = (item.variable);
								if(item.type == 'selects') {
									this.inputs[item.key]=this.goInt(item.value);
								}else{
									if (parseFloat(item.value).toString() !== "NaN") {
										this.inputs[item.key] = parseFloat(item.value);
									}else{
                                        this.inputs[item.key] = item.value
                                    }
								}
							}else if(item.type == 'switch'){
								this.inputs[item.key]=(item.value)+"";
							}else if(item.type == 'checkbox' || item.type == 'radio'){
								this.config[resIndex].config[itemIndex].variable = (item.variable);
								if(item.type == 'checkbox') {
									this.inputs[item.key] = this.goInt(item.value);
								}else{
									if (parseFloat(item.value).toString() !== "NaN") {
										this.inputs[item.key] = parseFloat(item.value);
									}else{
                                        this.inputs[item.key] = item.value
                                    }
								}
							}else if(item.type == 'tableselect' || item.type == 'tableselects'){
								// index/test,user/id/id,id/user
								if (item.type == 'tableselect') {
									this.inputs[item.key] = item.value ? (item.value) : {};
								}else{
									this.inputs[item.key] = item.value ? (item.value) : [];
								}
								var variable = (item.variable).split(',');
								var api = variable[0].split('/');
								var prop = variable[1].split('/');
								var display = variable[2].split('/');
                                for(const apiObji in api){
                                    this.apiObj[item.key] = this.apiObj[item.key]?this.apiObj[item.key][api[apiObji]]:this.$API[api[apiObji]];
                                }
								this.props[item.key] =  {label: prop[0],value: prop[1],keyword: prop[2]};
								this.config[resIndex].config[itemIndex].variable = display;
							}else{
								this.inputs[item.key] = item.value;
							}
						});
					});
                    if(this.fullLoading)this.fullLoading.close();
                    this.cardLoading = false;
					this.tabActive = ref('v0')
                });
			},
            goInt:function(value){
				var selectvalue = typeof(value) == "string" ? JSON.parse(value) : value;
				selectvalue = selectvalue ? selectvalue : [];
				var itemvalue = [];
				selectvalue.forEach((select,selectIndex) => {
					if (parseFloat(select).toString() == "NaN") {
						itemvalue[selectIndex] = (select);
					}else{
						itemvalue[selectIndex] = parseFloat(select);
					}
				});
				return itemvalue;
			},
            table_add(input){
				var newRow = {
					key: "",
					val: "",
				}
				this.inputs[input].push(newRow)
			},
			table_del(input, row, index){
				this.inputs[input].splice(index, 1)
			},
		}
	}
</script>

<style scoped>
	.el-card:deep(.el-tabs__nav){
		width: 100%;
	}
	.el-card:deep(#tab-create){
		float:right!important;
	}
	.el-card:deep(#tab-v0){
		padding-left: 0!important;
	}
</style>
