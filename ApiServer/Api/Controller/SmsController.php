<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Api\Controller;

use Imi\Server\Http\Route\Annotation\Action;
use Imi\Server\Http\Route\Annotation\Controller;
use Imi\Server\Http\Route\Annotation\Route;
use ImiApp\ApiServer\Api\Model\User;
use Psr\Http\Message\ResponseInterface;
use Imi\Aop\Annotation\Inject;
use ImiApp\ImiServer\Service\Sms;

/**
 * @Controller("/sms/")
 */
class SmsController extends CommonController
{
    /**
     * @Inject(Sms::class)
     * @var \ImiApp\ImiServer\Service\Sms
     */
    protected $sms;

    /**
     * @Action
     * @Route(url="send",method="POST")
     */
    public function send(): ResponseInterface
    {
        $event = (string)$this->request->post('event', 'default');
        if (in_array($event, ['login', 'register', 'resetpwd'])) {
            // 不需要登陆
            $mobile = (string)$this->request->post('mobile');
            if (!$mobile) {
                return $this->response->error('手机号码格式不正确');
            }
            if (!preg_match("/^1\d{10}$/", $mobile)) {
                return $this->response->error('手机号码格式不正确');
            }
        } else {
            // 需要登陆 直接取当前手机号作为收件人
            if (!$this->auth->isLogin()) {
                return $this->response->error('未登陆');
            }
            $user = User::find($this->auth->user()->id);
            if (!$user) {
                return $this->response->error('未登陆');
            }
            $mobile = $user->getMobile();
        }
        if ($event == 'resetpwd') {
            $user = User::find(['mobile' => $mobile]);
            if (!$user) {
                return $this->response->error('手机未注册');
            }
        }
        $sms = $this->sms->send($mobile, false, $event);
        return $sms ? $this->response->success('发送成功', [
            'expire' => $this->sms->getExpire(),
            'mobile' => $mobile,
            'event' => $event
        ]) : $this->response->error($this->sms->getError());
    }
}
