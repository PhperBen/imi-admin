<template>
    <el-dialog :title="titleMap[mode]" v-model="visible" :width="500" destroy-on-close @closed="$emit('closed')">
        <el-form :model="form" :rules="rules" :disabled="mode=='show'" ref="dialogForm" label-width="120px" label-position="left">
            <el-form-item label="状态" prop="status">
                <el-switch v-model="form.status" :active-value="1" :inactive-value="0"></el-switch>
        	</el-form-item>
            <el-form-item label="账号" prop="username">
                <el-input v-model="form.username" clearable></el-input>
        	</el-form-item>
            <el-form-item label="密码" prop="password">
                <el-input v-model="form.password" clearable></el-input>
        	</el-form-item>
            <el-form-item label="邮箱" prop="email">
                <el-input v-model="form.email" clearable></el-input>
        	</el-form-item>
            <el-form-item label="手机号码" prop="mobile">
                <el-input v-model="form.mobile" clearable></el-input>
        	</el-form-item>
            <el-form-item label="余额" prop="money">
                <el-input-number v-model="form.money"></el-input-number>
        	</el-form-item>
        </el-form>
        <template #footer>
            <el-button @click="visible=false" >取 消</el-button>
            <el-button v-if="mode!='read'" type="primary" :loading="isSaveing" @click="submit()">保 存</el-button>
        </template>
    </el-dialog>
</template>

<script>

    export default {
        emits: ['success', 'closed'],

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
                    id: 0,
					status: 1,
					username: '',
					password: '',
					email: '',
					mobile: '',
					money: 0,
                },
                rules: {
                },
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
                        var res = await this.$API.user[this.mode].post(this.form);
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
