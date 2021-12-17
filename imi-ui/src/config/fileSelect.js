import API from "@/api";

//文件选择器配置

export default {
	apiObj: API.system.attachment.create,
	menuApiObj: API.system.attachment.parents,
	listApiObj: API.system.attachment.read,
	successCode: 200,
	maxSize: 30,
	max: 99,
	uploadParseData: function (res) {
		return {
			//id: res.data.id,
			//fileName: res.data.data,
			url: res.data
		}
	},
	listParseData: function (res) {
		return {
			rows: res.data.list,
			total: res.data.total,
			msg: res.message,
			code: res.code
		}
	},
	request: {
		page: 'page',
		pageSize: 'pageSize',
		keyword: 'keyword',
		menuKey: 'parent'
	},
	menuProps: {
		key: 'label',
		label: 'label',
		children: 'children'
	},
	fileProps: {
		key: 'id',
		fileName: 'filename',
		url: 'url'
	},
	files: {
		doc: {
			icon: 'sc-icon-file-word-2-fill',
			color: '#409eff'
		},
		docx: {
			icon: 'sc-icon-file-word-2-fill',
			color: '#409eff'
		},
		xls: {
			icon: 'sc-icon-file-excel-2-fill',
			color: '#67C23A'
		},
		xlsx: {
			icon: 'sc-icon-file-excel-2-fill',
			color: '#67C23A'
		},
		ppt: {
			icon: 'sc-icon-file-ppt-2-fill',
			color: '#F56C6C'
		},
		pptx: {
			icon: 'sc-icon-file-ppt-2-fill',
			color: '#F56C6C'
		}
	}
}
