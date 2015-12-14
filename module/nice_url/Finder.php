<?php
/**
 * @user: Pawel Babilas
 * @date: 14.12.2015
 */

namespace app\module\nice_url;


use app\module\language\models\Language;
use app\module\nice_url\models\NiceUrl;

class Finder
{
	/**
	 * @param Language $language
	 * @param string $route
	 * @return NiceUrl|null
	 */
	public function findNiceUrlForRequest(Language $language, $route)
	{
		/** @var NiceUrl $niceUrl */
		$niceUrl = NiceURL::findOne(['url' => $route, 'language_id' => $language->id]);

		return $niceUrl;
	}
}