<?php

namespace app\module\dashboard\controllers;


use app\common\AbstractAdminController;
use app\module\dashboard\models\Widget;
use app\module\dashboard\widget\Finder;
use Yii;

class DashboardAdminController extends AbstractAdminController
{
	const MENU_NAME = 'Biurko';

	/**
	 * @return mixed
	 */
	public function actionIndex()
	{
		$widgets = Widget::find()->all();

		$finder = new Finder();

       	return $this->render('admin/index.tpl', [
			'widgets' => $widgets,
			'finder' => $finder
		]);
	}

}
