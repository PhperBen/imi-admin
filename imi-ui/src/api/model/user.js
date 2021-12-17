import config from "@/config"
import http from "@/utils/request"

export default {
    read: {
        url: `${config.API_URL}/user/read`,
        name: "读取",
        get: async function (params = {}) {
            return await http.get(this.url, params);
        }
    },
    create: {
        url: `${config.API_URL}/user/create`,
        name: "创建",
        post: async function (params = {}) {
            return await http.post(this.url, params);
        }
    },
    update: {
        url: `${config.API_URL}/user/update`,
        name: "编辑",
        post: async function (params = {}) {
            return await http.post(this.url, params);
        }
    },
    delete: {
        url: `${config.API_URL}/user/delete`,
        name: "删除",
        post: async function (params = {}) {
            return await http.post(this.url, params);
        }
    },
    operate: {
        url: `${config.API_URL}/user/operate`,
        name: "操作",
        post: async function (params = {}) {
            return await http.post(this.url, params);
        }
    },
        
}
