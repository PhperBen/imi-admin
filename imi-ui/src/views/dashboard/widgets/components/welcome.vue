<template>
	<el-card shadow="hover" header="欢迎">
		<div class="welcome">
			<div class="logo">
				<img src="img/logo.png">
				<h2>欢迎体验 imi-admin</h2>
			</div>
			<div class="tips">
				<div class="tips-item">
					<div class="tips-item-icon"><el-icon><el-icon-menu/></el-icon></div>
					<div class="tips-item-message"><a target="_blank" href="https://gitee.com/phpben/imi-admin"><span style="font-weight: bold;font-size: 15px;color:red">imi-admin</span> 后台管理框架</a></div>
				</div>
				<div class="tips-item">
					<div class="tips-item-icon"><el-icon><el-icon-menu/></el-icon></div>
					<div class="tips-item-message"><a target="_blank" href="https://www.imiphp.com/"><span style="font-weight: bold;font-size: 15px;color:red">imi</span> PHP长连接微服务分布式开发框架</a></div>
				</div>
				<div class="tips-item">
					<div class="tips-item-icon"><el-icon><el-icon-menu/></el-icon></div>
					<div class="tips-item-message"><a target="_blank" href="https://gitee.com/lolicode/scui"><span style="font-weight: bold;font-size: 15px;color:red">SCUI</span> 让前端开发更快乐</a></div>
				</div>
			</div>
			<div class="actions">
				<el-button type="primary" icon="el-icon-check" size="medium" @click="godoc">文档</el-button>
			</div>
		</div>
	</el-card>
</template>

<script>
	export default {
		title: "欢迎",
		icon: "el-icon-present",
		description: "项目特色以及文档链接",
		data() {
			return {

			}
		},
		methods: {
			godoc(){
				window.open("https://www.kancloud.cn/phpben/imi-admin")
			}
		}
	}
</script>

<style scoped>
	.welcome {}
	.welcome .logo {text-align: center;}
	.welcome .logo img {vertical-align: bottom;width: 100px;height: 100px;margin-bottom: 20px;}
	.welcome .logo h2 {font-size: 30px;font-weight: normal;display: flex;align-items: center;justify-content: center;}

	.tips {margin-top: 20px;padding:0 40px;}
	.tips-item {display: flex;align-items: center;justify-content: center;padding:7.5px 0;}
	.tips-item-icon {width: 40px;height:40px;display: flex;align-items: center;justify-content: center;border-radius: 50%;font-size: 18px;margin-right: 20px;color: var(--el-color-primary);background: rgba(180,180,180,0.1);}
	.tips-item-message {flex: 1;font-size: 14px;}

	.actions {text-align: center;margin: 40px 0 20px 0;}
</style>
