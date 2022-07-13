<?php

declare(strict_types=1);

namespace ImiApp\ImiServer\Service;

use Imi\App;
use Imi\AppContexts;
use Imi\Config;
use Imi\Log\Log;
use Imi\Util\File;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use Xxtime\Flysystem\Aliyun\OssAdapter;

class Upload
{
    /**
     * 错误信息
     */
    protected $_error = '';

    protected $config = [];

    public function __construct($config = [])
    {
        $this->config = $config ?: Config::get('@app.beans.Upload');
    }

    /**
     * 上传文件
     * @param mixed $file Imi文件内容
     * @return bool|array
     * @throws FilesystemException
     */
    public function pull($file)
    {
        try {
            $file = (0 === $file->getError()) ? $file : false;
            if (!$file) {
                $this->setError(sprintf('上传文件失败，错误码：%s', $file->getError()));
                return false;
            }
            $mediatype = $file->getClientMediaType();
            $extension = array_filter(explode('.', $file->getClientFilename()));
            $extension = end($extension);
            $size = $file->getSize();
            if (!in_array($mediatype, $this->config['mediatype']) || !in_array($extension, $this->config['suffix'])) {
                $this->setError('该类型文件禁止上传');
                return false;
            }
            if (!$this->checkSize($size)) {
                return false;
            }
            if (preg_match("/^php(.*)/i", $extension)) {
                $this->setError('该类型文件禁止上传');
                return false;
            }
            if (stripos($mediatype, '/') === false) {
                $this->setError('该类型文件禁止上传');
                return false;
            }
            if ($this->config['save'] == 'local') {
                $filename = str_replace('//', '/', $this->config['root'] . '/' . date("Ymd", time()) . '/' . md5_file($file->getTmpFileName()) . '.' . $extension);
                $path = File::path(App::get(AppContexts::APP_PATH), '/') . ltrim($filename, '/');
                if (!file_exists(dirname($path))) {
                    File::createDir(dirname($path));
                }
                $file->moveTo($path);
                if (!file_exists($path)) {
                    $this->setError('文件移动失败');
                    return false;
                }
                $path = $filename;
                $filename = basename($filename);
                $url = trim($this->config['domain'], '/') . '/' . trim(str_replace($this->config['root'], '', $path), '/');
            } elseif ($this->config['save'] == 'aliyun') {
                $filename = md5_file($file->getTmpFileName()) . '.' . $extension;
                $path = $this->config['root'] . '/' . date("Ymd", time()) . '/' . $filename;
                $aliyun = new OssAdapter($this->config['aliyun']);
                $filesystem = new Filesystem($aliyun);
                try {
                    $filesystem->delete($path);
                } catch (\Exception $e) {

                }
                $result = $filesystem->write($path, file_get_contents($file->getTmpFileName()));
                $raw = $aliyun->supports->getFlashData();
                $url = $raw['info']['url'] ?? false;
                if (!$url) {
                    $this->setError('文件上传失败');
                    return false;
                }
            }
        } catch (\Exception $e) {
            $this->setError('文件上传出错');
            Log::error($e);
            return false;
        }
        $parent = explode('/', trim(str_replace(basename($path), '', $path), '/'));
        return [
            'filename' => $filename,
            'url' => $url,
            'path' => $path,
            'parent' => end($parent),
            'size' => $size,
            'mediatype' => $mediatype,
            'extension' => $extension,
        ];
    }

    /**
     * 删除
     * @param string $path 路径
     * @return bool
     * @throws FilesystemException
     */
    public function delete(string $path): bool
    {
        try {
            if ($this->config['save'] == 'local') {
                unlink(File::path(App::get(AppContexts::APP_PATH), $path));
            } elseif ($this->config['save'] == 'aliyun') {
                $aliyun = new OssAdapter($this->config['aliyun']);
                $filesystem = new Filesystem($aliyun);
                $filesystem->delete($path);
            }
        } catch (\Exception $e) {
            $this->setError('删除出错');
            Log::error($e);
            return false;
        }
        return true;
    }

    /**
     * 设置错误
     * @param $error
     */
    protected function setError($error): void
    {
        $this->_error = $error;
    }

    /**
     * 获取错误
     * @return string
     */
    public function getError(): string
    {
        return $this->_error;
    }

    /**
     * 检查大小
     * @param $filesize
     * @return bool
     */
    protected function checkSize($filesize): bool
    {
        preg_match('/([0-9\.]+)(\w+)/', $this->config['maxsize'], $matches);
        $size = $matches ? $matches[1] : $this->config['maxsize'];
        $type = $matches ? strtolower($matches[2]) : 'b';
        $typeDict = ['b' => 0, 'k' => 1, 'kb' => 1, 'm' => 2, 'mb' => 2, 'gb' => 3, 'g' => 3];
        $size = (int)($size * pow(1024, $typeDict[$type] ?? 0));
        if ($filesize > $size) {
            $filesize = round($filesize / pow(1024, 2), 2);
            $size = round($size / pow(1024, 2), 2);
            $this->setError('文件过大 (%sMiB). 不能大于: %sMiB.');
            return false;
        }
        return true;
    }
}