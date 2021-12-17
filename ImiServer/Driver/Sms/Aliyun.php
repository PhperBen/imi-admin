<?php

namespace ImiApp\ImiServer\Driver\Sms;

use Yurun\Util\HttpRequest;

/**
 * 阿里云短信
 * @author Saopig <1306222220@qq.com>
 */
class Aliyun
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
    private $api_url = 'https://dysmsapi.aliyuncs.com';


    /**
     * 配置
     * @var string[]
     */
    protected $config = [
        'accessKeyId' => '',
        'accessKeySecret' => '',
        'RegionId' => 'cn-hangzhou',
        'Action' => '',
        'Version' => '2017-05-25',
    ];

    /**
     * 构造配置
     * Aliyun constructor.
     */
    public function __construct()
    {
        $this->config['accessKeyId'] = config("sms_id");
        $this->config['accessKeySecret'] = config("sms_key");
    }

    /**
     * 发送单条短信
     * @param $mobile
     * @param $template
     * @param $code
     */
    public function send($mobile, $template, $code)
    {
        $this->config['Action'] = 'SendSms';
        $res = $this->request([
            'PhoneNumbers' => $mobile,
            'TemplateCode' => $template,
            'TemplateParam' => ['code' => $code],
        ]);
        if (isset($res['status']) && $res['status']) {
            return true;
        } else {
            $this->setError($res['msg'] ?? $res['Message']);
            return false;
        }
    }

    private function request(array $params)
    {
        $client = new HttpRequest;
        $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        $apiParams = array_merge([
            "SignatureMethod" => "HMAC-SHA1",
            "SignatureNonce" => uniqid(mt_rand(0, 0xffff), true),
            "SignatureVersion" => "1.0",
            "AccessKeyId" => $this->config['accessKeyId'],
            "Timestamp" => gmdate("Y-m-d\TH:i:s\Z"),
            "Format" => "JSON",
        ], $this->config, $params);
        ksort($apiParams);
        $sortedQueryStringTmp = "";
        foreach ($apiParams as $key => $value) {
            $sortedQueryStringTmp .= "&" . $this->encode($key) . "=" . $this->encode($value);
        }
        $stringToSign = "GET&%2F&" . $this->encode(substr($sortedQueryStringTmp, 1));
        $sign = base64_encode(hash_hmac("sha1", $stringToSign, $this->config['accessKeySecret'] . "&", true));
        $signature = $this->encode($sign);
        $url = $this->api_url . "/?Signature={$signature}{$sortedQueryStringTmp}";
        try {
            $response = $client->headers([
                'x-sdk-client' => 'php/2.0.0',
            ])->get($url);
        } catch (\Exception $e) {
            return ['msg' => $e->getMessage()];
        }
        return json_decode((string)$response->body(), true);
    }

    private function encode($str)
    {
        $res = urlencode($str);
        $res = preg_replace("/\+/", "%20", $res);
        $res = preg_replace("/\*/", "%2A", $res);
        $res = preg_replace("/%7E/", "~", $res);
        return $res;
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