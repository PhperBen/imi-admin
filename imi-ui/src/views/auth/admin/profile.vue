<template>
	<el-main>
		<el-row :gutter="15">
			<el-col :lg="8">
				<el-card class="card" shadow="never">
					<div class="user-info">
						<div class="user-info-top">
							<sc-upload style="border-radius:50%" v-model="form.avatar"></sc-upload>
							<h2>{{ userinfo.username }}</h2>
							<p>{{ userinfo.email }}</p>
						</div>
						<div class="user-info-main">
							<el-form ref="form" :model="form" label-width="80px">
								<el-form-item label="账号">
									<el-input v-model="form.username" disabled></el-input>
								</el-form-item>
								<el-form-item label="邮箱">
									<el-input v-model="form.email"></el-input>
								</el-form-item>
								<el-form-item label="密码">
									<el-input v-model="form.password" placeholder="不填则不修改密码"></el-input>
								</el-form-item>
								<el-form-item v-auth="['auth.admin.profile']">
									<el-button type="primary" @click="submit">保存</el-button>
								</el-form-item>
							</el-form>
						</div>
					</div>
				</el-card>
			</el-col>
			<el-col :lg="16">
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
                                <scTable :height="370" ref="table" :apiObj="apiObj2" :params="params" row-key="id" stripe>
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
			</el-col>
		</el-row>
	</el-main>

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
		name: 'profile',
		data() {
			return {
				form: {
					avatar: "",
					username: "",
					email: "",
					password: "",
				},
				content:"",
				useragent:"",
				loginfoVisible:false,
				userinfo:[],
				search:'',
				params:[],
				apiObj:this.$API.auth.admin.loginlog,
				apiObj2:this.$API.auth.admin.operatelog,
			}
		},
		created(){
			this.userinfo = this.$TOOL.data.get('USER_INFO');
			for(const i in this.form){
				this.form[i] = this.userinfo[i];
			}
		},
		methods: {
			loginfo(row){
				this.content = row.content;
				this.useragent = row.user_agent;
				this.loginfoVisible = true;
			},
			submit: async function() {
				var res = await this.$API.auth.admin.profile.post(this.form);
				if (res.code) {
					var newinfo = {};
					for(const i in this.userinfo){
						newinfo[i] = this.form[i] ? this.form[i] : this.userinfo[i]
					}
					this.$TOOL.data.set('USER_INFO',newinfo);
					this.$message.success(res.message)
				}else{
					this.$message.error(res.messagei)
				}
			},
		}
	}
</script>

<style scoped>

	.el-card {margin-bottom:15px;}
	.activity-item {font-size: 13px;color: #999;display: flex;align-items: center;}
	.activity-item label {color: #333;margin-right:10px;}
	.activity-item .el-avatar {margin-right:10px;}
	.activity-item .el-tag {margin-right:10px;}

	[data-theme='dark'] .user-info-bottom {border-color: var(--el-border-color-base);}
	[data-theme='dark'] .activity-item label {color: #999;}
	.user-info{
		padding-top: 15px;
		padding-right: 40px;
		padding-bottom: 0px;
		padding-left: 40px;
	}
	.user-info-top:deep(.el-image){
		border-radius: 50%;
		width: 110px;
		height: 110px;
	}
	.card:deep(.el-card__body){
		padding-bottom: 0px!important;
	}
</style>
