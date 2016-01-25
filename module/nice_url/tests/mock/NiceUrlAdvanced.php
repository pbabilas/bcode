<?php
/**
 * @user: Pawel Babilas
 * @date: 25.01.2016
 */

namespace app\module\nice_url\tests\mock;


use app\module\nice_url\models\NiceUrl;

class NiceUrlAdvanced extends NiceUrl
{

	public function getObject()
	{
		$object = new \app\module\nice_url\models\NiceUrlAdvanced();
		$object->oryginal_url = 'page/show';;

		return $object;
	}
}