<?php

if (!function_exists('getControllerFiles')) {
    /**
     * 获取所有控制器
     * @param $path
     * @param $files
     */
    function getControllerFiles($path, &$files)
    {
        if (is_dir($path)) {
            $dp = dir($path);
            while ($file = $dp->read()) {
                if ($file !== "." && $file !== "..") {
                    getControllerFiles($path . "/" . $file, $files);
                }
            }
            $dp->close();
        }
        if (is_file($path) && str_contains($path, 'Controller.php')) {
            $content = file_get_contents($path);
            if (str_contains($content, '@Controller(')) {
                preg_match('!namespace (.*?);!i', $content, $namespace);
                preg_match('!class (.*?) extends!i', $content, $class);
                if ($namespace && $class) {
                    $namespace = str_replace(['namespace ', ';'], '', $namespace[0]);
                    $class = str_replace(['class ', ' extends'], '', $class[0]);
                    $files[] = str_replace("\\", "\\", $namespace) . "\\" . $class;
                }
            }
        }
    }
}


if (!function_exists('getModelFiles')) {
    /**
     * 获取所有模型
     * @param $path
     * @param $files
     */
    function getModelFiles($path, &$files)
    {
        if (is_dir($path)) {
            $dp = dir($path);
            while ($file = $dp->read()) {
                if ($file !== "." && $file !== "..") {
                    getModelFiles($path . "/" . $file, $files);
                }
            }
            $dp->close();
        }
        if (is_file($path) && str_contains($path, '.php')) {
            $content = file_get_contents($path);
            if (str_contains($content, 'Model\\Base') && str_contains($content, 'Annotation\\Inherit')) {
                preg_match('!namespace (.*?);!i', $content, $namespace);
                preg_match('!class (.*?) extends!i', $content, $class);
                if ($namespace && $class) {
                    $namespace = str_replace(['namespace ', ';'], '', $namespace[0]);
                    $class = str_replace(['class ', ' extends'], '', $class[0]);
                    $files[] = str_replace("\\", "\\", $namespace) . "\\" . $class;
                }
            }
        }
    }
}

if (!function_exists('sendEmail')) {
    /**
     * 邮件发送
     * @param $subjuct
     * @param $content
     * @param $address
     * @throws \PHPMailer\PHPMailer\Exception
     */
    function sendEmail($subjuct, $content, $address)
    {
        go(function () use ($subjuct, $content, $address) {
            $mail = new \PHPMailer\PHPMailer\PHPMailer; //PHPMailer对象
            $mail->CharSet = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
            $mail->IsSMTP(); // 设定使用SMTP服务
            $mail->SMTPDebug = 0; // 关闭SMTP调试功能
            $mail->SMTPAuth = true; // 启用 SMTP 验证功能
            $mail->SMTPSecure = config('mail_vertify') == "1" ? 'tls' : 'ssl'; // 使用安全协议
            $mail->Host = config('mail_host'); // SMTP 服务器
            $mail->Port = config('mail_port'); // SMTP服务器的端口号
            $mail->Username = config('mail_user'); // SMTP服务器用户名
            $mail->Password = config('mail_pass'); // SMTP服务器密码
            $mail->SetFrom(config('mail_from'), config('mail_name')); // 邮箱，昵称
            $mail->Subject = $subjuct;
            $mail->MsgHTML($content);
            $mail->AddAddress($address);
            $result = $mail->Send();
            if (!$result) {
                \Imi\Log\Log::error($mail->ErrorInfo);
            }
        });
    }
}


if (!function_exists('build_timestamp')) {
    /**
     * 生成时间戳
     * @param string $a
     * @return array
     */
    function build_timestamp(string $a = 'today'): array
    {
        $array = [];
        $a == 'today' && $array = [strtotime(date("Y-m-d", time()) . ' 00:00:00'), strtotime(date("Y-m-d", time()) . ' 23:59:59')];
        $a == 'yesterday' && $array = [strtotime(date("Y-m-d", strtotime("-1 day")) . ' 00:00:00'), strtotime(date("Y-m-d", strtotime("-1 day")) . ' 23:59:59')];
        $a == 'week' && $array = [strtotime(date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), (int)(date("d") - date("w")) + 1, date("Y")))), strtotime(date("Y-m-d H:i:s", mktime(23, 59, 59, date("m"), (int)(date("d") - date("w")) + 7, date("Y"))))];
        $a == 'lastweek' && $array = [strtotime(date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), (int)(date("d") - date("w")) + 1 - 7, date("Y")))), strtotime(date("Y-m-d H:i:s", mktime(23, 59, 59, date("m"), (int)(date("d") - date("w")) + 7 - 7, date("Y"))))];
        $a == 'month' && $array = [strtotime(date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), 1, date("Y")))), strtotime(date("Y-m-d H:i:s", mktime(23, 59, 59, date("m"), date("t"), date("Y"))))];
        $a == 'lastmonth' && $array = [strtotime(date("Y-m-d H:i:s", mktime(0, 0, 0, date("m") - 1, 1, date("Y")))), strtotime(date("Y-m-d H:i:s", mktime(23, 59, 59, date("m"), 0, date("Y"))))];
        $a == 'quarter' && $array = [strtotime(date('Y-m-d H:i:s', mktime(0, 0, 0, date('n') - (date('n') - 1) % 3, 1, date('Y')))), strtotime(date('Y-m-d H:i:s', mktime(23, 59, 59, (int)date('n') + (date('n') - 1) % 3, date("t", mktime(0, 0, 0, (int)date('n') + (date('n') - 1) % 3, 1, date("Y"))), date('Y'))))];
        $a == 'lastquarter' && $array = [strtotime(date('Y-m-01', mktime(0, 0, 0, ((ceil(date('n') / 3)) - 2) * 3 + 1, 1, date('Y')))), strtotime(date('Y-m-t', mktime(0, 0, 0, ((ceil(date('n') / 3)) - 1) * 3, 1, date('Y'))))];
        return $array;
    }
}


if (!function_exists('build_url')) {
    /**
     * url转换
     * @param string $url Url字符
     * @param string $ends 后缀
     * @return string
     */
    function build_url(string $url = '', string $ends = '/'): string
    {
        if (preg_match("/^(http:\/\/|https:\/\/).*$/", $url)) {
            if (str_starts_with($url, "http://")) $h = true;
            if (str_starts_with($url, 'https://')) $h = true;
        }
        if (!isset($h)) $url = 'http://' . $url;
        $url = trim($url);
        $url = trim($url, '/');
        return $url . $ends;
    }
}


if (!function_exists("is_mobile")) {
    /**
     * 检测是否为手机
     * @return bool
     */
    function is_mobile(): bool
    {
        $request = new \ImiApp\ImiServer\Request();
        $match_rule = '/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i';
        if ($request->hasHeader('HTTP_VIA') && stristr($request->getHeaderLine('HTTP_VIA'), "wap")) {
            return true;
        } elseif ($request->hasHeader('HTTP_ACCEPT') && strpos(strtoupper($request->getHeaderLine('HTTP_ACCEPT')), "VND.WAP.WML")) {
            return true;
        } elseif ($request->hasHeader('HTTP_X_WAP_PROFILE') || $request->hasHeader('HTTP_PROFILE')) {
            return true;
        } elseif ($request->hasHeader('HTTP_USER_AGENT') && preg_match($match_rule, $request->getHeaderLine('HTTP_USER_AGENT'))) {
            return true;
        } elseif ($request->hasHeader('USER-AGENT') && preg_match($match_rule, $request->getHeaderLine('USER-AGENT'))) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('camelize')) {
    /**
     * 下划线转驼峰
     * @param string $uncamelized_words
     * @param string $separator
     * @return string
     */
    function camelize(string $uncamelized_words, string $separator = '_'): string
    {
        $uncamelized_words = $separator . str_replace($separator, " ", strtolower($uncamelized_words));
        return ucwords(ltrim(str_replace(" ", "", ucwords($uncamelized_words)), $separator));
    }
}

if (!function_exists("build_url_string")) {
    /**
     * 一纬数组转换生成Url字符串
     * @param array $array 数组
     */
    function build_url_string(array $array, array $un = ['sign', 'sign_type', 'openid']): string
    {
        $data = [];
        foreach ($array as $k => $v) {
            if (!in_array($k, $un) && $v !== "") {
                $data[$k] = $v;
            }
        }
        ksort($data);
        reset($data);
        $url_string = '';
        foreach ($data as $k => $v) {
            $url_string .= $k . '=' . $v . '&';
        }
        return rtrim($url_string, '&');
    }
}