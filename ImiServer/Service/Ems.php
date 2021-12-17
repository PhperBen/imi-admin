<?php

declare(strict_types=1);

namespace ImiApp\ImiServer\Service;


use Imi\Cache\CacheManager as Cache;

/**
 * 邮箱验证码
 * @author Saopig <1306222220@qq.com>
 */
class Ems
{
    /**
     * 错误信息
     * @var $_error
     */
    private $_error;

    /**
     * 验证码过期时间
     * @var int
     */
    private $expire = 60 * 5;

    /**
     * 发送间隔
     * @var int
     */
    private $unique = 60;

    /**
     * 缓存键
     * @var string
     */
    private $cacheKey = 'email_{email}_{event}';

    /**
     * 验证码发送
     * @param $email
     * @param false $code 验证码
     * @param string $event 事件类型
     * @return bool
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function send($email, $code = false, $event = 'default')
    {
        !$code && $code = mt_rand(1000, 9999);
        !$event && $event = 'default';
        $key = $this->getKey($email, $event);
        if (Cache::get("redis", $key)) {
            $this->setError('发送频繁');
            return false;
        }
        sendEmail('您当前正在获取验证码', '切勿告诉他人，验证码：' . $code, $email);
        Cache::set('redis', $key, $code, $this->unique);
        Cache::set('redis', $key . "_code", $code, $this->expire);
        return true;
    }

    /**
     * 检测验证码是否正确
     * @param $email 邮箱
     * @param $code 验证码
     * @param string $event 事件类型
     * @return bool
     */
    public function check($email, $code, $event = 'default')
    {
        $key = $this->getKey($mobile, $event) . "_code";
        $row = Cache::get('redis', $key);
        if ($row && $row . '' == $code . '') {
            return true;
        }
        return false;
    }

    /**
     * 获取缓存键
     * @param $email
     * @param $event
     * @return string|string[]
     */
    private function getKey($email, $event)
    {
        return str_replace(['{email}', '{event}'], [$email, $event], $this->cacheKey);
    }

    /**
     * 获取过期时间
     * @return int
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * 获取间隔时间
     * @return int
     */
    public function getUnique()
    {
        return $this->unique;
    }

    /**
     * 删除验证码
     * @param $email
     * @param string $event
     */
    public function flush($email, $event = 'default')
    {
        $key = $this->getKey($mobile, $event) . "_code";
        Cache::delete('redis', $key);
    }

    public function getError()
    {
        return $this->_error;
    }

    private function setError($error)
    {
        $this->_error = $error;
    }
}
