# imi-admin
**专注于高效快速开发的后台管理框架** <br><br>
<a href='https://gitee.com/phpben/imi-admin/stargazers'><img src='https://gitee.com/phpben/imi-admin/badge/star.svg?theme=dark' alt='star'></img></a>
<img src="https://svg.hamm.cn/badge.svg?key=License&amp;value=Apache-2.0&amp;color=da4a00">
<a href='https://gitee.com/phpben/imi-admin'><img src="https://svg.hamm.cn/badge.svg?key=imi-admin&amp;value=v1.0.0"></a>
<a href='https://www.kancloud.cn/phpben/imi-admin'><img src="https://svg.hamm.cn/badge.svg?key=Doc&amp;value=文档"></a>
<blockquote class="danger"><p>imi-admin是一个Admin管理框架，采用全新的架构思想，首当思想是为负载或高并发进行开发，不采用老套的文件配置/服务器内上传，占用大带宽，负载无法同步各种数据等，其次追求效率开发但不失代码质量与系统性能，内置了注解动态路由，模块中间件，权限/日志/路由/验证器/模型等注解，但是imi-admin还是初生牛犊 ,正在经过严酷的生产环境的考验，需要众多开发者的提交反馈与维护支持，imi-admin对新中小型项目与新手是绝对首选！</p></blockquote>

**基于 后端 <a href="https://www.imiphp.com/">imi</a> + 前端 <a href="https://gitee.com/lolicode/scui">SCUI</a> 进行开发**<br>

**规范**：文件名统一大驼峰规则，方法名与路由统一下划线写法，遵循psr-4自动加载规则<br>
**功能说明**：<br>
组件：Auth权限与登陆，基于TP6抽离的验证器，模块化路由，微服务配置中心，阿里云OSS，云之讯/阿里云SMS等<br>
强大的Auth权限管理，无限的父子权限继承关系，详细到按钮的权限分配功能<br>
系统配置，对接阿里云ACM/NACOS等，可多种类型的配置添加（动态数据，富文本，下拉框，数组等）<br>
管理员日志，通过注解实现详细的管理员访问日志，IP/提交参数/路由地址/UserAgent等<br>
附件上传，可对接阿里云/七牛云等OSS，一键实现文件/图片上传<br>
一键CURD，一键生成数据表对应的增删改查PHP后端文件与Vue前端文件，没有特殊需求则0代码实现一个Curd！<br>
整合阿里云/云之讯等多家短信平台，完善的短信验证功能<br>
集成PHPMailer邮件发送功能，并且有完善的邮件验证功能<br>

*****
**版权说明：**
可以免费使用imi-admin，也可以开源/发布/售卖基于imi-admin的产品<br>
未经作者明确授权，不能对代码版权注释进行修改<br>
未经作者明确授权，禁止对程序进行修改/复制/二开等一切形式的发布，买卖，更新<br>
*****
<p style="float:left;display:inline-block;"><b>特别鸣谢：</b> </p>
<p style="float:right;display:inline-block;">以 下 排 名 不 分 先 后 顺 序</p>
<p style="clear:both;">
<a href="https://www.php.net/">PHP - <b style="color:red">世界上最好的语言</b></a><br>
<a href="https://www.swoole.com/">Swoole -  PHP 协程框架</a><br>
<a href="https://www.imiphp.com/">imi - PHP长连接微服务分布式开发框架</a><br>
<a href="https://gitee.com/lolicode/scui">Scui - 企业级中后台前端</a><br>
<a href="https://element-plus.org/#/zh-CN">ElementUi - 桌面端组件库</a><br>
</p>
