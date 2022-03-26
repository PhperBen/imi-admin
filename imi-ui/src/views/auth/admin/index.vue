<template>
	<el-container>
		<el-aside width="200px" v-if="groupShow" v-auth="'auth.group.read'" v-loading="showGrouploading">
			<el-container>
				<el-header>
					<el-input placeholder="搜索" v-model="groupFilterText" clearable></el-input>
				</el-header>
				<el-main class="nopadding">
					<el-tree ref="group" class="menu" node-key="id" :props="groupProps" :data="group" :current-node-key="''" :highlight-current="true" :expand-on-click-node="false" :filter-node-method="groupFilterNode" @node-click="groupClick"></el-tree>
				</el-main>
			</el-container>
		</el-aside>
		<el-container>
				<el-header>
					<div class="left-panel">
						<el-button type="primary" icon="el-icon-plus" v-auth="'auth.admin.create'" @click="add"></el-button>
						<el-button type="danger" plain icon="el-icon-delete"  v-auth="'auth.admin.delete'" v-show="selection.length>0" @click="batch_del"></el-button>
					</div>
					<div class="right-panel">
						<div class="right-panel-search">
							<el-input v-model="search" placeholder="搜索" @clear="this.$TABLE.searchSubmit(this)" clearable></el-input>
							<el-button type="primary" icon="el-icon-search" @click="this.$TABLE.searchSubmit(this)"></el-button>
							<imiFilterBar :options="options" @filterChange="filterChange"></imiFilterBar>
						</div>
					</div>
				</el-header>
				<el-main class="nopadding">
					<scTable ref="table" :apiObj="apiObj" :params="params" @selection-change="selectionChange" stripe remoteSort remoteFilter>
						<el-table-column type="selection" width="50"></el-table-column>
						<el-table-column label="ID" prop="id" width="80" sortable='custom'></el-table-column>
						<el-table-column label="头像" width="80">
							<template #default="scope">
								<el-avatar :src="scope.row.avatar" size="small"></el-avatar>
							</template>
						</el-table-column>
						<el-table-column label="账号" prop="username" width="150"></el-table-column>
						<el-table-column label="邮箱" prop="email" width="150" ></el-table-column>
						<el-table-column label="手机号码" prop="mobile" width="150" ></el-table-column>
						<!-- <el-table-column label="状态" prop="status" >
                            <template #default="scope">
                                <el-switch v-model="scope.row.status" @change="statusChange(scope.row.id,$event)" :active-value="1" :inactive-value="0"></el-switch>
                            </template>
                        </el-table-column> -->
						<el-table-column label="用户组" prop="groups_text">
                            <template #default="scope">
                                <span v-for="(item,key) in scope.row.groups_text" :key="key">{{item}}<span v-if="key !== (scope.row.groups_text.length-1)">,</span></span>
                            </template>
                        </el-table-column>
						<el-table-column label="创建时间" prop="create_time" align="right" width="180" :formatter="this.$TABLE.datetime"></el-table-column>
				        <el-table-column label="更新时间" prop="update_time" align="right" width="180" :formatter="this.$TABLE.datetime"></el-table-column>
						<el-table-column label="操作" fixed="right" align="right" width="140">
							<template #default="scope">
								<el-button type="text" v-auth="'auth.admin.update'" size="small" @click="table_edit(scope.row, scope.$index)">编辑</el-button>
								<el-popconfirm title="确定删除吗？" v-auth="'auth.admin.delete'" @confirm="table_del(scope.row, scope.$index)">
									<template #reference>
										<el-button type="text" size="small">删除</el-button>
									</template>
								</el-popconfirm>
							</template>
						</el-table-column>

					</scTable>
				</el-main>
		</el-container>
	</el-container>

	<save-dialog v-if="dialog.save" ref="saveDialog" @success="handleSuccess" @closed="dialog.save=false"></save-dialog>

</template>

<script>
	import saveDialog from './save'
    import filterBar from '@/config/filterBar'
	import imiFilterBar from '@/components/imiFilterBar';
	export default {
		name: 'user',
		components: {
			saveDialog,
			imiFilterBar
		},
		data() {
			return {
				options: [
					{
						label: 'ID',
						value: 'id',
						type: 'text'
					},
					{
						label: '邮箱',
						value: 'email',
						type: 'text'
					},
					{
						label: '手机号码',
						value: 'mobile',
						type: 'text'
					},
					{
						label: '账号',
						value: 'username',
						type: 'text'
					},
					{
						label: '状态',
						value: 'type',
						type: 'select',
						extend: {
							data:[
								{
									label: "开启",
									value: 1
								},
								{
									label: "关闭",
									value: 0
								}
							]
						}
					},
					{
						label: '创建时间',
						value: 'create_time',
						type: 'datetimerange',
						operator:"between",
					},
					{
						label: '更新时间',
						value: 'update_time',
						type: 'datetimerange',
						operator:"between",
					},
				],
				dialog: {
					save: false
				},
				showGrouploading: false,
				groupFilterText: '',
				group: [],
				apiObj: this.$API.auth.admin.read,
				selection: [],
				search:'',
				params:{},
                groupShow:true,
                groupProps: {
					value: "id",
					emitPath: false,
					label: 'name',
					checkStrictly: true
				}
			}
		},
		watch: {
			groupFilterText(val) {
				this.$refs.group.filter(val);
			}
		},
		mounted() {
			this.getGroup()
		},
		methods: {
			filterChange(data){
				this.$TABLE.filter(data,this);
			},
            // statusChange(ids,value){
            //     this.$API.auth.admin.operate.post({ids:ids,status:value}).then(res=>{
            //         if(res.code != 200){
            //             this.$message.error(res.message);
            //         }
            //     });
            // },
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
			async table_del(row){
				var reqData = {ids: row.id}
				var res = await this.$API.auth.admin.delete.post(reqData);
				if(res.code == 200){
					this.$refs.table.refresh()
					this.$message.success(res.message)
				}else{
					this.$alert(res.message, "提示", {type: 'error'})
				}
			},
			//批量删除
			async batch_del(){
                if(!this.selection.length){
                    this.$message.warning("请选择要删除的数据")
                    return false;
                }
                var ids = [];
                for(const i in this.selection){
                    ids.push(this.selection[i].id)
                }
				this.$confirm(`确定删除选中的 ${this.selection.length} 项吗？`, '提示', {
					type: 'warning'
				}).then(() => {
					const loading = this.$loading();
                    this.$API.auth.admin.delete.post({ids:ids}).then(res=>{
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
			//加载树数据
			async getGroup(){
				this.showGrouploading = true;
				var res = await this.$API.auth.group.read.get();
				this.showGrouploading = false;
				var allNode ={id: 0, name: '全部'}
				res.data.unshift(allNode);
				this.group = res.data;
                if(res.data.length == 0){
                    this.groupShow = false;
                }
			},
			//树过滤
			groupFilterNode(value, data){
				if (!value) return true;
				return data.name.indexOf(value) !== -1;
			},
			//树点击事件
			groupClick(data){
				var params = {
					filter:JSON.stringify({
                        'authGroupAccess.gid':data.id+filterBar.separator+'='
                    })
				}
                if(data.id == 0 || !data.id){
                    params = {};
                }
				this.$refs.table.reload(params)
			},
			//本地更新数据
			handleSuccess(){
				this.$refs.table.refresh()
			}
		}
	}
</script>

<style>
</style>
