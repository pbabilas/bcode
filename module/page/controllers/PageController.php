<?php
/**
 * Created by PhpStorm.
 * User: pawel
 * Date: 13.02.2015
 * Time: 15:55
 */

namespace app\module\page\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;

class PageController extends Controller
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
		die('udało się page');
	}

	public function actionShow($id)
	{
		die('strona dziala');
	}


}
