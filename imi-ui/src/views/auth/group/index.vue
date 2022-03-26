<template>

	<el-container>
		<el-header>
			<div class="left-panel">
				<el-button type="primary" icon="el-icon-plus" v-auth="'auth.group.create'" @click="add"></el-button>
				<el-button type="danger" plain icon="el-icon-delete" v-auth="'auth.group.delete'" v-show="selection.length>0" @click="batch_del"></el-button>
			</div>
		</el-header>
		<el-main class="nopadding">
			<scTable ref="table" :apiObj="apiObj" row-key="id" @selection-change="selectionChange" hidePagination>
				<el-table-column type="selection" width="50"></el-table-column>
				<el-table-column label="ID" prop="id" type="index">
                    <template #default="scope">
                        {{scope.row.id}}
                    </template>
                </el-table-column>
				<el-table-column label="名称" prop="name" width="250"></el-table-column>
				<el-table-column label="创建时间" prop="create_time" align="right" :formatter="this.$TABLE.datetime"></el-table-column>
				<el-table-column label="更新时间" prop="update_time" align="right" width="180" :formatter="this.$TABLE.datetime"></el-table-column>
				<el-table-column label="操作" fixed="right" align="right" width="140">
					<template #default="scope">
                        <div v-if="scope.row.rules == '*'">超级管理</div>
						<el-button type="text" v-auth="'auth.group.update'" v-if="scope.row.rules !== '*'" size="small" @click="table_edit(scope.row, scope.$index)">编辑</el-button>
						<el-divider direction="vertical" v-if="scope.row.rules !== '*'"></el-divider>
						<el-popconfirm title="确定删除吗？" v-auth="'auth.group.delete'" v-if="scope.row.rules !== '*'" @confirm="table_del(scope.row, scope.$index)">
							<template #reference>
								<el-button type="text" size="small">删除</el-button>
							</template>
						</el-popconfirm>
					</template>
				</el-table-column>

			</scTable>
		</el-main>
	</el-container>

	<save-dialog v-if="dialog.save" ref="saveDialog" @success="handleSaveSuccess" @closed="dialog.save=false"></save-dialog>

</template>

<script>
	import saveDialog from './save'

	export default {
		name: 'role',
		components: {
			saveDialog,

		},
		data() {
			return {
				dialog: {
					save: false,
					permission: false
				},
				visible: false,
				apiObj: this.$API.auth.group.read,
				selection: [],
				search: {
					keyword: null
				}
			}
		},
		methods: {
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
				var res = await this.$API.auth.group.delete.post(reqData);
				if(res.code == 200){
					this.$refs.table.refresh()
					this.$message.success(res.message)
				}else{
					this.$alert(res.message, "提示", {type: 'error'})
				}
			},
			//批量删除
			batch_del(){
                if(!this.selection.length){
                    this.$message.warning("请选择要删除的数据")
                    return false;
                }
                var ids = [];
                for(const i in this.selection){
                    ids.push(this.selection[i].id)
                }
				this.$confirm(`确定删除选中的 ${this.selection.length} 项吗？如果删除项中含有子集将会被一并删除`, '提示', {
					type: 'warning'
				}).then(() => {
					const loading = this.$loading();
                    this.$API.auth.group.delete.post({ids:ids}).then(res=>{
                        if(res.code == 200){
                            this.$refs.table.refresh()
                            loading.close();
                            this.$message.success(res.message)
                        }else{
                            loading.close();
                            this.$message.error(res.message)
                        }
                    });

				}).catch(() => {

				})
			},
			//表格选择后回调事件
			selectionChange(selection){
				this.selection = selection;
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
