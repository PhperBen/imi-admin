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