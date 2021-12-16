<template>
	<el-container>
		<el-main>
			<el-row>
				<el-col :span="24">
				<el-row>
				<el-col :span="12">
					<el-card class="box-card" style="height:22rem" shadow="never">
						<template #header>
						<div class="card-header">
							<span>选择模型</span>
						</div>
						</template>
						<el-alert title="模型生成" type="warning" :closable="false">
							<slot>
								生成常规代码前，需要使用“<a href="https://doc.imiphp.com/v2.0/dev/generate/model.html" target="_blank">IMI模型生成</a>”生成模型<br><br>
								生成时需要设置模型基类，并关闭驼峰命名，<br>例：vendor/bin/imi-swoole generate/model "ImiApp\ApiServer\Backend\Model" "ImiApp\ImiServer\AbstractModel" --entity false
							</slot>
						</el-alert>
						<br>
						<el-select v-model="model" @change="modelChange" style="width:100%" placeholder="请选择模型">
							<el-option v-for="item in models" :key="item" :label="item" :value="item"></el-option>
						</el-select>
					</el-card>
				</el-col>
				<el-col :span="12">
					<el-card class="box-card" style="height:22rem" shadow="never">
						<template #header>
						<div class="card-header">
							<span>执行命令</span>
						</div>
						</template>
						<el-alert title="在线命令行" type="info" :closable="false">
							<slot>
								可以在此执行“模型生成”或其他命令
							</slot>
						</el-alert>
						<br>
						<el-input type="textarea" rows="4" v-model="command"></el-input>
					</el-card>
				</el-col>
				</el-row>
				</el-col>
				<el-col :span="24">
					<el-card shadow="never">
						<el-tabs tab-position="top" >
							<el-tab-pane label="字段配置">
								<sc-form-table v-model="column" :addTemplate="addTemplate" placeholder="请添加列数据">
									<el-table-column prop="key" label="字段名称">
										<template #default="scope">
											<el-input v-model="scope.row.key" placeholder=""></el-input>
										</template>
									</el-table-column>
									<el-table-column prop="name" label="显示名称">
										<template #default="scope">
											<el-input v-model="scope.row.name" placeholder=""></el-input>
										</template>
									</el-table-column>
									<el-table-column prop="table" label="列表展示" >
										<template #default="scope">
											<el-checkbox v-model="scope.row.table"></el-checkbox>
										</template>
									</el-table-column>
									<el-table-column prop="table_type" label="列表展示类型">
										<template #default="scope">
											<el-select v-model="scope.row.table_type">
												<el-option label="文本" value="text"></el-option>
												<el-option label="时间戳转换" value="datetime"></el-option>
												<el-option label="快捷开关" value="switch"></el-option>
												<el-option label="拖拽排序" value="sort"></el-option>
												<el-option label="缩略图" value="image"></el-option>
												<el-option label="Tag标签" value="tag"></el-option>
											</el-select>
										</template>
									</el-table-column>
									<el-table-column prop="save" label="创建编辑" >
										<template #default="scope">
											<el-checkbox v-model="scope.row.save"></el-checkbox>
										</template>
									</el-table-column>
									<el-table-column prop="save_type" label="创建编辑类型">
										<template #default="scope">
											<el-select v-model="scope.row.save_type">
												<el-option label="文本" value="text"></el-option>
												<el-option label="数字" value="number"></el-option>
												<el-option label="下拉框" value="select"></el-option>
												<el-option label="文本域" value="textarea"></el-option>
												<el-option label="富文本" value="editor"></el-option>
												<el-option label="时间选择" value="datetime"></el-option>
												<el-option label="单选" value="radio"></el-option>
												<el-option label="复选" value="checkbox"></el-option>
												<el-option label="开关" value="switch"></el-option>
												<el-option label="图片" value="image"></el-option>
												<el-option label="图片（多）" value="images"></el-option>
												<el-option label="颜色选择器" value="color"></el-option>
												<el-option label="滑块选择器" value="slider"></el-option>
											</el-select>
										</template>
									</el-table-column>
									<el-table-column prop="option" label="创建编辑设置">
										<template #default="scope">
											<el-input v-model="scope.row.save_option" placeholder=""></el-input>
										</template>
									</el-table-column>
									<el-table-column prop="search" label="模糊搜索" >
										<template #default="scope">
											<el-checkbox v-model="scope.row.search"></el-checkbox>
										</template>
									</el-table-column>
									<el-table-column prop="filter" label="高级搜索" >
										<template #default="scope">
											<el-checkbox v-model="scope.row.filter"></el-checkbox>
										</template>
									</el-table-column>
									<el-table-column prop="filter_type" label="高级搜索类型">
										<template #default="scope">
											<el-select v-model="scope.row.filter_type">
												<el-option label="文本" value="text"></el-option>
												<el-option label="数字区间" value="between"></el-option>
												<el-option label="下拉框" value="select"></el-option>
												<el-option label="日期" value="date"></el-option>
												<el-option label="日期范围" value="daterange"></el-option>
												<el-option label="日期时间" value="datetime"></el-option>
												<el-option label="日期时间范围" value="datetimerange"></el-option>
												<el-option label="开关" value="switch"></el-option>
												<el-option label="标签区间" value="tag"></el-option>
											</el-select>
										</template>
									</el-table-column>
									<el-table-column prop="filter_data" label="高级搜索参数">
										<template #default="scope">
											<el-input v-model="scope.row.filter_data" placeholder=""></el-input>
										</template>
									</el-table-column>
									<el-table-column prop="filter_operator" label="高级搜索运算符">
										<template #default="scope">
											<el-select v-model="scope.row.filter_operator">
												<el-option v-for="ope in operator" :key="ope.value" :label="ope.label" :value="ope.value"></el-option>
											</el-select>
										</template>
									</el-table-column>
									<el-table-column prop="operate" label="快捷操作" >
										<template #default="scope">
											<el-checkbox v-model="scope.row.operate"></el-checkbox>
										</template>
									</el-table-column>
									<el-table-column prop="sort" label="拖拽排序" >
										<template #default="scope">
											<el-checkbox v-model="scope.row.sort"></el-checkbox>
										</template>
									</el-table-column>
									<el-table-column prop="require" label="必填" >
										<template #default="scope">
											<el-checkbox v-model="scope.row.require"></el-checkbox>
										</template>
									</el-table-column>
								</sc-form-table>
							</el-tab-pane>
							<el-tab-pane label="关联模型">
								<el-row>
									<el-col :span="24">
									<el-alert title="关联模型" type="warning" :closable="false">
											<slot>
												此处仅用于关联模型查询，插入/更新/删除请参照imi文档，暂时只支持“<a href="https://doc.imiphp.com/v2.0/components/orm/relation/oneToOne.html" target="_blank">一对一</a>”“<a href="https://doc.imiphp.com/v2.0/components/orm/relation/oneToMany.html" target="_blank">一对多</a>”，填入文档中模型设置的属性字段
											</slot>
										</el-alert>
										<br>
										<el-form :model="relation" label-width="100px">
											<el-form-item label="关联模型属性">
												<el-input v-model="relation.name"></el-input>
												<div class="el-form-item-msg">输入关联模型字段名，多个英文逗号分隔</div>
											</el-form-item>
										</el-form>
									</el-col>
								</el-row>
							</el-tab-pane>
							<el-tab-pane label="路径配置">
								<el-row>
									<el-col :xl="12" :lg="8">
										<el-form :model="path" label-width="130px">
											<el-form-item label="控制器目录">
												<el-input v-model="path.controller">
												</el-input>
											</el-form-item>
											<el-form-item label="服务层目录">
												<el-input v-model="path.service">
												</el-input>
											</el-form-item>
											<el-form-item label="验证器目录">
												<el-input v-model="path.validate">
												</el-input>
											</el-form-item>
											<el-form-item label="Vue-src目录">
												<el-input v-model="path.vue">
												</el-input>
											</el-form-item>
											<el-form-item label="Vue-目录名称">
												<el-input v-model="path.name">
												</el-input>
											</el-form-item>
										</el-form>
									</el-col>
								</el-row>
							</el-tab-pane>
							<el-tab-pane label="其他配置">
								<el-row>
									<el-col :span="24">
										<el-form :model="other" label-width="130px">
											<el-form-item label="控制器基类">
												<el-input v-model="other.controller"></el-input>
											</el-form-item>
											<el-form-item label="Auth配置名称">
												<el-input v-model="other.auth"></el-input>
											</el-form-item>
											<el-form-item label="控制器路由地址">
												<el-input v-model="other.route"></el-input>
											</el-form-item>
										</el-form>
										
									</el-col>
								</el-row>
							</el-tab-pane>
						</el-tabs>
					</el-card>
				</el-col>
			</el-row>
		</el-main>
		<el-footer>
			<el-button type="primary" @click="submit(false)" icon="sc-icon-code">生成到目录</el-button>
			<el-button type="warning" @click="submit(true)" icon="el-icon-download">下载压缩包</el-button>
		</el-footer>
	</el-container>
</template>

<script>
	String.prototype.trim = function (char, type) {
	if (char) {
		if (type == 'left') {
		return this.replace(new RegExp('^\\'+char+'+', 'g'), '');
		} else if (type == 'right') {
		return this.replace(new RegExp('\\'+char+'+$', 'g'), '');
		}
		return this.replace(new RegExp('^\\'+char+'+|\\'+char+'+$', 'g'), '');
	}
	return this.replace(/^\s+|\s+$/g, '');
	};
	import config from "@/config/filterBar";
	import url from "@/config/index";
	export default {
		name: 'autocode-list',
		data() {
			return {
				operator: config.operator,
				relation: {
					name: "",
				},
				other: {
					auth: "backend",
					route: "",
					controller:"ImiApp\\ApiServer\\Backend\\Controller\\CommonController"
				},
				path: {
					controller: '/ApiServer/Backend/Controller/',
					service: '/ApiServer/Backend/Service/',
					validate: '/ApiServer/Backend/Validate/',
					vue:'/imi-ui/src/',
					name:'',
				},
				column: [],
				addTemplate: {
					label: "",
					prop: "",
					width: "100",
					isSearch: false,
					isEdit: false
				},
				model:"",
				models:{},
				command:"",
				className:"",
				info:[],
			}
		},
		mounted(){
			this.class();
		},
		methods: {
			submit(download){
				var data = {
					path:this.path,
					column:this.column,
					other:this.other,
					relation:this.relation.name,
					download:download,
					model:this.model

				}
				this.$API.system.autocode.create.post(data).then(res=>{
					if(res.code == 200){
						this.$message.success(res.message);
						if(download){
							this.createFile('build.zip')
						}
					}else{
						this.$message.error(res.message)
					}
				});
			},
			createFile(name){
				const element = document.createElement('a')
				element.setAttribute('href', url.API_URL+'/system/autocode/zip')
				element.setAttribute('download', name)
				element.style.display = 'none'
				element.click()
			},
			modelChange(){
				var model = this.model;
				if(!model){
					return false;
				}
				const loading = this.$loading();
				var name = model.split("\\").pop();
				this.path.controller = '/ApiServer/Backend/Controller/'+name+"Controller.php";
				this.path.service = '/ApiServer/Backend/Service/'+name+"Service.php";
				this.path.validate = '/ApiServer/Backend/Validate/'+name+"Validate.php";
				this.path.vue = '/imi-ui/src/';
				this.path.name = name.replace(/([A-Z])/g,"_$1").toLowerCase().trim('_');
				this.other.route = '/'+(this.path.name).replace(RegExp("_", "g"), "/")+"/";
				this.$API.system.autocode.info.get({model:model}).then(res=>{
					this.info = res.data
					this.column = res.data
					loading.close();
				});
			},
			class(){
				this.$API.system.autocode.models.get().then(res=>{
					this.models = res.data
				});
			},
		}
	}
</script>

<style scoped>
	.code {height:400px;overflow: auto;background: #333;color: #999;padding:20px;font-size: 14px;font-family: "consolas";line-height: 1.5;}
</style>
