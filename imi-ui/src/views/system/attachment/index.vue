<template>
	<el-main>
		<el-card shadow="never">
			<imi-file-select v-model="file" :multiple="true" :hideUpload="hideUpload" :max="99" >
			</imi-file-select>
		</el-card>
	</el-main>
</template>
<script>
import imiFileSelect from '@/components/imiFileSelect'
export default {
	name: 'fileselect',
	components: {
		imiFileSelect
	},
	data() {
		return {
			file: '',
		}
	},
	mounted() {

	},
	methods: {
	}
}
</script>
