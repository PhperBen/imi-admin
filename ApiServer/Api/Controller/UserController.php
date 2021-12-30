<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Api\Controller;

use Imi\Server\Http\Route\Annotation\Action;
use Imi\Server\Http\Route\Annotation\Controller;
use Imi\Server\Http\Route\Annotation\Route;
use ImiApp\ApiServer\Api\Model\User;
use Psr\Http\Message\ResponseInterface;
use Imi\Aop\Annotation\Inject;
use Phpben\Imi\Validate\Annotation\Validate;
use Phpben\Imi\Auth\Annotation\Auth;
use ImiApp\ImiServer\Service\Ems;
use ImiApp\ImiServer\Service\Sms;

/**
 * @Auth(nologin={"login","register","resetpwd"})
 * @Controller("/user/")
 */
class UserController extends CommonController
{
    /**
     * @Inject(Ems::class)
     */
    protected $ems;

    /**
     * @Inject(Sms::class)
     */
    protected $sms;

    /**
     * 登陆
     * @Action
     * @Route(url="login",method="POST")
     * @Validate
     * @param $data
     * @return ResponseInterface
     */
    public function login($data): ResponseInterface
    {
        if ($user = $this->auth->login($data->username, $data->password)) {
            return $this->response->success('登陆成功', [
                'token' => $user->token,
                'username' => $user->username,
            ]);
        }
        return $this->response->error('账号或密码错误');
    }

    /**
     * 注册
     * @Action
     * @Route(url="register",method="POST")
     * @Validate
     * @param $data
     * @return ResponseInterface
     */
    public function register($data): ResponseInterface
    {
        if (config('user_verify') == 'mobile') { //短信验证
            $check = $this->sms->check($data->mobile, $data->code, 'register');
        } else { // 邮箱验证
            $check = $this->ems->check($data->email, $data->code, 'register');
        }
        if (!$check) {
            return $this->response->error('验证码错误');
        }
        if (User::find(['username' => $data->username])) {
            return $this->response->error('账号已存在');
        }
        if (User::find(['email' => $data->email])) {
            return $this->response->error('邮箱已存在');
        }
        if (User::find(['mobile' => $data->mobile])) {
            return $this->response->error('手机已存在');
        }
        $model = User::newInstance();
        $create = $model->insert([
            'username' => $data->username,
            'password' => md5($data->password),
            'email' => $data->email,
            'mobile' => $data->mobile,
        ]);
        $user = $this->auth->login($data->username, $data->password);
        if ($user === false) {
            return $this->response->error($this->auth->getError());
        }
        return $this->response->success('注册成功', [
            'token' => $user->token,
            'username' => $user->username,
        ]);
    }

    /**
     * 退出登陆
     * @Action
     * @Route("logout")
     * @return ResponseInterface
     */
    public function logout(): ResponseInterface
    {
        $this->auth->logout();
        return $this->response->success("退出登陆成功");
    }

    /**
     * 忘记密码
     * @Action
     * @Route(url="resetpwd",method="POST")
     * @Validate
     * @param $data
     * @return ResponseInterface
     */
    public function resetpwd($data): ResponseInterface
    {
        if (config('user_verify') == 'mobile') { //短信验证
            $check = $this->sms->check($data->mobile, $data->code, 'resetpwd');
        } else { // 邮箱验证
            $check = $this->ems->check($data->email, $data->code, 'resetpwd');
        }
        if (!$check) {
            return $this->response->error('验证码错误');
        }
        $user = User::find([config('user_verify') => $data[config('user_verify')]]);
        if (!$user) {
            return $this->response->error((config('user_verify') == 'mobile' ? "手机号码" : "邮箱地址") . '错误');
        }
        $user->update(['password' => md5($data->password)]);
        return $this->response->success('重置密码成功', $user->getUsername());
    }

    /**
     * 修改邮箱
     * @Action
     * @Route(url="changeemail",method="POST")
     * @Validate
     * @param $data
     * @return ResponseInterface
     */
    public function changeemail($data): ResponseInterface
    {
        $user = User::find($this->auth->user()->id);
        $check = $this->ems->check($user->getEmail(), $data->code, 'change');
        if (!$check) {
            return $this->response->error('验证码错误');
        }
        if (User::find(['email' => $data->email])) {
            return $this->response->error('邮箱已存在');
        }
        $user->update(['email' => $data['email']]);
        return $this->response->success('修改成功');
    }

    /**
     * 修改手机
     * @Action
     * @Route(url="changemobile",method="POST")
     * @Validate
     * @param $data
     * @return ResponseInterface
     */
    public function changemobile($data): ResponseInterface
    {
        $user = User::find($this->auth->user()->id);
        $check = $this->sms->check($user->getMobile(), $data->code, 'change');
        if (!$check) {
            return $this->response->error('验证码错误');
        }
        if (User::find(['mobile' => $data->mobile])) {
            return $this->response->error('手机号码已存在');
        }
        $user->update(['mobile' => $data['mobile']]);
        return $this->response->success('修改成功');
    }

    /**
     * 修改密码
     * @Action
     * @Route(url="changepwd",method="POST")
     * @Validate
     * @param $data
     * @return ResponseInterface
     */
    public function changepwd($data): ResponseInterface
    {
        $user = User::find($this->auth->user()->id);
        if ($user->getPassword() == md5($data->password)) {
            $user->update(['password' => md5($data->newpassword)]);
        } else {
            return $this->response->error('旧密码错误');
        }
        return $this->response->success('修改成功');
    }
}