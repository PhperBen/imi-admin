<template>
	<el-dialog :title="titleMap[mode]" v-model="visible" :width="500" destroy-on-close @closed="$emit('closed')">
		<el-form :model="form" :rules="rules" :disabled="mode=='show'" ref="dialogForm" label-width="100px" label-position="left">
			<el-form-item label="上级角色" prop="pid">
				<el-cascader v-model="form.pid" :options="groups" :props="groupsProps" :show-all-levels="false" clearable style="width: 100%;"></el-cascader>
			</el-form-item>
			<el-form-item label="角色名称" prop="name">
				<el-input v-model="form.name" clearable></el-input>
			</el-form-item>
			<el-form-item label="状态开关" prop="status">
                <el-radio v-model="form.status" :label="1">开启</el-radio>
                <el-radio v-model="form.status" :label="0">关闭</el-radio>
            </el-form-item>
            <el-form-item label="选择权限" prop="rules">
    			<div class="treeMain">
					<el-tree ref="tree" node-key="id" :data="menu.list" :default-checked-keys="[]" :props="menu.props" show-checkbox></el-tree>
				</div>
			</el-form-item>
		</el-form>
		<template #footer>
			<el-button @click="visible=false" >取 消</el-button>
			<el-button v-if="mode!='show'" type="primary" :loading="isSaveing" @click="submit()">保 存</el-button>
		</template>
	</el-dialog>
</template>

<script>
	export default {
		emits: ['success', 'closed'],
		data() {
			return {
				menu: {
					list: [],
					props: {
						label: (data)=>{
							return data.name
						}
					}
				},
				mode: "create",
				titleMap: {
					create: '新增',
					update: '编辑',
				},
				visible: false,
				isSaveing: false,
				form: {
					id:"",
					name: "",
					pid: 0,
					status: 1,
					rules: ""
				},
				rules: {},
				groups: [],
				groupsProps: {
					value: "id",
					emitPath: false,
					label: 'name',
					checkStrictly: true
				}

			}
		},
		mounted() {
			this.getMenu();
			this.getGroup()
		},
		methods: {
			open(mode='create'){
				this.mode = mode;
				this.visible = true;
				return this
			},
			async getGroup(){
				var res = await this.$API.auth.group.read.get();
				this.groups = res.data;
			},
			getMenu: async function() {
				var data = await this.$API.auth.rule.read.get();
				this.menu.list = data.data
			},
			submit(){
				this.form.rules = this.$refs.tree.getCheckedNodes(false,true).map(i => i.id)
				if(!this.form.pid){
					this.form.pid = 0;
				}
				this.$refs.dialogForm.validate(async (valid) => {
					if (valid) {
						this.isSaveing = true;
						var res = await this.$API.auth.group[this.mode].post(this.form);
						this.isSaveing = false;
						if(res.code == 200){
							this.$emit('success', this.form, this.mode)
							this.visible = false;
							this.$message.success(res.message)
						}else{
							this.$alert(res.message, "提示", {type: 'error'})
						}
					}
				})
			},
			setData(data){
				Object.assign(this.form, data)
				this.form.rules = data.rules.split(',');
				let datas = this.form.rules;
				this.$data.thisRefTree = setInterval(() =>{
					datas.forEach((i) => {
						let node = this.$refs.tree.getNode(i);
						if(node.isLeaf){
							this.$refs.tree.setChecked(node, true);
						}
					});
					clearInterval(this.$data.thisRefTree)
				},200)
			}
		}
	}
</script>

<style>
</style>
