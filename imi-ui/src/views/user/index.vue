<template>
    <el-container>
        <el-header>
            <div class="left-panel">
                <el-button type="primary" icon="el-icon-plus" v-auth="'user.create'" @click="create"></el-button>
                <el-button type="danger" plain icon="el-icon-delete" v-auth="'user.delete'" v-if="selection.length>0" :disabled="selection.length==0" @click="dels"></el-button>
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
                <el-table-column label="id" prop="id" >

				</el-table-column>
                <el-table-column label="状态" prop="status" >
                    <template #default="scope">
                    <el-switch v-model="scope.row.status" @change="this.$TABLE.change(scope.row.id,$event,'status',this.$API.user.operate)" :active-value="1" :inactive-value="0"></el-switch>
                    </template>
				</el-table-column>
                <el-table-column label="账号" prop="username" >

				</el-table-column>
                <el-table-column label="邮箱" prop="email" >

				</el-table-column>
                <el-table-column label="手机号码" prop="mobile" >

				</el-table-column>
                <el-table-column label="余额" prop="money" >

				</el-table-column>
                <el-table-column label="创建时间" prop="create_time"  align="right" width="180" :formatter="this.$TABLE.datetime">

				</el-table-column>
                <el-table-column label="更新时间" prop="update_time"  align="right" width="180" :formatter="this.$TABLE.datetime">

				</el-table-column>

                <el-table-column label="操作" fixed="right" align="right" width="140">
                    <template #default="scope">
                        <el-button type="text" v-auth="'user.update'" size="small" @click="update(scope.row)">编辑
                        </el-button>
                        <el-popconfirm title="确定删除吗？" @confirm="del(scope.row)">
                            <template #reference>
                                <el-button type="text" v-auth="'user.delete'" size="small">删除</el-button>
                            </template>
                        </el-popconfirm>
                    </template>
                </el-table-column>
            </scTable>
        </el-main>
    </el-container>
    <save-dialog v-if="dialog.save" ref="saveDialog" @success="handleSuccess" @closed="dialog.save=false"></save-dialog>
</template>
<script>
    import saveDialog from './save';
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
                        label: 'id',
                        value: 'id',
                        type: 'text',
                        operator: '=',
                    },
					{
                        label: '状态',
                        value: 'status',
                        type: 'select',
                        operator: '=',
                    	extend: {
                            data: [{label:"开启",value:1},{label:"关闭",value:0}]
	                    }
					},
					{
                        label: '账号',
                        value: 'username',
                        type: 'text',
                        operator: '=',
                    },
					{
                        label: '密码',
                        value: 'password',
                        type: 'text',
                        operator: '=',
                    },
					{
                        label: '邮箱',
                        value: 'email',
                        type: 'text',
                        operator: '=',
                    },
					{
                        label: '手机号码',
                        value: 'mobile',
                        type: 'text',
                        operator: '=',
                    },
					{
                        label: '余额',
                        value: 'money',
                        type: 'between',
                        operator: 'between',
                    },
					{
                        label: '创建时间',
                        value: 'create_time',
                        type: 'datetimerange',
                        operator: 'between',
                    },
					{
                        label: '更新时间',
                        value: 'update_time',
                        type: 'datetimerange',
                        operator: 'between',
                    },

                ],
                dialog: {
                    save: false
                },
                apiObj: this.$API.user.read,
                selection: [],
                search: '',
                params:{},
            }
        },
        created() {
            this.$TABLE.setFilterValue(this);

        },
        methods: {
            filterChange(data) {
                this.$TABLE.filter(data, this);
            },
            create() {
                this.dialog.save = true
                this.$nextTick(() => {
                    this.$refs.saveDialog.open()
                })
            },
            update(row) {
                this.dialog.save = true
                this.$nextTick(() => {
                    this.$refs.saveDialog.open('update').setData(row)
                })
            },
            async del(row) {
                var res = await this.$API.user.delete.post({ids: row.id});
                if (res.code == 200) {
                    this.$refs.table.refresh()
                    this.$message.success(res.message)
                } else {
                    this.$alert(res.message, "提示", {type: 'error'})
                }
            },
            async dels() {
                if (!this.selection.length) {
                    this.$message.warning("请选择要删除的数据")
                    return false;
                }
                var ids = [];
                for (const i in this.selection) {
                    ids.push(this.selection[i].id)
                }
                this.$confirm(`确定删除选中的 ${this.selection.length} 项吗？`, '提示', {
                    type: 'warning'
                }).then(() => {
                    const loading = this.$loading();
                    this.$API.user.delete.post({ids:ids}).then(res => {
                        if (res.code == 200) {
                            this.$refs.table.refresh()
                            this.$message.success(res.message)
                        } else {
                            this.$message.error(res.message)
                        }
                        loading.close();
                    });
                })
            },
            selectionChange(selection) {
                this.selection = selection;
            },
            handleSuccess() {
                this.$refs.table.refresh()
            }
        }
    }
</script>
