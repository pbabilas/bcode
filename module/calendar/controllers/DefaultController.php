<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 06.12.2015
 * Time: 16:14
 */

namespace app\module\calendar\controllers;


use app\common\AbstractController;
use app\module\calendar\models\Calendar;

class DefaultController extends AbstractController
{

	public function actionIndex()
	{
		die('calendar index');
	}

	public function actionEvents()
	{
		$events = Calendar::find()->asArray()->all();

		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		return $events;
	}
}