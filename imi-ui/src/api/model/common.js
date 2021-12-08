import config from "@/config"
import http from "@/utils/request"

export default {
	login: {
		url: `${config.API_URL}/auth/login`,
		name: "登陆",
		post: async function(data={}){
			return await http.post(this.url, data);
		}
	},
	auth: {
		url: `${config.API_URL}/auth/auth`,
		name: "权限/菜单",
		get: async function(){
			return await http.get(this.url);
		}
	}
}
