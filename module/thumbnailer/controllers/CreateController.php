<?php
/**
 * @user: Pawel Babilas
 * @date: 03.01.2016
 */

namespace app\module\thumbnailer\controllers;


use app\common\AbstractController;
use Exception;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Color;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;

class CreateController extends AbstractController
{
	public function actionIndex($type = null, $size = null, $pictureFilename = null, $extension = null)
	{
		try
		{
			ini_set('memory_limit', '1024M');
			error_reporting(1);

			list($x, $y) = explode('x', $size);

			$imagine = new Imagine();

			$picture = $imagine->open(\Yii::$app->basePath . '/web/pictures/' . $type . '/full_size/' . $pictureFilename . '.' . $extension);
			$pictureSize = $picture->getSize();
			$pictureWidth = $pictureSize->getWidth();
			$pictureHeight = $pictureSize->getHeight();

			if (!$x)
			{
				$aspectRatio = $pictureWidth / $pictureHeight;
			}
			elseif (!$y)
			{
				$aspectRatio = $pictureHeight / $pictureWidth;
			}

			$y = $y ? $y : round($aspectRatio * $x);
			$x = $x ? $x : round($aspectRatio * $y);

			$box = new Box($x, $y, ImageInterface::FILTER_UNDEFINED);
			$mode = ImageInterface::THUMBNAIL_OUTBOUND;

			$thumbnail = $picture->thumbnail($box, $mode);

			$thumbnailSize = $thumbnail->getSize();
			$thumbnailX = $thumbnailSize->getWidth();
			$xPos = ($x / 2) - ($thumbnailX / 2);

			$color = $extension == 'png' ? new Color('#fff', 100) : new Color('#fff');
			$imagine->create($box, $color)
				->paste($thumbnail, new Point($xPos, 0))
				->save(\Yii::$app->basePath . '/web/pictures/' . $type . '/' . $size . '/' . $pictureFilename . '.' . $extension)
				->show($extension);
		}
		catch (Exception $e)
		{
			return false;
		}
	}
}