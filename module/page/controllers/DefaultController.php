<?php
/**
 * Created by PhpStorm.
 * User: pawel
 * Date: 13.02.2015
 * Time: 15:55
 */

namespace app\module\page\controllers;

use app\module\page\models\Page;
use yii\filters\VerbFilter;
use yii\web\Controller;

class DefaultController extends Controller
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
		/** @var Page $page */
		$page = Page::findOne(['id' => 14]);
		$page->title__pl = md5('ssss'.time());
		$page->save();
		die('po save');
	}

	public function test()
	{
		die('test raz dwa trz');
	}


}
