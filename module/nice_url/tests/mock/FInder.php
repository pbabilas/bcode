<?php
/**
 * @user: Pawel Babilas
 * @date: 25.01.2016
 */

namespace app\module\nice_url\tests\mock;


use app\module\language\models\Language;

class Finder extends \app\module\nice_url\Finder
{

	public function findNiceUrlForRequest(Language $language, $route)
	{
		return new NiceUrlObject();
	}
}