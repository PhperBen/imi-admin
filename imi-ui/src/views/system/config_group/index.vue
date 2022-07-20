<template>
<el-dialog title="配置分组" v-model="visible" :width="800" @opened="opened" destroy-on-close @closed="$emit('closed')">
		<el-header style="border:1px solid #f2f2f3">
			<div class="left-panel">
				<el-button type="primary"  v-auth="'system.config_group.create'" icon="el-icon-plus" @click="add"></el-button>
			</div>
		</el-header>
		<el-main class="nopadding" style="border:1px solid #f2f2f3">
			<scTable ref="table" :apiObj="apiObj" row-key="id" hidePagination>
				<el-table-column label="ID" prop="id" type="index">
                    <template #default="scope">
                        {{scope.row.id}}
                    </template>
                </el-table-column>
				<el-table-column label="名称" prop="name" width="250"></el-table-column>
				<el-table-column label="状态" prop="status" >
                    <template #default="scope">
                        <el-switch v-model="scope.row.status" @change="statusChange(scope.row.id,$event)" :active-value="1" :inactive-value="0"></el-switch>
                    </template>
                </el-table-column>
				<!-- <el-table-column label="时间" prop="create_time" align="right" :formatter="this.$TABLE.datetime"></el-table-column> -->
				<el-table-column label="操作" fixed="right" align="right" width="140">
					<template #default="scope">
						<el-button text v-auth="'system.config_group.update'" size="small" @click="table_edit(scope.row, scope.$index)">编辑</el-button>
						<el-divider direction="vertical"></el-divider>
						<el-popconfirm title="确定删除吗？" @confirm="table_del(scope.row, scope.$index)">
							<template #reference>
								<el-button text size="small" v-auth="'system.config_group.delete'">删除</el-button>
							</template>
						</el-popconfirm>
					</template>
				</el-table-column>

			</scTable>
		</el-main>

</el-dialog>
	<save-dialog v-if="dialog.save" ref="saveDialog" @success="handleSaveSuccess" @closed="dialog.save=false"></save-dialog>

</template>

<script>
	import saveDialog from './save'

	export default {
		name: 'system_config_group',
		components: {
			saveDialog,
		},
		emits: ['success', 'closed'],
		data() {
			return {
				dialog: {
					save: false,
				},
				visible:false,
				apiObj: this.$API.system.config.group.read,
			}
		},
        mounted() {
        },
		methods: {
			opened(){
				//this.$TABLE.rowDrop(this,this.$API.system.config.group.sort)
			},
			open(){
				this.visible = true;
				return this
			},
            statusChange(ids,value){
                this.$API.system.config.group.operate.post({ids:ids,status:value}).then(res=>{
                    if(res.code != 200){
                        this.$message.error(res.message);
                    }
                });
            },
			//添加
			add(){
				this.dialog.save = true
				this.$nextTick(() => {
					this.$refs.saveDialog.open()
				})
			},
			//编辑
			table_edit(row){
				this.dialog.save = true
				this.$nextTick(() => {
					this.$refs.saveDialog.open('update').setData(row)
				})
			},
			//删除
			async table_del(row){
				var reqData = {ids: row.id}
				var res = await this.$API.system.config.group.delete.post(reqData);
				if(res.code == 200){
					this.$refs.table.refresh()
					this.$message.success(res.message)
				}else{
					this.$alert(res.message, "提示", {type: 'error'})
				}
			},
			//本地更新数据
			handleSaveSuccess(){
				this.$refs.table.refresh()
			}
		}
	}
</script>

<style>
</style>
