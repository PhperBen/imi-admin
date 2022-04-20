<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Api\Controller;

use Imi\Server\Http\Route\Annotation\Action;
use Imi\Server\Http\Route\Annotation\Controller;
use Imi\Server\Http\Route\Annotation\Route;
use ImiApp\ApiServer\Api\Model\User;
use Psr\Http\Message\ResponseInterface;
use Imi\Aop\Annotation\Inject;
use ImiApp\ImiServer\Service\Ems;

/**
 * @Controller("/ems/")
 */
class EmsController extends CommonController
{
    /**
     * @Inject(Ems::class)
     * 
     * @var \ImiApp\ImiServer\Service\Ems
     */
    protected $ems;

    /**
     * @Action
     * @Route(url="send",method="POST")
     */
    public function send(): ResponseInterface
    {
        $event = (string)$this->request->post('event', 'default');
        if (in_array($event, ['login', 'register', 'resetpwd'])) {
            // 不需要登陆
            $email = (string)$this->request->post('email');
            if (!$email) {
                return $this->response->error('邮箱地址格式不正确');
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->response->error('邮箱地址格式不正确');
            }
        } else {
            // 需要登陆 直接取当前登陆邮箱作为收件人
            if (!$this->auth->isLogin()) {
                return $this->response->error('未登陆');
            }
            $user = User::find($this->auth->user()->id);
            if (!$user) {
                return $this->response->error('未登陆');
            }
            $email = $user->getEmail();
        }
        if ($event == 'resetpwd') {
            $user = User::find(['email' => $email]);
            if (!$user) {
                return $this->response->error('邮箱未注册');
            }
        }
        $ems = $this->ems->send($email, false, $event);
        return $ems ? $this->response->success('发送成功', [
            'expire' => $this->ems->getExpire(),
            'email' => $email,
            'event' => $event
        ]) : $this->response->error($this->ems->getError());
    }
}
