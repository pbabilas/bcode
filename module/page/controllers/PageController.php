<?php
/**
 * Created by PhpStorm.
 * User: pawel
 * Date: 13.02.2015
 * Time: 15:55
 */

namespace app\module\page\controllers;

use app\class_map\dependency\SubclassOf;
use app\class_map\generator\Generator;
use app\module\page\models\Page;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
		die('done');
	}

	public function actionShow($id)
	{
		$page = Page::findOne(['id' => $id]);

		if (is_null($page))
		{
			throw new NotFoundHttpException;
		}

		return $this->render('index.tpl', [
			'page' => $page
		]);
	}


}
