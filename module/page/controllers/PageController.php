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
		$generator = new Generator();
		$generator->setDependency(new SubclassOf('app\common\interfaces\SubscriberInterface'));
		$generator->run(\Yii::$app->getBasePath().'/module');
		$generator->saveTo(\Yii::$app->getBasePath().'/runtime/class_map.php');
		die('done');
	}

	public function actionShow($id)
	{
		die('strona dziala');
	}


}
