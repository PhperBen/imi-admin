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
        if (is_file($path) && strpos($path, 'Controller.php') !== false) {
            $content = file_get_contents($path);
            if (strpos($content, '@Controller(') !== false) {
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