<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 10.12.2015
 * Time: 18:45
 */

namespace app\module\nice_url\slug;


use app\module\nice_url\interfaces\SlugCounterInterface;
use yii\db\Query;

class DatabaseCounter implements SlugCounterInterface
{
	/**
	 * @param $slug
	 * @return mixed
	 */
	public function run($slug)
	{
		$query = new Query();
		$tmp = $query->select(['COALESCE(MAX(CONVERT(SUBSTRING(nice_url.url,CHAR_LENGTH(nice_url.slug)+2),SIGNED)),-1) AS max_slug_counter'])
			->from('nice_url')
			->where(['nice_url.slug' => $slug])
			->one();
		return $tmp['max_slug_counter'];
	}
}