<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 06.12.2015
 * Time: 13:47
 */

namespace app\module\nice_url;


class NiceUrlUtils
{
	/**
	 * @param string $url
	 * @return string
	 */
	public static function normalizeUrl($url)
	{
		$url = str_replace('/', '', $url);
		$url = explode('.',$url);
		return $url[0];
	}
}