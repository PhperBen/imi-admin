<?php

declare(strict_types=1);

namespace ImiApp\ImiServer\Service;

use Imi\Cache\CacheManager as Cache;
use Imi\Config;

/**
 * 短信
 */
class Sms
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
    private $cacheKey = 'sms_{mobile}_{event}';

    /**
     * 短信发送
     * @param $mobile
     * @param $code
     * @param string $event
     * @return bool
     */
    public function send($mobile, $code = null, $event = 'default')
    {
        !$code && $code = mt_rand(1000, 9999);
        !$event && $event = 'default';
        $key = $this->getKey($mobile, $event);
        if (Cache::get("redis", $key)) {
            $this->setError('发送频繁');
            return false;
        }
        $drive = Config::get("@app.beans.Sms.driver");
        $sms_type = config('sms_type');
        $drive = $drive[$sms_type] ?? false;
        if (!$drive) {
            $this->setError('短信驱动不存在');
            return false;
        }
        $template = config("sms_template_" . $event) ?: config('sms_template');
        $sms = new $drive;
        if (!$sms->send($mobile, $template, $code)) {
            $this->setError($sms->getError());
            return false;
        }
        Cache::set('redis', $key, $code, $this->unique);
        Cache::set('redis', $key . "_code", $code, $this->expire);
        return true;
    }

    /**
     * 检测验证码是否正确
     * @param $mobile 手机号码
     * @param $code 验证码
     * @param string $event 事件类型
     * @return bool
     */
    public function check($mobile, $code, $event = 'default')
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
     * @param $mobile
     * @param $event
     * @return string|string[]
     */
    private function getKey($mobile, $event)
    {
        return str_replace(['{mobile}', '{event}'], [$mobile, $event], $this->cacheKey);
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
     * @param $mobile
     * @param string $event
     */
    public function flush($mobile, $event = 'default')
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