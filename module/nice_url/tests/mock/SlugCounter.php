<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 10.12.2015
 * Time: 19:08
 */

namespace app\module\nice_url\tests\mock;


use app\module\nice_url\interfaces\SlugCounterInterface;

class SlugCounter implements SlugCounterInterface
{

	/**
	 * @param string $slug
	 * @return integer
	 */
	public function run($slug)
	{
		$result = [-1, 1];
		$id = rand(0,1);

		return $result[$id];
	}
}