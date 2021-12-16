<!-- 基于scfilterBar二次修改，scfileter功能与需求不符，见谅 -->
<template>
	<div class="sc-filterBar">
		<slot :filterLength="filterObjLength" :openFilter="openFilter">
			<el-badge :value="filterObjLength" type="danger" :hidden="filterObjLength<=0">
				<el-button size="small" icon="el-icon-filter" @click="openFilter"></el-button>
			</el-badge>
		</slot>
		<el-drawer title="高级搜索" v-model="drawer" :size="550" append-to-body>
			<el-container v-loading="saveLoading">
				<el-main style="padding:0;border-top: 1px solid #e6e6e6;">
					<div class="root">
                        <div class="sc-filter-main">
                            <div v-if="filter.length<=0"  class="nodata">
                                没有过滤条件
                            </div>
                            <table v-else>
                                <colgroup>
                                    <col width="45%">
                                    <col width="55%">
                                </colgroup>
                                <tr class="tdset" v-for="(item,index) in filter" :key="index">
                                    <td  style="display:flex;flex:1;flex-direction:row;width:100%">
                                        <el-input disabled v-model="item.field.label" style="width:55%;border-radius: 0px;"></el-input>
                                        <el-select v-model="item.operator" @change="operateChange(index,item.operator)" placeholder="运算符" style="width:45%;border-radius: 0px;">
                                            <el-option v-for="ope in item.field.operators || operator" :key="ope.value" :label="ope.label" :value="ope.value"></el-option>
                                        </el-select>
                                    </td>
                                    <td>
                                        <el-input v-if="!item.field.type" v-model="item.value" placeholder="没有可过滤类型" disabled></el-input>
                                        <!-- 输入框 -->
                                        <el-input v-if="item.field.type=='text'" v-model="item.value" :placeholder="item.field.placeholder||'请输入'"></el-input>
                                        <!-- 区间 仅限int类型 字符串也可以使用区间 但是要使用标签 因为int类型指1-100区间 字符串指在 xx，xxx，xxxx之间-->
										<div v-if="item.field.type=='between'" style="display:flex;flex:1;flex-direction:row;width:100%">
										<el-input v-model="item.value" :placeholder="item.field.placeholder||'开始值'"></el-input>
										<span style="color:#999;margin-top:8px;"> — </span>
                                        <el-input v-model="item.valueEnd" :placeholder="item.field.placeholder||'结束值'"></el-input>
										</div>
									    <!-- 下拉框 -->
                                        <el-select v-if="item.field.type=='select'" v-model="item.value" :placeholder="item.field.placeholder||'请选择'" filterable :multiple="item.field.extend.multiple" :loading="item.selectLoading" @visible-change="visibleChange($event, item)" :remote="item.field.extend.remote" :remote-method="(query)=>{remoteMethod(query, item)}">
                                            <el-option v-for="field in item.field.extend.data" :key="field.value" :label="field.label" :value="field.value"></el-option>
                                        </el-select>
                                        <!-- 日期 -->
                                        <el-date-picker v-if="item.field.type=='date'" v-model="item.value" type="date" value-format="YYYY-MM-DD" :placeholder="item.field.placeholder||'请选择日期'" style="width: 100%;"></el-date-picker>
                                        <!-- 日期范围 -->
                                        <el-date-picker v-if="item.field.type=='daterange'" v-model="item.value" :shortcuts="shortcuts" type="daterange" value-format="YYYY-MM-DD HH:mm:ss"  start-placeholder="开始日期" end-placeholder="结束日期" style="width: 100%;"></el-date-picker>
                                        <!-- 日期时间 -->
                                        <el-date-picker v-if="item.field.type=='datetime'" v-model="item.value" :shortcuts="shortcuts" type="datetime" value-format="YYYY-MM-DD HH:mm:ss" :placeholder="item.field.placeholder||'请选择日期'" style="width: 100%;"></el-date-picker>
                                        <!-- 日期时间范围 -->
                                        <el-date-picker v-if="item.field.type=='datetimerange'" v-model="item.value" :shortcuts="shortcuts" type="datetimerange" value-format="YYYY-MM-DD HH:mm:ss" start-placeholder="开始日期" end-placeholder="结束日期" style="width: 100%;"></el-date-picker>
                                        <!-- 开关 -->
                                        <el-switch v-if="item.field.type=='switch'" v-model="item.value" :active-value="1" :inactive-value="0"></el-switch>
                                        <!-- 标签 -->
                                        <el-select v-if="item.field.type=='tags'" v-model="item.value" multiple filterable allow-create default-first-option no-data-text="输入后按回车确认" :placeholder="item.field.placeholder||'请输入'"></el-select>
                                    </td>
                                </tr>
                            </table>
                        </div>
					</div>
				</el-main>
				<el-footer>
					<el-button type="primary" @click="ok" >搜 索</el-button>
					<el-button @click="clear">清 空</el-button>
				</el-footer>
			</el-container>
		</el-drawer>
	</div>
</template>

<script>
	import config from "@/config/filterBar"
	import pySelect from '@/components/scFilterBar/pySelect'

	export default {
		name: 'filterBar',
		components: {
			pySelect,
		},
		props: {
			filterName: { type: String, default: "" },
			options: { type: Object, default: () => {} }
		},
		data() {
			return {
				drawer: false,
				operator: config.operator,
				fields: this.options,
				filter: [],
				myFilter: [],
				filterObjLength: 0,
				saveLoading: false,
                shortcuts: [
					{
						text: '今日',
						value: () => {
							const end = new Date(new Date(new Date().toLocaleDateString()).getTime()+24*60*60*1000-1);
							const start = new Date(new Date(new Date().toLocaleDateString()).getTime())
							return [start, end]
						},
					},
					{
						text: '昨日',
						value: () => {
							const end = new Date(new Date(new Date().toLocaleDateString()).getTime()-1000);
							const start = new Date(new Date(new Date().toLocaleDateString()).getTime()-(24*60*60*1000))
							return [start, end]
						},
					},
					{
						text: '最近一周',
						value: () => {
							const end = new Date()
							const start = new Date()
							start.setTime(start.getTime() - 3600 * 1000 * 24 * 7)
							return [start, end]
						},
					},
					{
						text: '最近一个月',
						value: () => {
							const end = new Date()
							const start = new Date()
							start.setTime(start.getTime() - 3600 * 1000 * 24 * 30)
							return [start, end]
						},
					},
					{
						text: '最近三个月',
						value: () => {
							const end = new Date()
							const start = new Date()
							start.setTime(start.getTime() - 3600 * 1000 * 24 * 90)
							return [start, end]
						},
					},
				],
			}
		},
		computed: {
			filterObj(){
				const obj = {}
				this.filter.forEach((item) => {
					if(item.valueEnd){
					obj[item.field.value] = `${item.value},${item.valueEnd}${config.separator}${item.operator}`
					}else{
					obj[item.field.value] = `${item.value}${config.separator}${item.operator}`
					}
				})
				return obj
			}
		},
		mounted(){
			//默认显示的过滤项
			this.fields.forEach((item) => {
                this.filter.push({
                    field: item,
                    operator: item.operator || '=',
					value: item.default ? item.default : ''
                })
			})
		},
		methods: {
			operateChange(index,value){
				if(value == 'between' || value == 'not between'){
					this.filter[index].field.dtype = this.filter[index].field.type
					this.filter[index].field.type = 'between'
				}else{
					if(this.filter[index].field.dtype){
						this.filter[index].field.type = this.filter[index].field.dtype
						this.filter[index].field.dtype = false;
					}else{
						this.filter[index].field.type = 'text'
					}
				}
			},
			//打开过滤器
			openFilter(){
				this.drawer = true
			},
			//下拉框显示事件处理异步
			async visibleChange(isopen, item){
				if(isopen && item.field.extend.request && !item.field.extend.remote){
					item.selectLoading = true;
					try {
						var data = await item.field.extend.request()
					}catch (error) {
						console.log(error);
					}
					item.field.extend.data = data;
					item.selectLoading = false;
				}
			},
			//下拉框显示事件处理异步搜索
			async remoteMethod(query, item){
				if(query !== ''){
					item.selectLoading = true;
					try {
					var data = await item.field.extend.request(query);
					}catch (error) {
						console.log(error);
					}
					item.field.extend.data = data;
					item.selectLoading = false;
				}else{
					item.field.extend.data = [];
				}
			},
			//立即过滤
			setFilterLength(){
				let number = 0;
                for(const i in this.filter){
                    var value = this.filter[i].value;
                    if(value instanceof Array){
                        if(value.length>0){
                            number++;
                        }
                    }else{
                        if(value !== '' && value !== null && value && typeof(value) !== 'undefined'){
                            number++;
                        }
                    }
                }
				this.filterObjLength = number;
			},
			ok(){
                this.setFilterLength();
				this.$emit('filterChange',this.filterObj)
				this.drawer = false
			},
			//清空过滤
			clear(){
				for(const i in this.filter){
					this.filter[i].value = '';
				}
                this.setFilterLength();
				this.$emit('filterChange',this.filterObj)
				this.drawer = false
			}
		}
	}
</script>

<style scoped>
	.tabs-label {padding:0 20px;}

	.nodata {height:46px;line-height: 46px;margin:15px 0;border: 1px dashed #e6e6e6;color: #999;text-align: center;border-radius: 3px;}

	.sc-filter-main {padding:20px;background: #fff;}
	.sc-filter-main h2 {font-size: 12px;color: #999;font-weight: normal;}
	.sc-filter-main table {width: 100%;margin: 15px 0;}
	.sc-filter-main table tr {}
	.sc-filter-main table td {padding:5px 10px 5px 0;}
	.sc-filter-main table td:deep(.el-input .el-input__inner)  {vertical-align: top;}
	.sc-filter-main table td .el-select {display: block;}
	.sc-filter-main table td .el-date-editor.el-input {display: block;width: 100%;}
	.sc-filter-main table td .del {background: #fff;color: #999;width: 32px;height: 32px;line-height: 32px;text-align: center;border-radius:50%;font-size: 12px;cursor: pointer;}
	.sc-filter-main table td .del:hover {background: #F56C6C;color: #fff;}
    .tdset:deep(.el-input__inner){
        border-radius: 0px;
    }
    .tdset .el-input.is-disabled:deep(.el-input__inner){
        background-color: #ffffff;
        color:#606266;
        border-right: none;
    }
	.root {display: flex;height: 100%;flex-direction: column}
	.root:deep(.el-tabs__header) {margin: 0;}
	.root:deep(.el-tabs__content) {flex: 1;background: #f6f8f9;}
	.root:deep(.el-tabs__content) .el-tab-pane{overflow: auto;height:100%;}

	[data-theme='dark'] .root:deep(.el-tabs__content) {background: none;}
	[data-theme='dark'] .sc-filter-main {background: none;border-color:var(--el-border-color-base);}
	[data-theme='dark'] .sc-filter-main table td .del {background: none;}
	[data-theme='dark'] .sc-filter-main table td .del:hover {background: #F56C6C;}
	[data-theme='dark'] .nodata {border-color:var(--el-border-color-base);}
</style>
