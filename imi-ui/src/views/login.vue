<template>
	<div class="login_bg">
		<div class="login_adv" style="background-image: url(img/auth_banner.jpg);">
			<div class="login_adv__title">
				<h2>IMI Admin</h2>
				<h4>极速性能 / 快速开发 / 安全稳定</h4>
				<p>基于Imi + Scui的后台管理框架</p>
				<div>
					<span>
						<el-icon><sc-icon-vue/></el-icon>
					</span>
					<span>
						<el-icon class="add"><el-icon-plus/></el-icon>
					</span>
					<span>
						<el-icon><el-icon-eleme-filled/></el-icon>
					</span>
				</div>
			</div>
			<div class="login_adv__mask"></div>
			<div class="login_adv__bottom">
				© Imi-Admin
			</div>
		</div>
		<div class="login_main">
			<div class="login_config">
				<el-button :icon="config.dark?'el-icon-sunny':'el-icon-moon'" circle type="info" @click="configDark"></el-button>
				<el-dropdown trigger="click" placement="bottom-end" @command="configLang">
					<el-button circle>
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 512 512"><path d="M478.33 433.6l-90-218a22 22 0 0 0-40.67 0l-90 218a22 22 0 1 0 40.67 16.79L316.66 406h102.67l18.33 44.39A22 22 0 0 0 458 464a22 22 0 0 0 20.32-30.4zM334.83 362L368 281.65L401.17 362z" fill="currentColor"></path><path d="M267.84 342.92a22 22 0 0 0-4.89-30.7c-.2-.15-15-11.13-36.49-34.73c39.65-53.68 62.11-114.75 71.27-143.49H330a22 22 0 0 0 0-44H214V70a22 22 0 0 0-44 0v20H54a22 22 0 0 0 0 44h197.25c-9.52 26.95-27.05 69.5-53.79 108.36c-31.41-41.68-43.08-68.65-43.17-68.87a22 22 0 0 0-40.58 17c.58 1.38 14.55 34.23 52.86 83.93c.92 1.19 1.83 2.35 2.74 3.51c-39.24 44.35-77.74 71.86-93.85 80.74a22 22 0 1 0 21.07 38.63c2.16-1.18 48.6-26.89 101.63-85.59c22.52 24.08 38 35.44 38.93 36.1a22 22 0 0 0 30.75-4.9z" fill="currentColor"></path></svg>
					</el-button>
					<template #dropdown>
						<el-dropdown-menu>
							<el-dropdown-item v-for="item in lang" :key="item.value" :command="item" :class="{'selected':config.lang==item.value}">{{item.name}}</el-dropdown-item>
						</el-dropdown-menu>
					</template>
				</el-dropdown>
			</div>
			<div class="login-form">
				<div class="login-header">
					<div class="logo">
						<img :alt="$CONFIG.APP_NAME" src="img/logo.png">
						<label>{{$CONFIG.APP_NAME}}</label>
					</div>
				</div>
				<el-form ref="loginForm" :model="ruleForm" :rules="rules" label-width="0" size="large">
					<el-form-item prop="user">
						<el-input v-model="ruleForm.username" prefix-icon="el-icon-user" clearable
								  placeholder="请输入账号"></el-input>
					</el-form-item>
					<el-form-item prop="password">
						<el-input v-model="ruleForm.password" prefix-icon="el-icon-lock" clearable show-password
								  placeholder="请输入密码"></el-input>
					</el-form-item>
					<el-form-item>
						<el-button type="primary" style="width: 100%;" :loading="islogin" round @click="login">
							{{ $t('login.signIn') }}
						</el-button>
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
				lang: this.$TOOL.data.get('APP_LANG') || this.$CONFIG.LANG,
				dark: this.$TOOL.data.get('APP_DARK') || false
			},
			lang: [
				{
					name: '简体中文',
					value: 'zh-cn',
				},
				{
					name: 'English',
					value: 'en',
				}
			],
		}
	},
	watch: {
		'config.dark'(val){
			if(val){
				document.documentElement.classList.add("dark")
				this.$TOOL.data.set("APP_DARK", val)
			}else{
				document.documentElement.classList.remove("dark")
				this.$TOOL.data.remove("APP_DARK")
			}
		},
		'config.lang'(val){
			this.$i18n.locale = val
			this.$TOOL.data.set("APP_LANG", val)
		}
	},
	created: function () {
		this.$TOOL.cookie.remove("TOKEN")
		this.$TOOL.data.remove("USER_INFO")
		this.$TOOL.data.remove("MENU")
		this.$TOOL.data.remove("PERMISSIONS")
		this.$TOOL.data.remove("grid")
		this.$store.commit("clearViewTags")
		this.$store.commit("clearKeepLive")
		this.$store.commit("clearIframeList")
	},
	methods: {
		configDark(){
			this.config.dark = this.config.dark ? false : true
		},
		async login() {

			var validate = await this.$refs.loginForm.validate().catch(()=>{})
			if(!validate){ return false }

			this.islogin = true
			var data = {
				username: this.ruleForm.username,
				password: this.ruleForm.password
			}
			//获取token
			var user = await this.$API.common.login.post(data)
			if (user.code == 200) {
				this.$TOOL.cookie.set("TOKEN", user.data.token, {
					expires: 24*60*60
				})
				this.$TOOL.data.set("USER_INFO", user.data)
			} else {
				this.islogin = false
				this.$message.warning(user.message)
				return false
			}
			//获取菜单
			var menu = await this.$API.common.auth.get()
			if (menu.code == 200) {
				if (menu.data.menu.length == 0) {
					this.islogin = false
					this.$alert("当前用户无任何菜单权限，无法登陆", "无权限访问", {
						type: 'error',
						center: true
					})
					return false
				}
				this.$TOOL.data.set("MENU", menu.data.menu)
				this.$TOOL.data.set("PERMISSIONS", menu.data.permissions)
			} else {
				this.islogin = false
				this.$message.warning(menu.message)
				return false
			}
			const getFirst = function (data) {
				if (data.children && data.children.length) {
					return getFirst(data.children);
				} else {
					return data[0].path;
				}
			};
			let path = getFirst(menu.data.menu[0]);
			this.$TOOL.data.set("DEFAULT_ROUTE_PATH", path)
			this.$router.replace({
				path: path
			})
			this.$message.success(user.message)
			this.islogin = false
		},
		configLang(command){
			this.config.lang = command.value
		},
	}
}
</script>

<style scoped>
	.login_bg {width: 100%;height: 100%;background: #fff;display: flex;}
	.login_adv {width: 33.33333%;background-color: #555;background-size: cover;background-position: center center;background-repeat: no-repeat;position: relative;}
	.login_adv__title {color: #fff;padding: 40px;position: absolute;top:0px;left:0px;right: 0px;z-index: 2;}
	.login_adv__title h2 {font-size: 40px;}
	.login_adv__title h4 {font-size: 18px;margin-top: 10px;font-weight: normal;}
	.login_adv__title p {font-size: 14px;margin-top:10px;line-height: 1.8;color: rgba(255,255,255,0.6);}
	.login_adv__title div {margin-top: 10px;display: flex;align-items: center;}
	.login_adv__title div span {margin-right: 15px;}
	.login_adv__title div i {font-size: 40px;}
	.login_adv__title div i.add {font-size: 20px;color: rgba(255,255,255,0.6);}
	.login_adv__bottom {position: absolute;left:0px;right: 0px;bottom: 0px;color: #fff;padding: 40px;background-image:linear-gradient(transparent, #000);z-index: 3;}
	.login_adv__mask {position: absolute;top:0px;left:0px;right: 0px;bottom: 0px;background: rgba(0,0,0,0.5);z-index: 1;}

	.login_main {flex: 1;overflow: auto;display:flex;}
	.login-form {width: 400px;margin: auto;padding:20px 0;}
	.login-header {margin-bottom: 40px;}
	.login-header .logo {display: flex;align-items: center;}
	.login-header .logo img {width: 40px;height: 40px;vertical-align: bottom;margin-right: 10px;}
	.login-header .logo label {font-size: 26px;font-weight: bold;}
	.login-oauth {display: flex;justify-content:space-around;}
	.login-form .el-divider {margin-top:40px;}

	.login-form {}
	.login-form:deep(.el-tabs) .el-tabs__header {margin-bottom: 25px;}
	.login-form:deep(.el-tabs) .el-tabs__header .el-tabs__item {font-size: 14px;}

	.login-form:deep(.login-forgot) {text-align: right;}
	.login-form:deep(.login-forgot) a {color: var(--el-color-primary);}
	.login-form:deep(.login-forgot) a:hover {color: var(--el-color-primary-light-3);}
	.login-form:deep(.login-reg) {font-size: 14px;color: var(--el-text-color-primary);}
	.login-form:deep(.login-reg) a {color: var(--el-color-primary);}
	.login-form:deep(.login-reg) a:hover {color: var(--el-color-primary-light-3);}

	.login_config {position: absolute;top:20px;right: 20px;}

	.login-form:deep(.login-msg-yzm) {display: flex;width: 100%;}
	.login-form:deep(.login-msg-yzm) .el-button {margin-left: 10px;--el-button-size:42px;}

	.qrCodeLogin {text-align: center;position: relative;padding: 20px 0;}
	.qrCodeLogin img.qrCode {background: #fff;padding:20px;border-radius:10px;}
	.qrCodeLogin p.msg {margin-top: 15px;}
	.qrCodeLogin .qrCodeLogin-result {position: absolute;top:0;left:0;right: 0;bottom: 0;text-align: center;background: var(--el-mask-color);}

	@media (max-width: 1200px){
		.login-form {width: 340px;}
	}
	@media (max-width: 1000px){
		.login_main {display: block;}
		.login_main .login_config {position: static;padding:20px 20px 0 20px;text-align: right;}
		.login-form {width:100%;padding:20px 40px;}
		.login_adv {display: none;}
	}
</style>
