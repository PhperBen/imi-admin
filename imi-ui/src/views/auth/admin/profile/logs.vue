<template>
	<el-card shadow="never">
		<el-tabs tab-position="top" >
			<el-tab-pane label="登陆日志">
				<el-main class="nopadding">
					<scTable :height="370" ref="table" :apiObj="apiObj" :params="params" row-key="id" stripe>
						<el-table-column label="账号" prop="username"></el-table-column>
						<el-table-column label="IP" prop="ip"></el-table-column>
						<el-table-column label="登陆时间" prop="create_time" :formatter="this.$TABLE.datetime"></el-table-column>
					</scTable>
				</el-main>
			</el-tab-pane>
			<el-tab-pane label="操作日志">
				<el-main class="nopadding">
					<scTable :height="370" ref="table2" :apiObj="apiObj2" :params="params2" row-key="id" stripe>
						<el-table-column label="账号" prop="username"></el-table-column>
						<el-table-column label="地址" prop="route"></el-table-column>
						<el-table-column label="IP" prop="ip"></el-table-column>
						<el-table-column label="时间" prop="create_time" :formatter="this.$TABLE.datetime"></el-table-column>
						<el-table-column label="操作" fixed="right" align="right" width="100">
							<template #default="scope">
								<el-button type="text" size="small" @click="this.loginfo(scope.row)">查看详情</el-button>
							</template>
						</el-table-column>
					</scTable>
				</el-main>
			</el-tab-pane>
		</el-tabs>
	</el-card>
	<el-drawer title="日志详情" v-model="loginfoVisible" :size="600" direction="rtl" destroy-on-close>
		<el-main  style="padding:0 20px;">
			<el-main  style="padding:0 20px 20px 20px;">
				<pre style="font-size: 12px;color: #999;padding:20px;background: #333;font-family: consolas;line-height: 1.5;white-space: break-spaces;word-break: break-all;">{{content}}</pre>
				<br>
				<pre style="font-size: 12px;color: #999;padding:20px;background: #333;font-family: consolas;line-height: 1.5;white-space: break-spaces;word-break: break-all;">{{useragent}}</pre>
			</el-main>
		</el-main>
	</el-drawer>
</template>

<script>
export default {
	data() {
		return {
			content:"",
			useragent:"",
			loginfoVisible:false,
			search:'',
			params:[],
			params2:[],
			apiObj:this.$API.auth.admin.loginlog,
			apiObj2:this.$API.auth.admin.operatelog,
		}
	},
	methods: {
		loginfo(row) {
			this.content = row.content;
			this.useragent = row.user_agent;
			this.loginfoVisible = true;
		},
	}
}
</script>

<style>
</style>
