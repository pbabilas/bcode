<?php
/**
 * @user: Pawel Babilas
 * @date: 25.01.2016
 */

namespace app\module\nice_url\tests\mock;


use app\module\language\models\Language;

class FinderAdvanced extends \app\module\nice_url\Finder
{

	public function findNiceUrlForRequest(Language $language, $route)
	{
		$niceUrl = new NiceUrlObject();
				$niceUrl->object_class = get_class(new NiceUrlAdvanced());

		return $niceUrl;
	}
}