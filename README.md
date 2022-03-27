# imi-admin
**专注于高效快速开发的后台管理框架** <br><br>
<a href='https://phpben.gitee.io/imi-admin-doc/'><img src="https://svg.hamm.cn/badge.svg?key=Doc&amp;value=开发文档"></a>
<a href='https://gitee.com/phpben/imi-admin/stargazers'><img src='https://gitee.com/phpben/imi-admin/badge/star.svg?theme=dark' alt='star'></img></a>
<img src="https://svg.hamm.cn/badge.svg?key=License&amp;value=Apache-2.0&amp;color=da4a00">
<a href='https://gitee.com/phpben/imi-admin'><img src="https://svg.hamm.cn/badge.svg?key=imi-admin&amp;value=v1.0.1"></a>
[![Php Version](https://img.shields.io/badge/php-%3E=7.4-brightgreen.svg)](https://secure.php.net/)
[![Swoole Version](https://img.shields.io/badge/swoole-%3E=4.7.0-brightgreen.svg)](https://github.com/swoole/swoole-src)
<blockquote class="danger"><p>imi 框架的 Admin 项目。</p></blockquote>

**基于 后端 <a href="https://www.imiphp.com/">imi</a> + 前端 <a href="https://gitee.com/lolicode/scui">SCUI</a> 进行开发**<br>
<br>**QQ交流群**：618440872
### 功能说明

Auth鉴权与登陆，日志

ThinkPHP6抽离的验证器

让每个命名空间模块化路由

基于imi的服务注册配置中心

本地/阿里云OSS文件上传与删除

短信驱动及完整的验证码接口

邮件驱动及完整的验证码接口

完善的资源库选择器

前后段php+vue代码生成

### 安装说明

**后端开始安装**
~~~
composer create-project phpben/imi-admin
cd imi-admin
composer install
composer imi-admin-install
~~~

**前端开始安装**
~~~
cd imi-ui
npm i
#or
cnpm i
~~~
配置imi-ui/config/index.js

**启动**
~~~
#后端启动
vendor/bin/imi-swoole swoole/start
#前端启动
cd imi-ui && npm run serve
~~~

### 特别鸣谢
<p style="clear:both;">
<a href="https://www.php.net/">PHP - <b style="color:red">世界上最好的语言</b></a><br>
<a href="https://www.swoole.com/">Swoole -  PHP 协程框架</a><br>
<a href="https://www.imiphp.com/">imi - PHP长连接微服务分布式开发框架</a><br>
<a href="https://element-plus.org/#/zh-CN">ElementUi - 桌面端组件库</a><br>
<a href="https://gitee.com/lolicode/scui">Scui - 企业级中后台前端</a><br>
</p>
