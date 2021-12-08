<template>
	<div class="login_bg">
		<div class="login_adv" style="background-image: url(img/auth_banner.jpg);">
			<div class="login_adv__title">
				<h2>IMI Admin</h2>
				<h4>极速性能 / 快速开发 / 安全稳定</h4>
				<p>基于Imi + Scui的后台管理框架</p>
				<div>
					<span>
						<el-icon><sc-icon-vue /></el-icon>
					</span>
					<span>
						<el-icon class="add"><el-icon-plus /></el-icon>
					</span>
					<span>
						<el-icon><el-icon-eleme-filled /></el-icon>
					</span>
				</div>
			</div>
			<div class="login_adv__bottom">
				© Imi-Admin
			</div>
		</div>
		<div class="login_main">
			<div class="login_config">
				<el-button :icon="config.theme=='dark'?'el-icon-sunny':'el-icon-moon'" circle type="info" @click="configTheme"></el-button>
			</div>
			<div class="login-form">
				<div class="login-header">
					<h2>用户登陆</h2>
				</div>
				<el-form ref="loginForm" :model="ruleForm" :rules="rules" label-width="0" size="large">
					<el-form-item prop="user">
						<el-input v-model="ruleForm.username" prefix-icon="el-icon-user" clearable placeholder="请输入账号"></el-input>
					</el-form-item>
					<el-form-item prop="password">
						<el-input v-model="ruleForm.password" prefix-icon="el-icon-lock" clearable show-password placeholder="请输入密码"></el-input>
					</el-form-item>
					<el-form-item>
						<el-button type="primary" style="width: 100%;" :loading="islogin" round @click="login">{{ $t('login.signIn') }}</el-button>
					</el-form-item>
				</el-form>

			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				ruleForm: {
					username: "",
					password: "",
				},
				rules: {
					username: [
						{required: true, message: '请输入账号', trigger: 'blur'}
					],
					password: [
						{required: true, message: '请输入密码', trigger: 'blur'}
					]
				},
				islogin: false,
				config: {
					theme: this.$TOOL.data.get('APP_THEME') || 'default'
				},
			}
		},
		watch:{
			'config.theme'(val){
				document.body.setAttribute('data-theme', val)
				this.$TOOL.data.set("APP_THEME", val);
			},
		},
		created: function() {
			this.$TOOL.data.remove("TOKEN")
			this.$TOOL.data.remove("USER_INFO")
			this.$TOOL.data.remove("MENU")
			this.$TOOL.data.remove("PERMISSIONS")
			this.$TOOL.data.remove("grid")
			this.$store.commit("clearViewTags")
			this.$store.commit("clearKeepLive")
			this.$store.commit("clearIframeList")
		},
		methods: {
			async login(){

				var validate = await this.$refs.loginForm.validate().catch(()=>{})
				if(!validate){ return false }

				this.islogin = true
				var data = {
					username: this.ruleForm.username,
					password: this.ruleForm.password
				}
				//获取token
				var user = await this.$API.common.login.post(data)
				if(user.code == 200){
					this.$TOOL.data.set("TOKEN", user.data.token)
					this.$TOOL.data.set("USER_INFO", user.data.userInfo)
				}else{
					this.islogin = false
					this.$message.warning(user.message)
					return false
				}
				//获取菜单
				var menu = await this.$API.common.auth.get()
				if(menu.code == 200){
					if(menu.data.menu.length==0){
						this.islogin = false
						this.$alert("当前用户无任何菜单权限，无法登陆", "无权限访问", {
							type: 'error',
							center: true
						})
						return false
					}
					this.$TOOL.data.set("MENU", menu.data.menu)
					this.$TOOL.data.set("PERMISSIONS", menu.data.permissions)
				}else{
					this.islogin = false
					this.$message.warning(menu.message)
					return false
				}

				this.$router.replace({
					path: '/'
				})
				this.$message.success(user.message)
				this.islogin = false
			},
			configTheme(){
				this.config.theme = this.config.theme=='default'?'dark':'default'
			},
		}
	}
</script>

<style scoped>
	.login_bg {width: 100%;height: 100%;background: #fff;display: flex;}
	.login_adv {width: 33.33333%;background-color: #555;background-size: cover;background-position: center center;background-repeat: no-repeat;position: relative;}
	.login_adv__title {color: #fff;padding: 40px;}
	.login_adv__title h2 {font-size: 40px;}
	.login_adv__title h4 {font-size: 18px;margin-top: 10px;font-weight: normal;}
	.login_adv__title p {font-size: 14px;margin-top:10px;line-height: 1.8;color: rgba(255,255,255,0.6);}
	.login_adv__title div {margin-top: 10px;display: flex;align-items: center;}
	.login_adv__title div span {margin-right: 15px;}
	.login_adv__title div i {font-size: 40px;}
	.login_adv__title div i.add {font-size: 20px;color: rgba(255,255,255,0.6);}
	.login_adv__bottom {position: absolute;left:0px;right: 0px;bottom: 0px;color: #fff;padding: 40px;background-image:linear-gradient(transparent, #000);}

	.login_main {flex: 1;overflow: auto;display:flex;}
	.login-form {width: 400px;margin: auto;padding:20px 0;}
	.login-header {margin-bottom: 35px;}
	.login-header .logo {display: flex;align-items: center;}
	.login-header .logo img {width: 35px;height: 35px;vertical-align: bottom;margin-right: 10px;}
	.login-header .logo label {font-size: 24px;}
	.login-header h2 {font-size: 24px;font-weight: bold;margin-top: 50px;}
	.login-oauth {display: flex;justify-content:space-around;}
	.login-form .el-divider {margin-top:40px;}

	.login_config {position: absolute;top:20px;right: 20px;}
	.el-dropdown-menu__item.selected {color: var(--el-color-primary);}
    .el-form-item {
        margin-bottom: 35px;
    }
	@media (max-width: 1200px){
		.login-form {width: 340px;}
	}
	@media (max-width: 1000px){
		.login_main {display: block;}
		.login-form {width:100%;padding:20px 40px;}
		.login_adv {display: none;}
	}
</style>
