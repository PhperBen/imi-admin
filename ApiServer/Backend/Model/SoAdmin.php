<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Model;

use Imi\Bean\Annotation\Inherit;
use ImiApp\ApiServer\Backend\Model\Base\SoAdminBase;
use Imi\Model\Annotation\Relation\OneToMany;
use Imi\Model\Annotation\Relation\JoinTo;
use Imi\Model\Annotation\Relation\AutoInsert;
use Imi\Model\Annotation\Relation\AutoUpdate;
use Imi\Model\Annotation\Relation\AutoDelete;

/**
 * 管理员列表.
 *
 * @Inherit
 */
class SoAdmin extends SoAdminBase
{
    /**
     * @OneToMany("SoAuthGroupAccess")
     * @JoinTo("uid")
     * @AutoInsert(false)
     * @AutoUpdate(false)
     * @AutoDelete(false)
     *
     * @var \Imi\Util\ArrayList
     */
    protected $authGroupAccess;

    public function getAuthGroupAccess()
    {
        return $this->authGroupAccess;
    }

    public function setAuthGroupAccess($authGroupAccess)
    {
        $this->authGroupAccess = $authGroupAccess;
        return $this;
    }

	public static function getWithAttribute(): array
	{
		return ['authGroupAccess'];
	}
}