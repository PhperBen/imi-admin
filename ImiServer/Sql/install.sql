-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2021-12-17 17:41:20
-- 服务器版本： 8.0.26
-- PHP 版本： 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `imi-admin`
--

-- --------------------------------------------------------

--
-- 表的结构 `so_admin`
--

CREATE TABLE `so_admin` (
  `id` int UNSIGNED NOT NULL,
  `status` tinyint UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态',
  `username` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名',
  `password` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码',
  `salt` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码盐',
  `email` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '' COMMENT '邮箱',
  `mobile` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '' COMMENT '手机号码',
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '' COMMENT '头像',
  `failures` int UNSIGNED DEFAULT '0' COMMENT '失败次数',
  `token` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT 'TOKEN',
  `home_rule` int UNSIGNED DEFAULT '0' COMMENT '默认菜单',
  `create_time` int UNSIGNED NOT NULL COMMENT '创建时间',
  `update_time` int UNSIGNED DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='管理员列表';

--
-- 转存表中的数据 `so_admin`
--

INSERT INTO `so_admin` (`id`, `status`, `username`, `password`, `salt`, `email`, `mobile`, `avatar`, `failures`, `token`, `home_rule`, `create_time`, `update_time`) VALUES
(1, 1, 'admin', 'd3636846de28207d805ef51f9e24d2a9', 'yISS1r', 'admin@admin.con', '13388888888', 'http://127.0.0.1:8088/uploads/20211217/4e3b4da508551b071648aff887711f51.gif', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIiLCJzdWIiOiIiLCJleHAiOjE2Mzk3NTE5NjkuMzcyNDM1LCJpc3MiOiIiLCJuYmYiOjE2MzkxNDcxNjkuMzcyNDM1LCJqdGkiOiJkZWZhdWx0IiwiaWF0IjoxNjM5MTQ3MTY5LjM3MjQzNSwiZGF0YSI6eyJpZCI6MSwidXNlcm5hbWUiOiJhZG1pbiJ9fQ.f2lH65hTLIs4kSJvEfPhUC9KVD6Pted5fTWP3Yk24Z1W3NA91aVjE5ppRNeUjSgJLGHrpILhEVYbIPRJwU7iU1a1SrMH6-lKxDboKCAwWuiEsOOiawrkSzhuWzyiNvVprkHmFhCxN6gHN0vBf6WoB5JOgMw8Nk4VPyoATz6CCtE', 0, 1639291795, 1639734041);

-- --------------------------------------------------------

--
-- 表的结构 `so_admin_login_log`
--

CREATE TABLE `so_admin_login_log` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '账号',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '密码',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '请求内容',
  `ip` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'IP地址',
  `status` tinyint UNSIGNED NOT NULL COMMENT '登陆状态',
  `create_time` int UNSIGNED NOT NULL COMMENT '登陆时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='管理员登陆日志';

-- --------------------------------------------------------

--
-- 表的结构 `so_admin_operate_log`
--

CREATE TABLE `so_admin_operate_log` (
  `id` int UNSIGNED NOT NULL,
  `admin_id` int UNSIGNED NOT NULL COMMENT '管理员ID',
  `username` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '管理员账号',
  `route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '路由地址',
  `route_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '路由名称',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '请求内容',
  `ip` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'IP地址',
  `user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'User-Agent',
  `create_time` int UNSIGNED NOT NULL COMMENT '请求时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='管理员操作日志';

-- --------------------------------------------------------

--
-- 表的结构 `so_attachment`
--

CREATE TABLE `so_attachment` (
  `id` int UNSIGNED NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'local' COMMENT '存储类型',
  `admin_id` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `user_id` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户ID',
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '存储路径',
  `parent` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '父级',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '在线地址',
  `filename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '文件名称',
  `size` int UNSIGNED NOT NULL COMMENT '文件大小',
  `mediatype` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '文件类型',
  `extension` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '文件后缀',
  `create_time` int UNSIGNED NOT NULL COMMENT '创建时间',
  `update_time` int UNSIGNED DEFAULT '0' COMMENT '更新时间',
  `delete_time` int UNSIGNED DEFAULT '0' COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='附件列表';

-- --------------------------------------------------------

--
-- 表的结构 `so_auth_group`
--

CREATE TABLE `so_auth_group` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL COMMENT '父亲',
  `name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '组名',
  `rules` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '规则',
  `status` tinyint UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int UNSIGNED NOT NULL COMMENT '创建时间',
  `update_time` int UNSIGNED DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='权限分组';

--
-- 转存表中的数据 `so_auth_group`
--

INSERT INTO `so_auth_group` (`id`, `pid`, `name`, `rules`, `status`, `create_time`, `update_time`) VALUES
(1, 0, '超级组', '*', 1, 1491635035, 1491635035);

-- --------------------------------------------------------

--
-- 表的结构 `so_auth_group_access`
--

CREATE TABLE `so_auth_group_access` (
  `uid` int UNSIGNED NOT NULL COMMENT '用户',
  `gid` int NOT NULL COMMENT '组们'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='权限关联';

--
-- 转存表中的数据 `so_auth_group_access`
--

INSERT INTO `so_auth_group_access` (`uid`, `gid`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `so_auth_rule`
--

CREATE TABLE `so_auth_rule` (
  `id` int UNSIGNED NOT NULL,
  `sort` int UNSIGNED NOT NULL DEFAULT '50' COMMENT '排序',
  `status` tinyint UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态',
  `pid` int UNSIGNED NOT NULL COMMENT '父亲',
  `name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '名称',
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '别名',
  `icon` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '图标',
  `rule` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '规则',
  `type` enum('menu','iframe','button','link') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'menu' COMMENT '类型',
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '地址',
  `create_time` int UNSIGNED NOT NULL COMMENT '创建时间',
  `update_time` int UNSIGNED DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='权限菜单';

--
-- 转存表中的数据 `so_auth_rule`
--

INSERT INTO `so_auth_rule` (`id`, `sort`, `status`, `pid`, `name`, `alias`, `icon`, `rule`, `type`, `path`, `create_time`, `update_time`) VALUES
(1, 99, 1, 0, '面板', NULL, 'el-icon-odometer', NULL, 'menu', '/home', 1, 1639130106),
(2, 93, 1, 1, '数据统计', NULL, 'el-icon-stopwatch', NULL, 'menu', '/dashboard', 1, 1639130232),
(3, 99, 1, 0, '系统', NULL, 'el-icon-more-filled', NULL, 'menu', '/system', 1, 1639396627),
(4, 48, 1, 3, '配置管理', NULL, 'el-icon-setting', NULL, 'menu', '/system/config', 1, 1639130288),
(5, 5, 1, 2, '读取', 'dashboard.index', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\DashboardController::index', 'button', NULL, 1, 0),
(6, 6, 1, 4, '读取', 'system.config.read', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\System\\ConfigController::read', 'button', NULL, 1, 1639390141),
(7, 8, 1, 4, '保存', 'system.config.save', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\System\\ConfigController::save', 'button', NULL, 1, 1639390138),
(8, 93, 1, 0, '权限', NULL, 'el-icon-operation', NULL, 'menu', '/auth', 1, 1639130473),
(21, 93, 1, 8, '管理员菜单', NULL, 'el-icon-menu', NULL, 'menu', '/auth/rule/index', 1639144474, 1639144501),
(22, 22, 1, 21, '读取', 'auth.rule.read', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\Auth\\RuleController::read', 'button', NULL, 1639144504, 1639144520),
(23, 23, 1, 21, '删除', 'auth.rule.delete', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\Auth\\RuleController::delete', 'button', NULL, 1639144528, 1639144545),
(24, 24, 1, 21, '排序', 'auth.rule.sort', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\Auth\\RuleController::sort', 'button', NULL, 1639144546, 1639144564),
(25, 25, 1, 21, '创建', 'auth.rule.create', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\Auth\\RuleController::create', 'button', NULL, 1639144566, 1639144587),
(26, 26, 1, 21, '编辑', 'auth.rule.update', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\Auth\\RuleController::update', 'button', NULL, 1639144624, 1639144645),
(27, 27, 1, 21, '快捷操作-获取控制器', 'auth.rule.controllers', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\Auth\\RuleController::controllers', 'button', NULL, 1639144647, 1639144678),
(28, 28, 1, 21, '快捷操作-获取方法', 'auth.rule.methods', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\Auth\\RuleController::methods', 'button', NULL, 1639144680, 1639144703),
(29, 93, 1, 8, '管理员列表', NULL, 'el-icon-avatar', NULL, 'menu', '/auth/admin/index', 1639146623, 1639146653),
(30, 30, 1, 8, '管理员角色', NULL, 'el-icon-star-filled', NULL, 'menu', '/auth/group/index', 1639183217, 1639183280),
(31, 31, 1, 30, '创建', 'auth.group.create', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\Auth\\GroupController::create', 'button', NULL, 1639277463, 1639277501),
(32, 32, 1, 30, '读取', 'auth.group.read', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\Auth\\GroupController::read', 'button', NULL, 1639277478, 1639277491),
(33, 33, 1, 30, '编辑', 'auth.group.update', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\Auth\\GroupController::update', 'button', NULL, 1639277502, 1639277513),
(34, 34, 1, 30, '删除', 'auth.group.delete', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\Auth\\GroupController::delete', 'button', NULL, 1639277514, 1639277528),
(35, 35, 1, 29, '读取', 'auth.admin.read', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\Auth\\AdminController::read', 'button', NULL, 1639277534, 1639277550),
(36, 36, 1, 29, '创建', 'auth.admin.create', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\Auth\\AdminController::create', 'button', NULL, 1639294647, 1639294666),
(37, 37, 1, 29, '编辑', 'auth.admin.update', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\Auth\\AdminController::update', 'button', NULL, 1639294667, 1639294678),
(38, 38, 1, 29, '删除', 'auth.admin.delete', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\Auth\\AdminController::delete', 'button', NULL, 1639294679, 1639294691),
(39, 39, 1, 4, '分组管理', 'system.config_group', 'el-icon-edit', NULL, 'button', '/system/config_group/index', 1639362084, 1639374983),
(40, 40, 1, 39, '读取', 'system.config_group.read', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\System\\ConfigGroupController::read', 'button', NULL, 1639362137, 1639362170),
(41, 41, 1, 39, '删除', 'system.config_group.delete', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\System\\ConfigGroupController::delete', 'button', NULL, 1639362176, 1639477247),
(42, 42, 1, 39, '创建', 'system.config_group.create', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\System\\ConfigGroupController::create', 'button', NULL, 1639362201, 1639477239),
(43, 43, 1, 39, '编辑', 'system.config_group.update', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\System\\ConfigGroupController::update', 'button', NULL, 1639362220, 1639362234),
(45, 45, 1, 39, '操作', 'system.config_group.operate', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\System\\ConfigGroupController::operate', 'button', NULL, 1639366202, 1639374926),
(46, 7, 1, 4, '创建', 'system.config.create', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\System\\ConfigController::create', 'button', NULL, 1639390054, 1639390086),
(47, 47, 1, 3, '代码生成', NULL, 'sc-icon-code', NULL, 'menu', '/system/autocode/index', 1639442336, 1639442432),
(83, 4, 1, 3, '附件管理', NULL, 'el-icon-folder-opened', NULL, 'menu', '/system/attachment/index', 1639661267, 1639661373),
(84, 84, 1, 83, '菜单', 'system.attachment.parents', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\System\\AttachmentController::parents', 'button', NULL, 1639661379, 1639661420),
(85, 85, 1, 83, '创建', 'system.attachment.create', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\System\\AttachmentController::create', 'button', NULL, 1639661421, 1639661436),
(86, 86, 1, 83, '读取', 'system.attachment.read', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\System\\AttachmentController::read', 'button', NULL, 1639661437, 1639661454),
(87, 87, 1, 47, '模型列表', 'system.autocode.models', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\System\\AutocodeController::models', 'button', NULL, 1639661519, 1639661544),
(88, 88, 1, 47, '模型信息', 'system.autocode.info', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\System\\AutocodeController::info', 'button', NULL, 1639661545, 1639661561),
(89, 89, 1, 47, '生成/压缩/删除/预览', 'system.autocode.create', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\System\\AutocodeController::create', 'button', NULL, 1639661562, 1639661598),
(90, 90, 1, 47, '命令执行', 'system.autocode.exec', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\System\\AutocodeController::exec', 'button', NULL, 1639661600, 1639661614),
(92, 91, 1, 83, '删除', 'system.attachment.delete', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\System\\AttachmentController::delete', 'button', NULL, 1639727605, 1639727647),
(95, 14, 1, 1, '个人资料', NULL, 'el-icon-stamp', NULL, 'menu', '/auth/admin/profile', 1639728071, 1639728119),
(96, 96, 1, 95, '修改资料', 'auth.admin.profile', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\Auth\\AdminController::profile', 'button', NULL, 1639728128, 1639728235),
(97, 97, 1, 95, '登陆日志', 'auth.admin.loginlog', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\Auth\\AdminController::loginlog', 'button', NULL, 1639728238, 1639728264),
(98, 98, 1, 95, '操作日志', 'auth.admin.operatelog', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\Auth\\AdminController::operatelog', 'button', NULL, 1639728267, 1639728281),
(99, 46, 1, 0, '用户', NULL, 'el-icon-avatar', NULL, 'menu', '/user', 1639731459, 1639731482),
(101, 101, 1, 99, '用户列表', NULL, 'el-icon-user-filled', NULL, 'menu', '/user/index', 1639731569, 1639731674),
(102, 102, 1, 101, '创建', 'user.create', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\UserController::create', 'button', NULL, 1639731569, 0),
(103, 103, 1, 101, '编辑', 'user.update', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\UserController::update', 'button', NULL, 1639731569, 0),
(104, 104, 1, 101, '读取', 'user.read', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\UserController::read', 'button', NULL, 1639731569, 0),
(105, 105, 1, 101, '删除', 'user.delete', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\UserController::delete', 'button', NULL, 1639731569, 0),
(106, 106, 1, 101, '操作', 'user.operate', NULL, 'ImiApp\\ApiServer\\Backend\\Controller\\UserController::operate', 'button', NULL, 1639731569, 0);

-- --------------------------------------------------------

--
-- 表的结构 `so_config`
--

CREATE TABLE `so_config` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL COMMENT '配置组',
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '配置键',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '配置名称',
  `tip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '' COMMENT '提示说明',
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'string' COMMENT '配置类型',
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '' COMMENT '配置值',
  `variable` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '' COMMENT '配置变量',
  `create_time` int UNSIGNED NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='配置';

--
-- 转存表中的数据 `so_config`
--

INSERT INTO `so_config` (`id`, `pid`, `key`, `name`, `tip`, `type`, `value`, `variable`, `create_time`) VALUES
(1, 2, 'name', '网站名称', '', 'string', 'Imi-Admin', '', 1639382942),
(2, 2, 'title', '网站标题', '', 'string', 'Imi-Admin 后台管理框架', '', 1639383094),
(3, 2, 'keywords', '网站关键词', '', 'string', 'imi-admin,imi,swoole,php,admin', '', 1639383146),
(4, 2, 'description', '网站描述', '', 'string', '基于Imi+Scui打造，快速开发后台框架', '', 1639383189),
(5, 2, 'beian', '网站备案号', '', 'string', 'xxxxx', '', 1639383207),
(6, 2, 'version', '网站版本号', '', 'string', '1.0.0', '', 1639383218),
(7, 5, 'mail_type', '邮件发送方式', '', 'select', '0', '[\"SMTP\"]', 1639383300),
(8, 5, 'mail_host', '邮件发送地址', '', 'string', 'smtp.yeah.net', '', 1639383348),
(9, 5, 'mail_port', '邮件发送端口', '', 'string', '465', '', 1639383372),
(10, 5, 'mail_user', '邮件用户账号', '', 'string', '', '', 1639383391),
(11, 5, 'mail_pass', '邮件用户密码', '', 'string', '', '', 1639383403),
(12, 5, 'mail_vertify', '邮件验证方式', '', 'select', '2', '[\"无\",\"TLS\",\"SSL\"]', 1639383436),
(13, 5, 'mail_from', '邮件发送人', '', 'string', '', '', 1639383455),
(14, 5, 'mail_name', '邮件发送昵称', '', 'string', 'CEO', '', 1639383473),
(16, 6, 'sms_type', '短信服务商', '', 'select', '1', '[\"阿里云\",\"云之讯\"]', 1639383929),
(17, 6, 'sms_id', '短信配置ID', '阿里云：assessKeyId，云之讯：APPID', 'string', '', '', 1639383969),
(18, 6, 'sms_key', '短信配置Key', '阿里云：assessKeySecret，云之讯：Sid', 'string', '', '', 1639383987),
(19, 6, 'sms_token', '短信配置Token', '阿里云：SignName，云之讯：Token', 'string', '', '', 1639384007),
(20, 6, 'sms_template', '模版ID (通用)', '', 'string', '', '', 1639384039),
(21, 7, 'login', '登陆', '', 'switch', '1', '', 1639384081),
(22, 7, 'register', '注册', '', 'switch', '1', '', 1639384087),
(23, 8, 'test', '测试', '', 'datetimerange', '', '', 1639384109),
(24, 8, 'tests', 'tests', '', 'image', '', '', 1639711197),
(25, 8, 'testss', 'testss', '', 'images', '', '', 1639712599),
(26, 7, 'user_verify', '验证方式', '', 'radio', 'mobile', '{\"mobile\":\"手机\",\"email\":\"邮箱\"}', 1639722872);

-- --------------------------------------------------------

--
-- 表的结构 `so_config_group`
--

CREATE TABLE `so_config_group` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL COMMENT '父亲',
  `sort` int UNSIGNED NOT NULL DEFAULT '50' COMMENT '排序',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int UNSIGNED NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='配置分组';

--
-- 转存表中的数据 `so_config_group`
--

INSERT INTO `so_config_group` (`id`, `pid`, `sort`, `name`, `status`, `create_time`) VALUES
(1, 0, 1000, '系统配置', 1, 1639366100),
(2, 1, 100, '网站信息', 1, 1639366107),
(3, 0, 950, '用户设置', 1, 1639366111),
(5, 1, 90, '邮件配置', 1, 1639379742),
(6, 1, 80, '短信配置', 1, 1639379750),
(7, 3, 7, '登陆注册', 1, 1639380506),
(8, 3, 8, '分销推广', 1, 1639380555);

-- --------------------------------------------------------

--
-- 表的结构 `so_crontab`
--

CREATE TABLE `so_crontab` (
  `id` int NOT NULL,
  `type` enum('command','curl','class') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '类型',
  `rule` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '规则',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '内容',
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '参数',
  `status` tinyint UNSIGNED DEFAULT '1' COMMENT '状态',
  `create_time` int UNSIGNED NOT NULL COMMENT '创建时间',
  `update_time` int UNSIGNED DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='监控任务';

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `username` varchar(32) COLLATE utf8mb4_general_ci NOT NULL COMMENT '账号',
  `password` varchar(32) COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码',
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '邮箱',
  `mobile` varchar(11) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '手机号码',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `token` text COLLATE utf8mb4_general_ci COMMENT 'TOKEN',
  `create_time` int NOT NULL COMMENT '创建时间',
  `update_time` int NOT NULL DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='用户表';

--
-- 转储表的索引
--

--
-- 表的索引 `so_admin`
--
ALTER TABLE `so_admin`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `so_admin_login_log`
--
ALTER TABLE `so_admin_login_log`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `so_admin_operate_log`
--
ALTER TABLE `so_admin_operate_log`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `so_attachment`
--
ALTER TABLE `so_attachment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `filename` (`filename`),
  ADD KEY `url` (`url`),
  ADD KEY `path` (`path`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `parent` (`parent`);

--
-- 表的索引 `so_auth_group`
--
ALTER TABLE `so_auth_group`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `so_auth_group_access`
--
ALTER TABLE `so_auth_group_access`
  ADD KEY `uid` (`uid`),
  ADD KEY `gid` (`gid`);

--
-- 表的索引 `so_auth_rule`
--
ALTER TABLE `so_auth_rule`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `so_config`
--
ALTER TABLE `so_config`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `so_config_group`
--
ALTER TABLE `so_config_group`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `so_crontab`
--
ALTER TABLE `so_crontab`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `so_admin`
--
ALTER TABLE `so_admin`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- 使用表AUTO_INCREMENT `so_admin_login_log`
--
ALTER TABLE `so_admin_login_log`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `so_admin_operate_log`
--
ALTER TABLE `so_admin_operate_log`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `so_attachment`
--
ALTER TABLE `so_attachment`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `so_auth_group`
--
ALTER TABLE `so_auth_group`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- 使用表AUTO_INCREMENT `so_auth_group_access`
--
ALTER TABLE `so_auth_group_access`
  MODIFY `uid` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户', AUTO_INCREMENT=54;

--
-- 使用表AUTO_INCREMENT `so_auth_rule`
--
ALTER TABLE `so_auth_rule`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- 使用表AUTO_INCREMENT `so_config`
--
ALTER TABLE `so_config`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- 使用表AUTO_INCREMENT `so_config_group`
--
ALTER TABLE `so_config_group`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
