import config from "@/config"
import http from "@/utils/request"

export default {
    read: {
        url: `${config.API_URL}<?php echo $route; ?>read`,
        name: "读取",
        get: async function (params = {}) {
            return await http.get(this.url, params);
        }
    },
    create: {
        url: `${config.API_URL}<?php echo $route; ?>create`,
        name: "创建",
        post: async function (params = {}) {
            return await http.post(this.url, params);
        }
    },
    update: {
        url: `${config.API_URL}<?php echo $route; ?>update`,
        name: "编辑",
        post: async function (params = {}) {
            return await http.post(this.url, params);
        }
    },
    delete: {
        url: `${config.API_URL}<?php echo $route; ?>delete`,
        name: "删除",
        post: async function (params = {}) {
            return await http.post(this.url, params);
        }
    },
    <?php if($operate){ ?>operate: {
        url: `${config.API_URL}<?php echo $route; ?>operate`,
        name: "操作",
        post: async function (params = {}) {
            return await http.post(this.url, params);
        }
    },<?php echo "\n"; } ?>
    <?php if($sort){ ?>sort: {
        url: `${config.API_URL}<?php echo $route; ?>sort`,
        name: "排序",
        post: async function (params = {}) {
            return await http.post(this.url, params);
        }
    },<?php } ?>
    <?php echo "\n"; ?>
}
