<?php
/**
 * @author: pawel
 * @date: 02.04.2015
 */

namespace app\helper;

use app\module\language\models\Language;
use app\module\nice_url\models\NiceUrl;
use yii\db\ActiveRecord;

class UrlHelper extends \yii\helpers\Url
{

	/**
	 * @param ActiveRecord $object
	 *
	 * @return string
	 */
	public static function niceUrlTo(ActiveRecord $object)
	{
		/** @var Language $language */
		$language = Language::findOne(['symbol' => \Yii::$app->language]);
		/** @var NiceUrl $niceUrl */
		$niceUrl = NiceUrl::findOne(
			[
				'object_class' => get_class($object),
				'object_id' => $object->id,
				'language_id' => $language->id,
				'redirect' => 0
			]
		);

		return sprintf('%s', $niceUrl->url);
	}

//	public static function toModule($moduleName)
//	{
//		$niceUrlManager = new NiceURLManager();
//		return $niceUrlManager->getNiceUrlToModule($moduleName);
//	}
}