<template>
    <el-container>
        <el-header>
            <div class="left-panel">
                <el-button type="primary" icon="el-icon-plus" v-auth="'<?php echo $auth; ?>.create'" @click="create"></el-button>
                <el-button type="danger" plain icon="el-icon-delete" v-auth="'<?php echo $auth; ?>.delete'" v-if="selection.length>0" :disabled="selection.length==0" @click="dels"></el-button>
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
            <scTable ref="table" row-key="<?php echo $pri; ?>" :apiObj="apiObj" :params="params" @selection-change="selectionChange" stripe remoteSort remoteFilter>
                <el-table-column type="selection" width="50"></el-table-column>
                <?php foreach($columns as $column){ ?><el-table-column label="<?php echo $column['name']; ?>" prop="<?php echo $column['key']; ?>" <?php if($column['type'] == 'datetime'){ echo ' align="right" width="180" :formatter="this.$TABLE.datetime"'; } ?>>
                    <?php if($column['type'] == 'switch'){ ?><template #default="scope">
                    <el-switch v-model="scope.row.<?php echo $column['key']; ?>" @change="this.$TABLE.change(scope.row.id,$event,'<?php echo $column['key']; ?>',this.$API.<?php echo $api; ?>.operate)" :active-value="1" :inactive-value="0"></el-switch>
                    </template><?php }elseif($column['type'] == 'sort'){ ?><template #default>
                    <el-tag class="move" style="cursor: move;"><el-icon-d-caret style="width: 1em; height: 1em;"/></el-tag>
                    </template><?php }elseif($column['type'] == 'image'){ ?><template #default="scope">
                    <el-avatar :src="scope.row.<?php echo $column['key']; ?>" size="small"></el-avatar>
                    </template><?php }elseif($column['type'] == 'tag'){ ?><template #default="scope">
                    <el-tag size="small">{{scope.row.<?php echo $column['key']; ?>}}</el-tag>
                    </template><?php  } ?>
                <?php echo "\n\t\t\t\t".'</el-table-column>'."\n"; ?>
                <?php } echo "\n"; ?>
                <el-table-column label="操作" fixed="right" align="right" width="140">
                    <template #default="scope">
                        <el-button type="text" v-auth="'<?php echo $auth; ?>.update'" size="small" @click="update(scope.row)">编辑
                        </el-button>
                        <el-popconfirm title="确定删除吗？" @confirm="del(scope.row)">
                            <template #reference>
                                <el-button type="text" v-auth="'<?php echo $auth; ?>.delete'" size="small">删除</el-button>
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
        name: '<?php echo $auth; ?>',
        components: {
            saveDialog,
            imiFilterBar
        },
        data() {
            return {
                options: [
                    <?php foreach($filter as $v){ ?>{
                        label: '<?php echo $v['name']; ?>',
                        value: '<?php echo $v['key']; ?>',
                        type: '<?php echo $v['type']; ?>',
                        operator: '<?php echo $v['operator']; ?>',
                    <?php if($v['data']) { echo "\t";?>extend: {
                            data: <?php echo $v['data']."\n\t";?>
                    }<?php echo "\n\t\t\t\t\t";} ?>},<?php echo "\n\t\t\t\t\t"; }  ?>
                    <?php echo "\n"; ?>
                ],
                dialog: {
                    save: false
                },
                apiObj: this.$API.<?php echo $api; ?>.read,
                selection: [],
                search: '',
                params:{},
            }
        },
        created() {
            this.$TABLE.setFilterValue(this);
        },
        mounted() {
            <?php if($sort){ ?>this.$TABLE.rowDrop(this,this.$API.<?php echo $api; ?>.sort);<?php } echo "\n"; ?>
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
                var res = await this.$API.<?php echo $api; ?>.delete.post({ids: row.id});
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
                    ids.push(this.selection[i].<?php echo $pri; ?>)
                }
                this.$confirm(`确定删除选中的 ${this.selection.length} 项吗？`, '提示', {
                    type: 'warning'
                }).then(() => {
                    const loading = this.$loading();
                    this.$API.<?php echo $api; ?>.delete.post({ids:ids}).then(res => {
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