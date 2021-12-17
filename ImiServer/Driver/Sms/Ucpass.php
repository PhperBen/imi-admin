<?php

namespace ImiApp\ImiServer\Driver\Sms;

use Yurun\Util\HttpRequest;

/**
 * Ucpass云之讯短信
 * @author Saopig <1306222220@qq.com>
 */
class Ucpass
{
    /**
     * 错误信息
     * @var $_error
     */
    private $_error;

    /**
     * 接口地址
     * @var string
     */
    private $api_url = 'https://open.ucpaas.com/ol/sms/';

    /**
     * 发送单条短信
     * @param $mobile
     * @param $template
     * @param $code
     * @return bool
     */
    public function send($mobile, $template, $code): bool
    {
        $url = $this->api_url . 'sendsms';
        $client = new HttpRequest;
        $response = $client->headers([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json;charset=utf-8',
        ])->post($url, json_encode([
            'sid' => config('sms_key'),
            'token' => config('sms_token'),
            'appid' => config("sms_id"),
            'templateid' => $template,
            'param' => $code,
            'mobile' => $mobile,
            'uid' => '',
        ], 256 | 64));
        $data = (string)$response->getBody();
        $json = json_decode($data, true);
        if (isset($json['code']) && $json['code'] == '000000') {
            return true;
        } else {
            $this->setError($json['msg'] ?? '未知错误');
            return false;
        }
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