<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 06.12.2015
 * Time: 13:47
 */

namespace app\module\nice_url\models;


use app\module\language\models\Language;
use app\module\nice_url\interfaces\NiceUrlInterface;
use app\module\nice_url\NiceUrlUtils;
use Exception;
use yii\web\Request;

class NiceUrlSearch
{
	/**
	 * Function search niceUrl from given request
	 * @param Request $request
	 * @return NiceUrl
	 */
	public static function findForRequest(Request $request)
	{
		try
		{
			$lang = \Yii::$app->language;

			list($route) = \Yii::$app->getUrlManager()->parseRequest($request);

			$url = NiceUrlUtils::normalizeUrl($route);
			$niceUrl = NiceURL::findOne(['url' => $url, 'lang' => $lang]);

			return isset($niceUrl) ? true : false;
		}
		catch (Exception $e)
		{
			return false;
		}
	}

	/**
	 * @param NiceUrlInterface $object
	 * @param Language $language
	 *
	 * @return NiceUrl|null
	 */
	public static function findOneForObject(NiceUrlInterface $object, Language $language)
	{
		$className = get_class($object);

		return NiceUrl::find()->where([
				'object_class' => $className,
				'object_id' => $object->id,
				'language_id' => $language->id
		])->one();
	}

	/**
	 * @param NiceUrlInterface $object
	 * @param Language $language
	 *
	 * @return NiceUrl|null
	 */
	public static function findAllForObject(NiceUrlInterface $object, Language $language)
	{
		$className = get_class($object);

		return NiceUrl::find()->where([
				'object_class' => $className,
				'object_id' => $object->getId(),
				'language_id' => $language->id
		])->one();
	}
}