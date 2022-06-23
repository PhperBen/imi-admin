<?php

declare(strict_types=1);

namespace ImiApp\ImiServer\Traits;

use Imi\Model\Event\ModelEvents;
use Imi\Model\Event\Param\BeforeInsertEventParam;
use Imi\Model\Event\Param\BeforeUpdateEventParam;
use Imi\Model\Event\Param\BeforeSaveEventParam;
use Imi\Model\Event\Param\AfterInsertEventParam;

trait Model
{
    public function __init(array $data = [], bool $queryRelation = true): void
    {
        if (property_exists($this, 'create_time') || property_exists($this, 'createTime')) {
            $this->on(ModelEvents::BEFORE_INSERT, [$this, 'onBeforeInsert']);
        }
        if (property_exists($this, 'update_time') || property_exists($this, 'updateTime')) {
            $this->on(ModelEvents::BEFORE_UPDATE, [$this, 'onBeforeUpdate']);
            $this->on(ModelEvents::BEFORE_SAVE, [$this, 'onBeforeSave']);
        }
        parent::__init($data);
    }

    public function onBeforeInsert(BeforeInsertEventParam $data)
    {
        if (method_exists($this, 'getSortPk')) {
            $this::getSortPk() !== $this::getPk() && $data->data->{$this::getSortPk()} = $this::query()->max($this::getPk()) + 1;
        }
        $data->data->create_time = time();
    }

    public function onBeforeUpdate(BeforeUpdateEventParam $data)
    {
        $data->data->update_time = time();
    }

    public function onBeforeSave(BeforeSaveEventParam $data)
    {
        $data->data->update_time = time();
    }
}