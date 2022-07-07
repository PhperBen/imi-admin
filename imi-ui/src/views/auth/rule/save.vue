<template>
	<el-row :gutter="40">
		<el-col v-if="!form.id">
			<el-empty description="请选择左侧菜单后操作" :image-size="100"></el-empty>
		</el-col>
		<template v-else>
			<el-col :lg="12">
				<h2>{{form.name || "新增菜单"}}</h2>
				<el-form :model="form" :rules="rules" ref="dialogForm" label-width="80px" label-position="left">
					<el-form-item label="排序大小" prop="sort">
						<el-input v-model="form.sort" type="number" :validate-event="false" clearable placeholder="越大越靠前"></el-input>
					</el-form-item>
					<el-form-item label="显示名称" prop="name">
						<el-input v-model="form.name" clearable placeholder="菜单显示名字"></el-input>
					</el-form-item>
					<el-form-item label="菜单图标" prop="icon">
						<sc-icon-select v-model="form.icon" clearable></sc-icon-select>
					</el-form-item>
					<el-form-item label="上级菜单" prop="pid">
						<el-cascader v-model="form.pid" :options="menuOptions" :props="menuProps" :show-all-levels="false" placeholder="顶级菜单" clearable></el-cascader>
					</el-form-item>
					<el-form-item label="权限类型" prop="type">
						<el-radio-group v-model="form.type">
							<el-radio-button label="menu">菜单</el-radio-button>
							<el-radio-button label="iframe">Iframe</el-radio-button>
							<el-radio-button label="link">外链</el-radio-button>
							<el-radio-button label="button">按钮</el-radio-button>
						</el-radio-group>
					</el-form-item>
					<el-form-item label="权限别名" prop="alias" v-if="form.type == 'button'">
						<el-input v-model="form.alias" clearable placeholder="Vue前端判断使用"></el-input>
					</el-form-item>
					<el-form-item label="菜单地址" prop="path" v-if="form.type !== 'button'">
						<el-input v-model="form.path" clearable placeholder="Vue前端路由地址"></el-input>
					</el-form-item>
					<el-form-item label="权限规则" prop="rule" v-if="form.type == 'button'">
						<el-input v-model="form.rule" clearable placeholder="后端 控制器::方法"></el-input>
					</el-form-item>
					<el-form-item label="状态开关" prop="status">
						<el-radio v-model="form.status" :label="1">开启</el-radio>
						<el-radio v-model="form.status" :label="0">关闭</el-radio>
					</el-form-item>
					<el-form-item>
						<el-button type="primary" @click="save" :loading="loading">保 存</el-button>
					</el-form-item>
				</el-form>

			</el-col>
			<el-col :lg="12" class="apilist" v-if="form.type == 'button'">
				<h2>快捷操作</h2>
				<p style="color:#606266;font-size:14px;margin-bottom:8px">选择控制器</p>
				<el-select v-model="controller" @change="getMethod" placeholder="请选择控制器" style="width:100%">
					<el-option
					v-for="item in controllers"
					:key="item"
					:label="item"
					:value="item"
					>
					</el-option>
				</el-select>
				<p style="color:#606266;font-size:14px;margin-bottom:8px;margin-top:25px">选择方法</p>
				<el-select v-model="method" @change="changeMethod" placeholder="请选择控制器对应方法" style="width:100%">
					<el-option
					v-for="item in methods"
					:key="item"
					:label="item"
					:value="item"
					>
					</el-option>
				</el-select>
			</el-col>
		</template>
	</el-row>

</template>

<script>
import scIconSelect from '@/components/scIconSelect'

export default {
	components: {
		scIconSelect
	},
	props: {
		menu: { type: Object, default: () => {} },
	},
	data(){
		return {
			form: {
				id: "",
				pid: 0,
				name: "",
				alias: "",
				status: 1,
				sort:0,
				path: "",
				rule: "",
				icon: "",
				type: "menu"
			},
			controller:"",
			controllers:{},
			methods:{},
			ids:'',
			method:'',
			menuOptions: [],
			menuProps: {
				value: 'id',
				label: 'name',
				checkStrictly: true
			},
			rules: [],
			loading: false
		}
	},
	watch: {
		menu: {
			handler(){
				this.menuOptions = this.treeToMap(this.menu)
				this.ids = this.getIds(this.menu)
			},
			deep: true
		}
	},
	created(){
		this.$API.auth.rule.controllers.get().then(res=>{
			this.controllers = res.data;
		})
	},
	mounted() {
	},
	methods: {
		getIds(tree){
			var map = [];
			tree.forEach(item => {
				map.push(item.id);
				if(item.children&&item.children.length>0){
					var a = this.getIds(item.children);
					map = map.concat(a);
				}
			})
			return map;
		},
		changeMethod(){
			let rule = this.controller+"::"+this.method;
			this.form.rule = rule;
		},
		getMethod(){
			let controller = this.controller
			this.$API.auth.rule.methods.post({"class":controller}).then(res=>{
				this.methods = res.data;
			})
		},
		//简单化菜单
		treeToMap(tree){
			const map = []
			tree.forEach(item => {
				var obj = {
					id: item.id,
					pid: item.pid,
					name: item.name,
					children: item.children&&item.children.length>0 ? this.treeToMap(item.children) : null
				}
				map.push(obj)
			})
			return map
		},
		//保存
		async save(){
			this.loading = true
			if(!this.form.pid){
				this.form.pid = 0;
			}
			var res = await this.$API.auth.rule.update.post(this.form)
			this.loading = false
			if(res.code == 200){
				this.$message.success(res.message)
			}else{
				this.$message.warning(res.message)
			}
		},
		//表单注入数据
		setData(data, pid){
			this.form = data
			this.form.pid = pid

		}
	}
}
</script>

<style scoped>
h2 {font-size: 17px;color: #3c4a54;padding:0 0 30px 0;}
.apilist {border-left: 1px solid #eee;}

[data-theme="dark"] h2 {color: #fff;}
[data-theme="dark"] .apilist {border-color: #434343;}
</style>
