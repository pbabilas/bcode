<?php

namespace app\module\error;

use app\common\AbstractModule;
use app\common\Settings;

class Module extends AbstractModule
{

    public function init()
    {
        Settings::getInstance()->disableAdminMode();
        parent::init();
    }
}
