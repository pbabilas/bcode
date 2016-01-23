<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 10.12.2015
 * Time: 18:47
 */

namespace app\module\nice_url\interfaces;


interface SlugCounterInterface
{

	/**
	 * @param string $slug
	 * @return integer
	 */
	public function run($slug);
}