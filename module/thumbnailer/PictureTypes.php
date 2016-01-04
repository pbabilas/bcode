<?php
/**
 * @user: Pawel Babilas
 * @date: 03.01.2016
 */

namespace app\module\thumbnailer;


class PictureTypes
{

	private $allowedPictureTypes;

	public function isTypeAllowed($type)
	{
		return in_array($type, $this->allowedPictureTypes);
	}

	public function isSizeAllowed($size, $type)
	{
		return in_array($size, $this->allowedPictureTypes[$type]);
	}

}