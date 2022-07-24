<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Service\System;

use Imi\Bean\Annotation\Inherit;
use Imi\Config;
use ImiApp\ApiServer\Backend\Model\SoAttachment;
use ImiApp\ImiServer\AbstractModel;
use ImiApp\ImiServer\AbstractService;
use Imi\Bean\Annotation\Bean;
use ImiApp\ImiServer\Exception\ServiceException;
use Imi\Aop\Annotation\Inject;
use ImiApp\ImiServer\Service\Upload;
use League\Flysystem\FilesystemException;
use Phpben\Imi\Auth\AuthManager;

/**
 * @Inherit
 * @Bean("SystemAttachmentService")
 */
class AttachmentService extends AbstractService
{
    /**
     * @var string
     */
    public $model = SoAttachment::class;

    /**
     * Auth
     * @Inject(name=AuthManager::class,args={"backend"})
     */
    protected $auth;

    /**
     * @Inject(Upload::class)
     *
     * @var \ImiApp\ImiServer\Service\Upload
     */
    protected $upload;

    public function getParents(): array
    {
        $list = [['label' => '全部']];
        return array_merge($list, $this->model::query()->group("parent")->order('parent', 'desc')->fieldRaw("parent as label")->select()->getArray());
    }

    public function pull($files)
    {
        $file = $files['file'] ?? false;
        if (!$file) {
            $this->setError('未上传内容');
            return false;
        }
        $config = Config::get('@app.beans.Upload');
        try {
            if ($config['save'] == "aliyun" && $file->getClientMediaType() == 'application/x-x509-ca-cert') {
                $config['aliyun']['bucket'] = $config['aliyun']['privateBucket'];
                $private = true;
            }
        } catch (\Throwable $e) {

        }
        $_upload = new Upload($config);
        $upload = $_upload->pull($file);
        if (!$upload) {
            $this->setError($_upload->getError());
            return false;
        }
        isset($private) && $upload['url'] = $upload['path'];
        $data = array_merge([
            'type' => Config::get('@app.beans.Upload.save'),
            'admin_id' => $this->auth->user()->id,
            'create_time' => time(),
        ], $upload);
        if ($row = $this->model::find(['filename' => $upload['filename']])) {
            $row->update($data);
        } else {
            $this->model::query()->insert($data);
        }
        return ['url' => isset($private) ? $upload['path'] : $upload['url'], 'filename' => $upload['filename']];
    }

    public function _before_delete(&$ids)
    {
        foreach ($ids as $k => $id) {
            $path = $this->model::find($id);
            if (!$path) {
                unset($ids[$k]);
                continue;
            }
            try {
                $this->upload->delete($path->toArray()['path']);
            } catch (\Throwable $e) {
            }
        }
    }
}