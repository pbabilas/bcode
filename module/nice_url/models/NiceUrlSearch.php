<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 06.12.2015
 * Time: 13:47
 */

namespace app\module\nice_url\models;


use Exception;
use yii\web\Request;

class NiceUrlSearch
{
	/**
	 * Function search niceUrl from given request
	 * @param Request $request
	 * @return NiceUrl
	 */
	public function findForRequest(Request $request)
	{
		try
		{
			$lang = \Yii::$app->language;

			list($route) = \Yii::$app->getUrlManager()->parseRequest($request);

			$url = $this->normalizeUrl($route);
			$niceUrl = NiceURL::findOne(['url' => $url, 'lang' => $lang]);

			return isset($niceUrl) ? true : false;
		}
		catch (Exception $e)
		{
			return false;
		}
	}
}