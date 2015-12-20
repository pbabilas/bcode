<?php
/**
 * @user: Paweł Babilas
 * @date: 010.04.15
 */

namespace app\module\nice_url\subscriber;

use app\common\interfaces\SubscriberInterface;
use app\module\language\models\Language;
use app\module\nice_url\Finder;
use app\module\nice_url\models\NiceUrl;
use app\module\nice_url\processors\RequestProcessor;
use yii\web\Application;

class NiceUrlSubscriber implements SubscriberInterface
{

	/**
	 * @return array
	 */
	public function getSubscribedEvents()
	{
		return [
			Application::EVENT_BEFORE_REQUEST => 'process'
		];
	}

	/**
	 * process nice url for request
	 */
	public static function process()
	{
		$request = \Yii::$app->getRequest();
		/** @var Language $language */
		$language = Language::findOne(['symbol' => \Yii::$app->language]);

		$niceUrlProcessor = new RequestProcessor($language, new Finder());
		list($route, $params) = $niceUrlProcessor->processRequest($request);

		$routes = array_merge([$route], $params);
		\Yii::$app->catchAll = $routes;
	}


}