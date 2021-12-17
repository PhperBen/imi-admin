<template>
	<el-dialog title="资源库" v-model="visible" :width="1200" top="3%" destroy-on-close @closed="$emit('closed')">

	<el-main>
		<el-card shadow="never">
			<imi-file-select v-model="file" :multiple="multiple?true:false" :get="true" :max="99" @submit="submit">
			</imi-file-select>
		</el-card>
	</el-main>

	</el-dialog>
</template>
<script>
import imiFileSelect from '@/components/imiFileSelect'
export default {
    emits: ['success', 'closed'],
    props: ['multiple'],
	name: 'fileselect',
	components: {
		imiFileSelect
	},
	data() {
		return {
            visible: true,
			file: '',
		}
	},
	mounted() {

	},
	methods: {
		open(){
			this.visible=true;
		},
		submit(value){
			this.$emit('success', value)
		}
	}
}
</script>
