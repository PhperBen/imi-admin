<template>

	<el-card shadow="never" header="个人信息">
		<el-form ref="form" :model="form" label-width="120px" style="margin-top:20px;">
			<el-form-item label="头像设置">
				<div class="user-info-top">
					<sc-upload style="border-radius:50%" v-model="form.avatar"></sc-upload>
				</div>
			</el-form-item>
			<el-form-item label="用户账号">
				<el-input v-model="form.username" disabled></el-input>
			</el-form-item>
			<el-form-item label="联系邮箱">
				<el-input v-model="form.email"></el-input>
			</el-form-item>
			<el-form-item>
				<el-button @click="submit" type="primary">保存</el-button>
			</el-form-item>
		</el-form>
	</el-card>
</template>

<script>
export default {
	data() {
		return {
			form: {
				avatar: "",
				username: "",
				email: "",
			},
		}
	},
	created() {
		this.userinfo = this.$TOOL.data.get('USER_INFO');
		for (const i in this.form) {
			this.form[i] = this.userinfo[i];
		}
	},
	methods: {
		async submit() {
			this.form.type = 'account';
			var res = await this.$API.auth.admin.profile.post(this.form);
			if (res.code == 200) {
				var newinfo = {};
				for (const i in this.userinfo) {
					newinfo[i] = this.form[i] ? this.form[i] : this.userinfo[i]
				}
				this.$TOOL.data.set('USER_INFO', newinfo);
				this.$message.success(res.message)
			} else {
				this.$message.error(res.message)
			}
		}
	}
}
</script>

<style scoped>
.user-info-top:deep(.el-image) {
	border-radius: 50%;
	width: 110px;
	height: 110px;
}
</style>
