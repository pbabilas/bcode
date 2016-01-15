<?php
/**
 * @user: Pawel Babilas
 * @date: 15.01.2016
 */

namespace app\module\seo\subscriber;


use app\common\interfaces\SubscriberInterface;
use yii\web\Application;
use yii\base\ActionEvent;

class SeoSubscriber implements SubscriberInterface
{

	/**
	 * @return array
	 */
	public function getSubscribedEvents()
	{
		return [
			Application::EVENT_BEFORE_ACTION => 'setSeo'
		];
	}

	public function setSeo(ActionEvent $event)
	{
		\Yii::$app->controller->view->title = 'Administracja systemu';
//        \Yii::$app->controller->view->description = 'Przedsiębiorstwo Budowlano Melioracyjne Tolos Józef Walczak Piotr Walczak Sp.J.';
//        \Yii::$app->controller->view->keywords = 'Przedsiębiorstwo Budowlano Melioracyjne Tolos Józef Walczak Piotr Walczak Sp.J.';
	}
}