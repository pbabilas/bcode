<?php

namespace app\module\dashboard\controllers;


use app\common\AbstractAdminController;
use app\helper\LanguageHelper;
use app\module\language\models\Language;
use app\module\user\models\User;
use Yii;

class DashboardAdminController extends AbstractAdminController
{
	/**
	 * @return mixed
	 */
	public function actionIndex()
	{
       	return $this->render('admin/index.tpl');
	}

}
