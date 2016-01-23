<?php

namespace app\module\error\controllers;

use app\common\AbstractAdminController;

/**
 * @user: Pawel Babilas
 * @date: 20.01.2016
 */
class ErrorAdminController extends AbstractAdminController
{

	public function actions()
	{
		return [
			'index' => [
				'class' => 'yii\web\ErrorAction',
				'view' => 'admin/index.tpl'
			],
		];
	}



}