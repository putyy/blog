<?php

namespace plugin\pt_blog\app\controller;

use Exception;
use Intervention\Image\ImageManagerStatic;
use plugin\email\api\Email;
use plugin\pt_blog\app\model\PtBlogUser;
use support\exception\BusinessException;
use support\Request;
use support\Response;

class UserController extends BaseController
{
    protected string $captchaKey = 'pt_blog_email_captcha';

    /**
     * 发送邮件.
     *
     * @throws BusinessException
     */
    public function sendEmail(Request $request): Response
    {
        if (!class_exists(\plugin\email\api\Email::class)) {
            return $this->error('系统未检测到邮件插件');
        }
        $res = $request->session()->get($this->captchaKey);
        $time = time();
        if (!empty($res) && $time - $res['time'] <= 60) {
            return $this->error('请勿频繁发送');
        }
        $email = $request->post('email', '');
        $this->verifyEmail($email);
        $data = [
            'email' => $email,
            'code' => rand(10000, 99999),
            'time' => $time,
        ];
        session()->set($this->captchaKey, $data);
        // 固定发送模版名为captcha的邮件
        Email::sendByTemplate($email, 'captcha', [
            'code' => $data['code'],
        ]);
        return $this->success();
    }

    /**
     * 注册.
     *
     * @throws Exception
     */
    public function register(Request $request): Response
    {
        $username = $request->post('username', '');
        $nickname = $request->post('nickname', '');
        $password = $request->post('password', '');
        $email = $request->post('email', '');
        $emailCode = (int)$request->post('code', '');
        $this->verifyEmail($email);
        $this->verifyUsername($username);
        $this->verifyNickname($nickname);
        $this->verifyPassword($password);
        $this->verifyEmailCode($email, $emailCode);
        $nickname = $nickname ?: $username;

        $avatar = $this->uploadAvatar($request);

        $user = PtBlogUser::where('username', $username)->orWhere('email', $email)->first();
        if (!empty($user)) {
            return $this->error('该用户名或邮箱已被占用');
        }
        $time = date('Y-m-d H:i:s');
        PtBlogUser::insert([
            'nickname' => $nickname,
            'username' => $username,
            'password' => md5($password),
            'avatar' => $avatar,
            'email' => $email,
            'last_ip' => $request->getRealIp(),
            'join_ip' => $request->getRealIp(),
            'login_time' => $time,
            'created_at' => $time,
            'updated_at' => $time,
        ]);
        return $this->success();
    }

    /**
     * 重置密码.
     *
     * @param Request $request
     * @return Response
     * @throws BusinessException
     */
    public function reset(Request $request): Response
    {
        $password = $request->post('password', '');
        $email = $request->post('email', '');
        $emailCode = (int)$request->post('code', '');
        $this->verifyEmail($email);
        $this->verifyPassword($password);
        $this->verifyEmailCode($email, $emailCode);
        /** @var PtBlogUser $user */
        $user = PtBlogUser::where('email', $email)->first();
        if (empty($user)) {
            return $this->error('该用邮箱未找到对应账号');
        }
        $user->password = md5($password);
        $user->save();
        return $this->success();
    }

    /**
     * 登录.
     *
     * @param Request $request
     * @return Response
     * @throws BusinessException
     */
    public function login(Request $request): Response
    {
        $username = $request->post('username', '');
        $password = $request->post('password', '');
        $this->verifyUsername($username);
        $this->verifyPassword($password);

        /** @var PtBlogUser $user */
        $user = PtBlogUser::where('username', $username)->first();
        if (empty($user)) {
            return $this->error('账号有误');
        }
        if (md5($password) != $user->password) {
            return $this->error('密码错误');
        }
        $user->last_ip = $request->getRealIp();
        $user->login_time = date('Y-m-d H:i:s');
        $user->save();
        $data = [
            'uid' => $user->id,
            'nickname' => $user->nickname,
            'username' => $user->username,
            'avatar' => $user->avatar,
            'email' => $user->email,
        ];
        $request->session()->set($this->sessionUserKey, $data);
        return $this->success();
    }


    public function loginOut(Request $request): Response
    {
        $request->session()->delete($this->sessionUserKey);
        $request->session()->delete('pt_blog_comment');
        $request->session()->delete('pt_blog_email_captcha');
        return $this->success();
    }

    /**
     * 修改用户信息.
     *
     * @param Request $request
     * @return Response
     * @throws BusinessException
     */
    public function update(Request $request): Response
    {
        $uid = $request->session()->get($this->sessionUserKey)['uid'] ?? 0;
        if (empty($uid)) {
            return $this->error('请登录');
        }
        $nickname = $request->post('nickname', '');
        $password = $request->post('password', '');
        $this->verifyNickname($nickname);
        $password && $this->verifyPassword($password);

        $avatar = $this->uploadAvatar($request);

        /** @var PtBlogUser $user */
        $user = PtBlogUser::where('id', $uid)->first();
        $avatar && ($user->avatar = $avatar);
        $password && ($user->password = md5($password));
        $user->nickname = $nickname;
        $user->save();
        $data = [
            'uid' => $user->id,
            'nickname' => $user->nickname,
            'username' => $user->username,
            'avatar' => $user->avatar,
            'email' => $user->email,
        ];
        $request->session()->set($this->sessionUserKey, $data);
        return $this->success();
    }

    public function github(Request $request): Response
    {
        try {
            if (!empty($this->userInfo()['uid'])){
               return redirect('/');
            }
            if (file_exists(runtime_path() . '/pt-blog/config.json')) {
                $config = \json_decode(file_get_contents(runtime_path() . '/pt-blog/config.json'), true);
            } else {
                $config = ptFlattenArray(config('plugin.pt_blog.blog'));
            }

            if (empty($config['github-client_id'])) {
                return $this->transfer('github配置有误');
            }

            // GitHub应用程序的客户端ID和密钥
            $client_id = $config['github-client_id'];
            $client_secret = $config['github-client_secret'];
            $redirect_uri = $request->get('redirect_url', $request->path());
            $code = $request->get('code');
            if (empty($code)) {
                return redirect('https://github.com/login/oauth/authorize?client_id=' . $client_id . '&redirect_url=' . urlencode($redirect_uri) . '&scope=user');
            }

            $options = [
                'http' => [
                    'header' => "Content-Type: application/x-www-form-urlencoded\r\nAccept: application/json\r\nUser-Agent: {$request->header('user-agent')}\r\n",
                    'method' => 'POST',
                    'content' => http_build_query([
                        'client_id' => $client_id,
                        'client_secret' => $client_secret,
                        'code' => $code
                    ])
                ]
            ];
            $context = stream_context_create($options);
            $response = file_get_contents('https://github.com/login/oauth/access_token', false, $context);
            $params = json_decode($response, true);

            $access_token = $params['access_token'];
            // 使用访问令牌访问GitHub API
            $options = array(
                'http' => array(
                    'header' => "Authorization: Bearer $access_token\r\nAccept: application/json\r\nUser-Agent: {$request->header('user-agent')}\r\n",
                    'method' => 'GET',
                    'timeout' => 120
                )
            );
            $context = stream_context_create($options);
            $user_info = file_get_contents('https://api.github.com/user', false, $context);
            $user_data = json_decode($user_info, true);
            $user = PtBlogUser::where('email', $user_data['email'])->first();
            if (empty($user)) {
                $time = date('Y-m-d H:i:s');
                $id = PtBlogUser::insertGetId([
                    'nickname' => $user_data['name'],
                    'username' => $user_data['name'],
                    'password' => md5(rand(100000, 999999)),
                    'avatar' => $user_data['avatar_url'],
                    'email' => $user_data['email'],
                    'last_ip' => $request->getRealIp(),
                    'join_ip' => $request->getRealIp(),
                    'login_time' => $time,
                    'created_at' => $time,
                    'updated_at' => $time,
                ]);
                $data = [
                    'uid' => $id,
                    'nickname' => $user_data['name'],
                    'username' => $user_data['name'],
                    'avatar' => $user_data['avatar_url'],
                    'email' => $user_data['email'],
                ];
            } else {
                /** @var PtBlogUser $user */
                $data = [
                    'uid' => $user->id,
                    'nickname' => $user->nickname,
                    'username' => $user->username,
                    'avatar' => $user->avatar,
                    'email' => $user->email,
                ];
                $user->last_ip = $request->getRealIp();
                $user->login_time = date('Y-m-d H:i:s');
                $user->save();
            }

            $request->session()->set($this->sessionUserKey, $data);
            return redirect($redirect_uri);
        } catch (\Throwable $throwable) {
            return $this->transfer('github授权出错了');
        }
    }

    /**
     * @throws BusinessException
     */
    protected function verifyEmailCode(string $email, int $emailCode)
    {
        if ($emailCode < 10000 || $emailCode > 99999) {
            $this->throw('验证码有误1');
        }
        $res = session()->get($this->captchaKey);
        if (empty($res)) {
            $this->throw('验证码有误2');
        }
        if ($email !== $res['email']) {
            $this->throw('验证码有误3');
        }

        // 邮箱、手机验证码10分钟过期
        $ttl = 10 * 60;
        if (time() - $res['time'] > $ttl) {
            $this->throw('验证码已经过期');
        }

        if ($res['code'] != $emailCode) {
            $this->throw('验证码有误4');
        }
    }

    /**
     * @throws BusinessException
     */
    protected function verifyEmail(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->throw('邮箱格式有误');
        }
    }

    /**
     * @throws BusinessException
     */
    protected function verifyUsername(string $username)
    {
        if (preg_match("/^[a-zA-Z0-9]{5,10}$/", $username) === false) {
            $this->throw('用户名只能包含字母数字且控制在5-10位');
        }
    }

    /**
     * @throws BusinessException
     */
    protected function verifyNickname(string $nickname)
    {
        if (mb_strlen($nickname) > 20) {
            $this->throw('用户昵称不能大于20字符');
        }
    }

    /**
     * @throws BusinessException
     */
    protected function verifyPassword(string $password)
    {
        if (preg_match("/^[a-zA-Z0-9]{5,10}$/", $password) === false) {
            $this->throw('密码只能包含字母数字且控制在5-10位');
        }
    }

    /**
     * @throws BusinessException
     * @throws Exception
     */
    protected function uploadAvatar(Request $request): string
    {
        $file = $request->file('file');
        $avatar = '';
        if ($file && $file->isValid()) {
            $ext = strtolower($file->getUploadExtension() ?: null);
            if (!in_array($ext, ['jpg', 'jpeg', 'gif', 'png', 'webp'])) {
                $this->throw('仅支持 jpg jpeg gif png webp格式');
            }
            $image = ImageManagerStatic::make($file);
            $width = $image->width();
            $height = $image->height();
            $size = min($width, $height);
            $relative_path = 'upload/pt_blog/avatar/' . date('Ym');
            $real_path = base_path() . "/plugin/admin/public/$relative_path";
            if (!is_dir($real_path)) {
                mkdir($real_path, 0750, true);
            }

            $name = bin2hex(pack('Nn', time(), random_int(1, 65535)));
            $image->crop($size, $size)->resize(120, 120);
            $path = base_path() . "/plugin/admin/public/$relative_path/$name.$ext";
            $image->save($path);
            $avatar = "/app/admin/$relative_path/$name.$ext";
        }
        return $avatar;
    }
}