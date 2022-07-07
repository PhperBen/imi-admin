<template>
	<el-card shadow="never" header="修改密码">
		<el-form ref="form" :model="form" :rules="rules" label-width="120px" style="margin-top:20px;">
			<el-form-item label="当前密码" prop="userPassword">
				<el-input v-model="form.userPassword" type="password" show-password placeholder="请输入当前密码"></el-input>
				<div class="el-form-item-msg">必须提供当前登录用户密码才能进行更改</div>
			</el-form-item>
			<el-form-item label="新密码" prop="newPassword">
				<el-input v-model="form.newPassword" type="password" show-password placeholder="请输入新密码"></el-input>
				<sc-password-strength v-model="form.newPassword"></sc-password-strength>
				<div class="el-form-item-msg">请输入包含英文、数字的8位以上密码</div>
			</el-form-item>
			<el-form-item label="确认密码" prop="confirmNewPassword">
				<el-input v-model="form.confirmNewPassword" type="password" show-password
						  placeholder="请再次输入新密码"></el-input>
			</el-form-item>
			<el-form-item>
				<el-button type="primary" @click="save">保存密码</el-button>
			</el-form-item>
		</el-form>
	</el-card>
</template>

<script>
import scPasswordStrength from '@/components/scPasswordStrength'

export default {
	components: {
		scPasswordStrength
	},
	data() {
		return {
			form: {
				userPassword: "",
				newPassword: "",
				confirmNewPassword: ""
			},
			rules: {
				userPassword: [
					{required: true, message: '请输入当前密码'}
				],
				newPassword: [
					{required: true, message: '请输入新密码'}
				],
				confirmNewPassword: [
					{required: true, message: '请再次输入新密码'},
					{
						validator: (rule, value, callback) => {
							if (value !== this.form.newPassword) {
								callback(new Error('两次输入密码不一致'));
							} else {
								callback();
							}
						}
					}
				]
			}
		}
	},
	methods: {
		save() {
			this.$refs.form.validate(valid => {
				if (valid) {
					this.$API.auth.admin.profile.post({
						type: 'password',
						oldpassword: this.form.userPassword,
						newpassword: this.form.newPassword
					}).then(res => {
						if (res.code == 200) {
							this.$message.success(res.message)
						} else {
							this.$message.error(res.message)
						}
					});
				} else {
					return false
				}
			})
		}
	}
}
</script>

<style>
</style>
