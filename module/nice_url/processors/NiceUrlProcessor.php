<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 06.12.2015
 * Time: 13:47
 */

namespace app\module\nice_url\processors;


use app\module\language\models\Language;
use app\module\nice_url\models\NiceUrl;
use yii\web\Request;

class NiceUrlProcessor
{

	/**
	 * function set route depends from niceurl
	 * @param Request $request
	 * @return array
	 */
	public function processRequest(Request $request)
	{
		$language = Language::findOne(['name' => \Yii::$app->language]);

		list($route, $params) = \Yii::$app->getUrlManager()->parseRequest($request);

		/** @var NiceURL $niceUrl */
		$niceUrl = NiceURL::findOne(['url' => $route, 'language_id' => $language->id]);

		if ($niceUrl === false)
		{
			return [
				$route,
				$params
			];
		}

		$url = $this->processNiceUrl($niceUrl);

		$params = array_merge(['id' => $niceUrl->object_id], $params);

		return [
			$url,
			$params
		];
	}

	/**
	 * return correctl
	 * @param NiceURL $niceUrl
	 * @return null|string
	 */
	public function processNiceUrl(NiceURL $niceUrl)
	{
		$url = null;

		$niceUrlObject = $niceUrl->getObject();

		if ($niceUrlObject instanceof AdvancedNiceUrl)
		{
			return $niceUrlObject->oryginal_url;

		}

		$url = sprintf('%s/%s',
				$niceUrlObject->getNiceUrlModuleName(),
				$niceUrlObject->getNiceUrlModuleAction()
		);

		return $url;
	}
	
}