<?php
/**
 * @user: Pawel Babilas
 * @date: 10.12.2015
 */

namespace app\module\nice_url\remover;

use app\module\nice_url\models\NiceUrl;

class NiceUrlRemover
{

	/**
	 * @param NiceUrl $niceUrl
	 */
	public static function dropOldNiceUrl(NiceUrl $niceUrl)
	{
		/** @var NiceUrl $oldNiceUrl */
		$oldNiceUrl = NiceUrl::findOne([
			'object_class' => $niceUrl->object_class,
			'object_id'    => $niceUrl->object_id,
			'language_id'  => $niceUrl->language_id,
			'redirect'     => false
		]);

		if (is_null($oldNiceUrl) == false)
		{
			$oldNiceUrl->redirect = true;
			$oldNiceUrl->save();
		}


	}

}