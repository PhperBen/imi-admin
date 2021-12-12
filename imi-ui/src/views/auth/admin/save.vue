<template>
	<el-dialog :title="titleMap[mode]" v-model="visible" :width="500" destroy-on-close @closed="$emit('closed')">
		<el-form :model="form" :rules="rules" :disabled="mode=='show'" ref="dialogForm" label-width="100px" label-position="left">
			<el-form-item label="头像" prop="avatar">
				<sc-upload v-model="form.avatar" title="上传头像"></sc-upload>
			</el-form-item>
			<el-form-item label="邮箱" prop="email">
				<el-input v-model="form.email" clearable></el-input>
			</el-form-item>
            <el-form-item label="手机" prop="mobile">
				<el-input v-model="form.mobile" clearable></el-input>
			</el-form-item>
			<el-form-item label="账号" prop="username">
				<el-input v-model="form.username" clearable></el-input>
			</el-form-item>
			<el-form-item label="密码" prop="password">
				<el-input v-model="form.password" clearable></el-input>
			</el-form-item>
			<el-form-item label="状态" prop="status">
    			<el-radio v-model="form.status" :label="1">开启</el-radio>
				<el-radio v-model="form.status" :label="0">关闭</el-radio>
			</el-form-item>
			<el-form-item label="角色" prop="groups">
				<el-cascader v-model="form.groups" :options="groups" :props="groupsProps" :show-all-levels="false" clearable style="width: 100%;"></el-cascader>
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
				mode: "create",
				titleMap: {
					create: '新增用户',
					update: '编辑用户',
				},
				visible: false,
				isSaveing: false,
				//表单数据
				form: {
					id:0,
					username: "",
					avatar: "",
					password: "",
					groups: "",
					status: 1,
					email: "",
					mobile: "",
				},
				//验证规则
				rules: {
				},
				groups: [],
				groupsProps: {
					value: "id",
                    label: 'name',
					multiple: true,
                    emitPath:false,
					checkStrictly: true
				}
			}
		},
		mounted() {
			this.getGroup()
		},
		methods: {
			//显示
			open(mode='create'){
				this.mode = mode;
				this.visible = true;
				return this
			},
			//加载树数据
			async getGroup(){
				var res = await this.$API.auth.group.read.get();
				this.groups = res.data;
			},
			//表单提交方法
			submit(){
				this.$refs.dialogForm.validate(async (valid) => {
					if (valid) {
						this.isSaveing = true;
						var res = await this.$API.auth.admin[this.mode].post(this.form);
						this.isSaveing = false;
						if(res.code == 200){
							this.$emit('success', this.form, this.mode)
							this.visible = false;
							this.$message.success(res.message)
						}else{
							this.$alert(res.message, "提示", {type: 'error'})
						}
					}else{
						return false;
					}
				})
			},
			setData(data){
				Object.assign(this.form, data)
			}
		}
	}
</script>

<style>
</style>
