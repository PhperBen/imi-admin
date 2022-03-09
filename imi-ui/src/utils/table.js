import Sortable from 'sortablejs';
import filterBar from '@/config/filterBar';

const table = {}

table.rowDrop = function(that,api,id,pid){
	if(typeof(id) == 'undefined') id = 'id';
	if(typeof(pid) == 'undefined') pid = 'pid';
	const _this = that
	const tbody = that.$refs.table.$el.querySelector('.el-table__body-wrapper tbody')
	let getChilds = function(data){
		let _data = [];
		data.forEach(res=>{
			_data.push(res);
			if(res.children && res.children.length){
				let row = getChilds(res.children);
				row.forEach(r=>{
					_data.push(r)
				})
			}
		})
		return _data;
	};
	window.sortId = id;
	window.sortPid = pid;
	Sortable.create(tbody, {
		handle: ".move",
		animation: 300,
		ghostClass: "ghost",
		onEnd:async function({ newIndex, oldIndex }) {
			let tableData = _this.$refs.table.tableData
			let id = window.sortId;
			let pid = window.sortPid;
			if(tableData[0].children){
				tableData = getChilds(tableData)
			}
			const currRow = tableData.splice(oldIndex, 1)[0];
			tableData.splice(newIndex, 0, currRow)
			var ids = '';
			for(const i in tableData){
				if(tableData[0].children){
					if(tableData[i] && tableData[i][pid] == currRow[pid]){
						ids+=tableData[i][id]+',';
					}
				}else{
					if(tableData[i]){
						ids+=tableData[i][id]+',';
					}
				}
			}
			var changeid = currRow.id;
			var res = await api.post({
				'ids':ids,
				'changeid':changeid,
				'pid':currRow[pid] ? currRow[pid] : 0
			});
			if(res.code===200){
				_this.$message.success(res.message)
			}else{
				_this.$message.error(res.message)
			}
		}
	})
}
table.datetime = function(row,cloumn,value){
	if (value == null || value == "") return "无";
	value = parseInt(value);
	if (value.toString().length == 10) {
		value = value*1000;
	}
	let date = new Date(value);
	let Y = date.getFullYear() + '-';
	let M = date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) + '-' : date.getMonth() + 1 + '-';
	let D = date.getDate() < 10 ? '0' + date.getDate() + ' ' : date.getDate() + ' ';
	let h = date.getHours() < 10 ? '0' + date.getHours() + ':' : date.getHours() + ':';
	let m = date.getMinutes() < 10 ? '0' + date.getMinutes() + ':' : date.getMinutes() + ':';
	let s = date.getSeconds() < 10 ? '0' + date.getSeconds() : date.getSeconds();
	return Y + M + D + h + m + s;
}



table.setFilterValue = function(that){
	var query = that.$route.query;
	var data = {};
	var ref = false;
	if (query) {
		for(const i in that.options){
			if (query[that.options[i].value]) {
				ref = true;
				that.options[i].default = query[that.options[i].value];
				data[that.options[i].value] = query[that.options[i].value]+filterBar.separator+"=";
			}
		}
		if (ref) {
			that.params.filter = data;
		}
	}
}

table.eolSplit = function(text){
	if (!text) {
		return '无';
	}
	text = text.split("\r\n");
	return text;
}

table.assign = function(that,data,more){
	for(const i in that.form){
		if(Number.isInteger(data[i]) && that.form[i] == ''){
			that.form[i] = 0;
		}
		if(data[i] !== undefined) {
			if(that.form[i] instanceof Array && !(data[i] instanceof Array)){
				that.form[i] = data[i] ? data[i].split(',') : data[i];
			}else if(typeof that.form[i] == "string" && (typeof data[i] === 'number' && data[i]%1 === 0)){
				that.form[i] = data[i]+"";
			}else if(typeof that.form[i] == "number" && typeof data[i] === 'string'){
				that.form[i] = parseFloat(data[i]);
			}else{
				that.form[i] = data[i];
			}
		}
	}
	if(more){
		for(const i in more){
			that.form[i] = data['_'+more[i]];
		}
	}
	return true;
}

table.searchSubmit = function(that){
	that.params['search'] = that.search;
	that.$refs.table.refresh();
};

table.filter = function(data,that){
	that.params['filter'] = data;
	that.$refs.table.refresh();
};

table.change = function(ids,value,key,api){
	var data = {ids:ids};
	data[key] = value;
	return api.post(data);
}

export default table
