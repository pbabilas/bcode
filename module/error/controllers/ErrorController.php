<?php

namespace app\module\error\controllers;

use app\common\AbstractController;

/**
 * @user: Pawel Babilas
 * @date: 20.01.2016
 */
class ErrorController extends AbstractController
{

	public function actions()
	{
		return [
			'index' => [
				'class' => 'yii\web\ErrorAction',
				'view' => 'index.tpl'
			],
		];
	}



}