<?php

namespace app\module\thumbnailer\interfaces;

/**
 * @user: Pawel Babilas
 * @date: 03.01.2016
 */
interface HasPictureInterface
{

	public function getPicturePath($filename, $size = 'full_size');

	public function getPictureUrl($filename, $size = 'full_size');

}