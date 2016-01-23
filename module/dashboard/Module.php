<?php

namespace app\module\dashboard;

use app\common\AbstractModule;
use Yii;

class Module extends AbstractModule
{

    public function init()
    {
        parent::init();
    }

    public function getHeaderContent()
    {
        return '@app/module/dashboard/views/dashboard/admin/header.tpl';
    }
}
