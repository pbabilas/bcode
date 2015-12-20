<?php

namespace app\module\module\controllers;

use app\common\AbstractAdminController;
use app\module\module\models\Module;
use yii\filters\VerbFilter;

/**
 * @user: Pawel Babilas
 * @date: 15.12.2015
 */
class DefaultAdminController extends AbstractAdminController
{
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
		];
	}

	public function actionIndex()
	{
		$modules = Module::find()->all();

		$this->view->title = '`module.modules`';
		$this->addBreadcrumb([$this->view->title]);

		return $this->render('index.tpl', [
			'modules' => $modules,
		]);
	}
}