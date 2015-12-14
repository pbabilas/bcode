<?php
/**
 * Created by PhpStorm.
 * User: pawel
 * Date: 13.02.2015
 * Time: 15:55
 */

namespace app\module\dashboard\controllers;

use app\module\page\models\Page;
use yii\base\Event;
use yii\web\Controller;

class DefaultController extends Controller
{
	public function actionIndex()
	{
		Event::on(Page::className(), Page::EVENT_AFTER_UPDATE, 'test', []);
		/** @var Page $page */
		$page = Page::findOne(['id' => 1]);
		$page->title__pl = time();
		$page->save();
		die('po save');
	}

	public function test()
	{
		die('test raz dwa trz');
	}

}
