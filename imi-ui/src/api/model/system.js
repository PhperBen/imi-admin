import config from "@/config"
import http from "@/utils/request"

export default {
    autocode:{
        models:{
            url: `${config.API_URL}/system/autocode/models`,
            name: "models",
            get: async function(params = {}){
                return await http.get(this.url,params);
            }
        },
        info:{
            url: `${config.API_URL}/system/autocode/info`,
            name: "info",
            get: async function(params = {}){
                return await http.get(this.url,params);
            }
        },
        create:{
            url: `${config.API_URL}/system/autocode/create`,
            name: "create",
            post: async function(params = {}){
                return await http.post(this.url,params);
            }
        },
    },
    config:{
        read:{
            url: `${config.API_URL}/system/config/read`,
            name: "read",
            get: async function(params = {}){
                return await http.get(this.url,params);
            }
        },
        create:{
            url: `${config.API_URL}/system/config/create`,
            name: "create",
            post: async function(params = {}){
                return await http.post(this.url,params);
            }
        },
        update:{
            url: `${config.API_URL}/system/config/update`,
            name: "update",
            post: async function(params = {}){
                return await http.post(this.url,params);
            }
        },
        group:{
            read:{
                url: `${config.API_URL}/system/config/group/read`,
                name: "read",
                get: async function(params = {}){
                    return await http.get(this.url,params);
                }
            },
            create:{
                url: `${config.API_URL}/system/config/group/create`,
                name: "create",
                post: async function(params = {}){
                    return await http.post(this.url,params);
                }
            },
            update:{
                url: `${config.API_URL}/system/config/group/update`,
                name: "update",
                post: async function(params = {}){
                    return await http.post(this.url,params);
                }
            },
            delete:{
                url: `${config.API_URL}/system/config/group/delete`,
                name: "delete",
                post: async function(params = {}){
                    return await http.post(this.url,params);
                }
            },
            operate:{
                url: `${config.API_URL}/system/config/group/operate`,
                name: "operate",
                post: async function(params = {}){
                    return await http.post(this.url,params);
                }
            },
        }
    }
};