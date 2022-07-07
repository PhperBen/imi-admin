<?php

use function Imi\env;

$rootPath = dirname(__DIR__) . '/';

return [
    // 模块路由
    'ModuleRoute' => [
        // 后端
        'backend' => 'super',
        // 接口
        'api' => 'api',
    ],
    // AUTH 配置
    'AuthConfig' => [
        // 是否开启
        'status' => true,
        // 配置名称-默认配置
        'default' => [
            // 鉴权方式 Session稍后支持
            'auth' => \Phpben\Imi\Auth\Jwt::class,
            // IMI-缓存配置名称
            'cache' => "redis",
            // 一个账号只能一个人登陆
            'unique' => true,
            // 是否判断权限规则
            'check' => false,
            // JWT配置 结合IMI-JWT组件使用
            'jwt' => [
                // IMI-JWT名称
                'name' => 'default',
                // JWT Header名称
                'header_name' => 'Authorization',
                // JWT 前缀
                'prefix' => 'Bearer ',
            ],
            // 错误配置
            'error' => [
                // 错误Code值
                'code' => 401,
                // 错误http状态码
                'status_code' => 401,
                // 错误消息
                'message' => 'auth error',
            ],
            // 模型配置
            'model' => [
                // 用户表模型
                'user' => \ImiApp\ApiServer\Backend\Model\User::class,
            ],
            // 设置
            'settings' => [
                // 登陆日志
                'login_log' => true,
                // 操作日志
                'operate_log' => true,
                // Hash密码类
                'hash' => \Phpben\Imi\Auth\Hasher\Md5::class,
                // Hash类配置
                'hash_option' => [

                ],
                // 用户表字段
                'user_keys' => [
                    // username唯一用户名
                    'username' => 'username',
                    // password 密码
                    'password' => 'password',
                    // token 存入字段
                    'token' => 'token'
                ],
            ]
        ],
        // 后端
        'backend' => [
            // 鉴权方式 Session稍后支持
            'auth' => \Phpben\Imi\Auth\Jwt::class,
            // IMI-缓存配置名称
            'cache' => "redis",
            // 一个账号只能一个人登陆
            'unique' => false,
            // 是否判断权限规则
            'check' => true,
            // JWT配置 结合IMI-JWT组件使用
            'jwt' => [
                // IMI-JWT名称
                'name' => 'backend',
                // JWT Header名称
                'header_name' => 'Authorization',
                // JWT 前缀
                'prefix' => 'Bearer ',
            ],
            // 错误配置
            'error' => [
                // 错误Code值
                'code' => 401,
                // 错误http状态码
                'status_code' => 200,
                // 错误消息
                'message' => 'auth error',
            ],
            // 模型配置
            'model' => [
                // 用户表模型
                'user' => \ImiApp\ApiServer\Backend\Model\SoAdmin::class,
                // 登陆日志表模型
                'login_log' => \ImiApp\ApiServer\Backend\Model\SoAdminLoginLog::class,
                // 操作日志表模型
                'operate_log' => \ImiApp\ApiServer\Backend\Model\SoAdminOperateLog::class,
                // 权限组模型
                'auth_group' => \ImiApp\ApiServer\Backend\Model\SoAuthGroup::class,
                // 权限组关系表模型
                'auth_group_access' => \ImiApp\ApiServer\Backend\Model\SoAuthGroupAccess::class,
                // 权限规则表模型
                'auth_rule' => \ImiApp\ApiServer\Backend\Model\SoAuthRule::class,
            ],
            // 设置
            'settings' => [
                // 登陆日志
                'login_log' => true,
                // 操作日志
                'operate_log' => true,
                // Hash密码类
                'hash' => \Phpben\Imi\Auth\Hasher\Md5Salt::class,
                // Hash类配置
                'hash_option' => [

                ],
                // 用户表字段
                'user_keys' => [
                    // username唯一用户名
                    'username' => 'username',
                    // password 密码
                    'password' => 'password',
                    // salt 密码盐，非必需
                    'salt' => 'salt',
                    // token 存入字段
                    'token' => 'token'
                ],
                // 规则表字段
                'auth_rule_keys' => [
                    // 规则表字段 内容例： ImiApp\ApiServer\Controller\TestController::login
                    'rule' => 'rule',
                    // 规则所属分组字段
                    'pid' => 'pid',
                ],
                'auth_group_keys' => [
                    // 规则Ids字段 内容例：1,3,5,7,9 支持*
                    'ids' => 'rules',
                    // 开关字段 1/0判断
                    'status' => 'status',
                    // 所属user字段id
                    'pid' => 'pid'
                ],
                'auth_group_access_keys' => [
                    // 用户id
                    'user_id' => 'uid',
                    // auth_group组id
                    'group_id' => 'gid'
                ]
            ]
        ],
    ],
    'ConfigCenter' => [
        // 同步配置间隔时间
        'interval' => 5,
        // 驱动类名
        'driver' => \Phpben\Imi\ConfigCenter\Driver\File::class,
        // 阿里云MSENacos配置
        'aliyun_mse_nacos' => [
            // endpoint
            'endpoint' => "mse-xxxxxx-p.nacos-ans.mse.aliyuncs.com",
            // SK
            'secret_key' => "",
            // AK
            'access_key' => "",
            // 实例ID
            'instance_id' => "",
            // DATA_ID
            'data_id' => "",
            // GROUPID
            'group' => "",
            // 命名空间
            'namespace' => "",
        ],
        // 阿里云ACM配置
        'aliyun_acm' => [
            // 命名空间
            'namespace' => "",
            // GROUPID
            'group' => "",
            // SK
            'secret_key' => "",
            // AK
            'access_key' => "",
            // endpoint
            'endpoint' => "acm.aliyun.com",
            // DATA_ID
            'data_id' => "",
        ],
        // FILE文件驱动配置
        'file' => [

        ],
    ],
    'Upload' => [
        // 存储 local本地/aliyun阿里OSS
        'save' => 'local',
        // 最大上传大小
        'maxsize' => '20m',
        // 可上传的文件类型
        'mediatype' => ['image/gif', 'image/jpg', 'image/jpeg', 'image/bmp', 'image/png', 'text/plain'],
        // 可上传的文件后缀
        'suffix' => ['gif', 'jpg', 'jpeg', 'bmp', 'png', 'txt'],
        // 上传目录
        'root' => "/public/uploads",
        // 获取图片Domain（oss则填oss地址）
        'domain' => env("UPLOAD_DOMAIN"),
        // Aliyun oss配置
        'aliyun' => [
            'accessId' => '',
            'accessSecret' => '',
            'bucket' => '',
            'endpoint' => 'oss-cn-shanghai.aliyuncs.com',
            'isCName' => false,
        ],
    ],
    'Sms' => [
        'driver' => [
            \ImiApp\ImiServer\Driver\Sms\Aliyun::class,
            \ImiApp\ImiServer\Driver\Sms\Ucpass::class,
        ],
    ],
    'hotUpdate' => [
        // 'status'    =>    false, // 关闭热更新去除注释，不设置即为开启，建议生产环境关闭

        // --- 文件修改时间监控 ---
        // 'monitorClass'    =>    \Imi\HotUpdate\Monitor\FileMTime::class,
        'timespan' => 1, // 检测时间间隔，单位：秒

        // --- Inotify 扩展监控 ---
        'monitorClass' => extension_loaded('inotify') ? \Imi\HotUpdate\Monitor\Inotify::class : \Imi\HotUpdate\Monitor\FileMTime::class,
        // 'timespan'    =>    1, // 检测时间间隔，单位：秒，使用扩展建议设为0性能更佳

        // 'includePaths'    =>    [], // 要包含的路径数组
        'excludePaths' => [
            $rootPath . '.git',
            $rootPath . '.idea',
            $rootPath . '.vscode',
            $rootPath . 'vendor',
            $rootPath . 'imi-ui',
        ], // 要排除的路径数组，支持通配符*
    ],
    'JWT' => [
        'list' => [
            'default' => [
                'signer' => 'Rsa',
                'algo' => 'Sha256',
                'id' => 'default',
                'expires' => 86400 * 7,
                'privateKey' => '-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQCwHYIG6vTpKna3Wa19hPqBq/wh9qch6DeDXwFNT3NJU3yQ0Hf6
WF/TinRbb5IiQ51i/+5b8vNbMW9q+P+3BaBsgo5DGzAfxhXTcyYlPbDD0vfrElEe
xfnUQyVNW2nvCBD/IlyG5Lk9wX/Z3k99Gas9P295qMklsVDWnnnPeggfuwIDAQAB
AoGAD88mS+6te3zHWWAgdcMJJbjFklrs19tbmFxf5ou6QpvO88Ty8DMcrwWfulGC
obbGGwv0Xqapd8cxRD4D3m8P3md/zuzvi69h8GhtPC6Qi3qGw3Ax+OI1o2FiU4nR
zz1Qf6fBZCQkxHyCGAq7gc3m6JgiHtAAisgnt8820lTMaNECQQDl8A0Yd+9MamV+
MeZH82Em2Fa6SJeKWSY5sSG2JMslvmp8x6ABDG4W+YAargzof3bFb+CrVKnAsBgB
N7xnCwxTAkEAxBO6IkqBBmoJB3atlZVDNS+NFCG4WotU6rOIMjNiJiF0CvhWsz8g
HR5ebYiceQbwmPM93Sa7WtOor4HM8bXx+QJBAMN6H3f0xkBdl2kAPPhgJPCkLJ7z
hbk87u1O9AzoHLg6uEbaYuFhUto/RDPqUdj6O9u/r+2X7TR9v/qRCp9DWjcCQFdh
SzP46+MF4hw3YUgmCptrI33zQQroyOEHPQzSJU1E30f8P/cFjLQtUnuRw9mTpCkl
TU5+8kOZy7TbLZASO1ECQDkQgbVj0vskXygDUtbJq3LKf1Q9gkQhz6dLI8899YMZ
9GtPqLfmcaTIJJWojgPTaouIk7b+NGvWvhwwfpQfKLY=
-----END RSA PRIVATE KEY-----',// 私钥
                'publicKey' => '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCwHYIG6vTpKna3Wa19hPqBq/wh
9qch6DeDXwFNT3NJU3yQ0Hf6WF/TinRbb5IiQ51i/+5b8vNbMW9q+P+3BaBsgo5D
GzAfxhXTcyYlPbDD0vfrElEexfnUQyVNW2nvCBD/IlyG5Lk9wX/Z3k99Gas9P295
qMklsVDWnnnPeggfuwIDAQAB
-----END PUBLIC KEY-----',// 公钥
            ],
            'backend' => [
                'signer' => 'Rsa',
                'algo' => 'Sha256',
                'id' => 'default',
                'expires' => 86400 * 3,
                'privateKey' => '-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQDPYjpnWby7X2fCtwLZ78B4Quc9L7t1QTChRq5E9TanTuf9t3xL
mzCfJyNCA2U22kdfT5OBcAAwcyDaF5RxeSajXucl+rUDPTvuqqhqgAdw0NChsDrp
BZ+wGH4sNYfFyQZeQQtCr4p3lerveCHhzik51ie9c0f8gacvKTH7yj18DwIDAQAB
AoGAd6udPCpiaFWDkK7+7DgXfs5MldhHekAmCcq5oX1HDoDQCm6pQQ/KnOx+wgcn
juGisfM/kT/KPCsTWAanWFuq2SzS+J+iVaLvSOEDulvvP3WO+6tOnO+otQlafFO5
VFmBw785edX6iCtcxTqGCKrsr+35EvudCN7JCPMvfHKBzgECQQD2Zp9U0YwiCEiB
TRlZv4z+ypHDXLwsuiAZsBRX5WVFrHreUt7MsQJ6Youni2OWyHllZ6pL7OijqRMC
o4Fg6v6PAkEA13Z771eTnBv/n0J26SgzST2vBy9SzrRixrfaAb5tp0EojBlp4ywA
N3TWFbGI8iVyeysMvs+nkt4zkh4AqNRqgQJBAO5HpZNvpXWPzxYDih1piR8opDdp
6avTPpG43qN1ei8bsiJnv3/xObVCsU0QFfnN2t++lUghTYRfT7wAhHBGMG8CQHhb
jlWfhSxCE6PiG8yYkTWLiHcp/0bKSxcYYmZw+o3gfwbrt1OYI7LWyDQsDQS+2Fln
LeJ02vXWu9YWfmXQ6oECQQCtiBGLdlNo/Ec06/kdGMcyVMoOQHlnL4oajmxJTogV
UGYay7dhUs3Lei0vw0iz+N9h+l4ohrSV24OkgYUkgSzn
-----END RSA PRIVATE KEY-----',// 私钥
                'publicKey' => '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDPYjpnWby7X2fCtwLZ78B4Quc9
L7t1QTChRq5E9TanTuf9t3xLmzCfJyNCA2U22kdfT5OBcAAwcyDaF5RxeSajXucl
+rUDPTvuqqhqgAdw0NChsDrpBZ+wGH4sNYfFyQZeQQtCr4p3lerveCHhzik51ie9
c0f8gacvKTH7yj18DwIDAQAB
-----END PUBLIC KEY-----',// 公钥
            ],
        ],
    ],

];
