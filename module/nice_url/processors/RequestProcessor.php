<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 06.12.2015
 * Time: 13:47
 */

namespace app\module\nice_url\processors;


use app\module\language\models\Language;
use app\module\nice_url\Finder;
use app\module\nice_url\models\NiceUrl;
use app\module\nice_url\models\NiceUrlAdvanced;
use yii\web\Request;

class RequestProcessor
{

	/** @var Language  */
	private $language;
	/** @var Finder  */
	private $finder;

	public function __construct(Language $language, Finder $finder)
	{
		$this->language = $language;
		$this->finder = $finder;
	}

	/**
	 * function set route depends from niceurl
	 * @param Request $request
	 * @return array
	 */
	public function processRequest(Request $request)
	{
		list($route, $params) = \Yii::$app->getUrlManager()->parseRequest($request);
		$params = array_merge($request->getQueryParams(), $params);

		$niceUrl = $this->finder->findNiceUrlForRequest($this->language, $route);

		if (is_null($niceUrl))
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

		if ($niceUrlObject instanceof NiceUrlAdvanced)
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