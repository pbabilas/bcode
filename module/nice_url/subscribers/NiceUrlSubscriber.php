<?php
/**
 * @user: Paweł Babilas
 * @date: 010.04.15
 */

namespace app\module\nice_url\subscriber;

use app\common\interfaces\SubscriberInterface;
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
		$niceUrlManager = new NiceUrlManager();

		$request = \Yii::$app->getRequest();
		if ($niceUrl = $niceUrlManager->findForRequest($request))
		{

			list($route, $params) = $niceUrlManager->processRequest($request);

			$routes = array_merge([$route], $params);

			\Yii::$app->catchAll = $routes;
		}
	}


}