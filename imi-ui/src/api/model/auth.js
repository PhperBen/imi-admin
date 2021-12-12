import config from "@/config"
import http from "@/utils/request"

export default {
    admin:{
        read:{
            url: `${config.API_URL}/auth/admin/read`,
            name: "管理员列表",
            get: async function(params = {}){
                return await http.get(this.url,params);
            }
        },
        create:{
            url: `${config.API_URL}/auth/admin/create`,
            name: "管理员创建",
            post: async function(params = {}){
                return await http.post(this.url,params);
            }
        },
        update:{
            url: `${config.API_URL}/auth/admin/update`,
            name: "管理员编辑",
            post: async function(params = {}){
                return await http.post(this.url,params);
            }
        },
        delete:{
            url: `${config.API_URL}/auth/admin/delete`,
            name: "管理员删除",
            post: async function(params = {}){
                return await http.post(this.url,params);
            }
        },
        operate:{
            url: `${config.API_URL}/auth/admin/operate`,
            name: "管理员操作",
            post: async function(params = {}){
                return await http.post(this.url,params);
            }
        },
    },
    group:{
        read:{
            url: `${config.API_URL}/auth/group/read`,
            name: "用户组树状",
            get: async function(params = {}){
                return await http.get(this.url,params);
            }
        },
        create:{
            url: `${config.API_URL}/auth/group/create`,
            name: "用户组创建",
            post: async function(params = {}){
                return await http.post(this.url,params);
            }
        },
        update:{
            url: `${config.API_URL}/auth/group/update`,
            name: "用户组编辑",
            post: async function(params = {}){
                return await http.post(this.url,params);
            }
        },
        delete:{
            url: `${config.API_URL}/auth/group/delete`,
            name: "用户组删除",
            post: async function(params = {}){
                return await http.post(this.url,params);
            }
        },
    },
	rule: {
		read:{
            url: `${config.API_URL}/auth/rule/read`,
            name: "权限/菜单",
            get: async function(params = {}){
                return await http.get(this.url,params);
            }
        },
        controllers:{
            url: `${config.API_URL}/auth/rule/controllers`,
            name: "权限/控制器列表",
            get: function(){
                return http.get(this.url);
            }
        },
        methods:{
            url: `${config.API_URL}/auth/rule/methods`,
            name: "权限/控制器方法列表",
            post: function(params = {} ){
                return http.post(this.url,params);
            }
        },
        create:{
            url: `${config.API_URL}/auth/rule/create`,
            name: "权限创建",
            post: function(params = {} ){
                return http.post(this.url,params);
            }
        },
        delete:{
            url: `${config.API_URL}/auth/rule/delete`,
            name: "权限删除",
            post: function(params = {} ){
                return http.post(this.url,params);
            }
        },
        update:{
            url: `${config.API_URL}/auth/rule/update`,
            name: "权限编辑",
            post: function(params = {} ){
                return http.post(this.url,params);
            }
        },
        sort:{
            url: `${config.API_URL}/auth/rule/sort`,
            name: "权限排序",
            post: function(params = {} ){
                return http.post(this.url,params);
            }
        },
	},
	
}
