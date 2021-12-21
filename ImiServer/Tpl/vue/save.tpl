<template>
    <el-dialog :title="titleMap[mode]" v-model="visible" :width="500" destroy-on-close @closed="$emit('closed')">
        <el-form :model="form" :rules="rules" :disabled="mode=='show'" ref="dialogForm" label-width="120px" label-position="left">
        <?php foreach($columns as $column){ ?>
    <el-form-item label="<?php echo $column['name']; ?>" prop="<?php echo $column['key']; ?>">
        <?php if($column['type'] == 'text'){ ?>
        <el-input v-model="form.<?php echo $column['key']; ?>" clearable></el-input>
        <?php }elseif($column['type'] == 'number'){ ?>
        <el-input-number v-model="form.<?php echo $column['key']; ?>"></el-input-number>
        <?php }elseif($column['type'] == 'select'){ ?>
        <el-select v-model="form.<?php echo $column['key']; ?>" clearable placeholder="请选择<?php echo $column['name']; ?>">
            <el-option v-for="(item,index) in <?php echo $column['key']; ?>_option" :key="index" :label="item" :value="index"></el-option>
        </el-select>
        <?php }elseif($column['type'] == 'textarea'){ ?>
        <el-input type="textarea" v-model="form.<?php echo $column['key']; ?>"></el-input>
        <?php }elseif($column['type'] == 'editor'){ ?><?php $sceditor = true; ?>
        <sc-editor v-model="form.<?php echo $column['key']; ?>" placeholder=""></sc-editor>
        <?php }elseif($column['type'] == 'datetime'){ ?>
        <el-date-picker v-model="form.<?php echo $column['key']; ?>" type="datetime"></el-date-picker>
        <?php }elseif($column['type'] == 'radio'){ ?>
        <el-radio v-model="form.<?php echo $column['key']; ?>" v-for="(item,index) in <?php echo $column['key']; ?>_option" :key="index" :label="index">{{item}}</el-radio>
        <?php }elseif($column['type'] == 'checkbox'){ ?>
        <el-checkbox-group v-model="form.<?php echo $column['key']; ?>">
            <el-checkbox v-for="(item,index) in <?php echo $column['key']; ?>_option" :key="index" :label="index">{{item}}</el-checkbox>
        </el-checkbox-group>
        <?php }elseif($column['type'] == 'switch'){ ?>
        <el-switch v-model="form.<?php echo $column['key']; ?>" :active-value="1" :inactive-value="0"></el-switch>
        <?php }elseif($column['type'] == 'image'){ ?>
        <sc-upload v-model="form.<?php echo $column['key']; ?>" icon="el-icon-picture-outline"></sc-upload>
        <?php }elseif($column['type'] == 'images'){ ?>
        <sc-upload-multiple v-model="form.<?php echo $column['key']; ?>"></sc-upload-multiple>
        <?php }elseif($column['type'] == 'color'){ ?>
        <el-color-picker v-model="form.<?php echo $column['key']; ?>" size="mini"></el-color-picker>
        <?php }elseif($column['type'] == 'slider'){ ?>
        <el-slider v-model="form.<?php echo $column['key']; ?>"></el-slider>
        <?php } echo "\t"; ?></el-form-item>
        <?php } ?></el-form>
        <template #footer>
            <el-button @click="visible=false" >取 消</el-button>
            <el-button v-if="mode!='read'" type="primary" :loading="isSaveing" @click="submit()">保 存</el-button>
        </template>
    </el-dialog>
</template>

<script>
    <?php if(isset($sceditor) && $sceditor){ ?>import { defineAsyncComponent } from 'vue';
    const scEditor = defineAsyncComponent(() => import('@/components/scEditor'));<?php } echo "\n"; ?>
    export default {
        emits: ['success', 'closed'],
        <?php if(isset($sceditor) && $sceditor){ ?>components: {
            scEditor
        },<?php } echo "\n"; ?>
        data() {
            return {
                mode: "create",
                titleMap: {
                    read: '查看',
                    create: '新增',
                    update: '编辑',
                },
                visible: false,
                isSaveing: false,
                form: {
                    <?php echo $pri; ?>: 0,
<?php foreach($columns as $column){ ?><?php echo "\t\t\t\t\t".$column['key']; ?>: '',<?php echo "\n"; } ?>
                },
                rules: {
                },
<?php foreach($columns as $column){ ?><?php if($column['option']){ ?><?php echo "\t\t\t\t";echo $column["key"]; ?>_option:<?php echo $column['option']; ?>,<?php echo "\n";} ?><?php } ?>
            }
        },
        methods: {
            open(mode='create'){
                this.mode = mode;
                this.visible = true;
                return this
            },
            submit(){
                this.$refs.dialogForm.validate(async (valid) => {
                    if (valid) {
                        this.isSaveing = true;
                        var res = await this.$API.<?php echo $api; ?>[this.mode].post(this.form);
                        this.isSaveing = false;
                        if(res.code == 200){
                            this.$emit('success', this.form, this.mode)
                            this.visible = false;
                            this.$message.success(res.message)
                        }else{
                            this.$alert(res.message, "提示", {type: 'error'})
                        }
                    }else{
                        return false;
                    }
                })
            },
            setData(data){
                this.$TABLE.assign(this,data);
            }
        }
    }
</script>