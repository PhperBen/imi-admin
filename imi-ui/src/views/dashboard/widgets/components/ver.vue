<template>
	<el-card shadow="hover" header="版本信息">
		<div style="height: 210px;text-align: center;">
			<img src="img/ver.svg" style="height:140px"/>
			<h2 style="margin-top: 15px;">imi-admin</h2>
		</div>
		<div style="margin-top: 20px;">
			<el-button type="primary" plain round @click="golog">更新日志</el-button>
			<el-button type="primary" plain round @click="gogit">gitee</el-button>
		</div>
	</el-card>
</template>

<script>
	export default {
		title: "版本信息",
		icon: "el-icon-monitor",
		description: "当前项目版本信息",
		data() {
			return {
				ver: 'loading...'
			}
		},
		mounted() {
		},
		methods: {
			golog(){
				window.open("https://gitee.com/phpben/imi-admin/releases")
			},
			gogit(){
				window.open("https://gitee.com/phpben/imi-admin")
			}
		}
	}
</script>
