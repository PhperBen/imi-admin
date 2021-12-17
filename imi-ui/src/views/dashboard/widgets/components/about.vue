<template>
	<el-card shadow="hover" header="关于项目" class="item-background">
		<p>基于 后端 Imi + 前端 Scui 进行开发，专注于高效快速开发的后台管理框架。</p>
		<p>
			<a href='https://gitee.com/phpben/imi-admin' target="_blank">
				<img src='https://gitee.com/phpben/imi-admin/badge/star.svg?theme=dark' alt='star' style="vertical-align: middle">
			</a>
		</p>
	</el-card>
</template>

<script>
	export default {
		title: "关于项目",
		icon: "el-icon-setting",
		description: "点个星星支持一下",
		data() {
			return {

			}
		}
	}
</script>

<style scoped>
	.item-background p {color: #999;margin-top:10px;line-height: 1.8;}
</style>
