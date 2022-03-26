<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Model;

use Imi\Bean\Annotation\Inherit;
use ImiApp\ApiServer\Backend\Model\Base\SoAttachmentBase;

/**
 * 附件列表.
 *
 * @Inherit
 */
class SoAttachment extends SoAttachmentBase
{
    public static function getSearchColumns(): array
    {
        return ['id', 'path', 'url', 'filename', 'admin_id'];
    }

    public static function getOrderRaw()
    {
        return 'update_time desc';
    }
}
