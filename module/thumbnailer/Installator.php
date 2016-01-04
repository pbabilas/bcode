<?php
/**
 * @user: Pawel Babilas
 * @date: 21.12.2015
 */

namespace app\module\thumbnailer;


use app\common\AbstractInstallator;
use app\helper\LanguageHelper;
use app\module\language\models\Language;

class Installator extends AbstractInstallator
{

	/**
	 * @return array
	 */
	protected function getInstallActions()
	{
		return [
			1 => 'init',
		];
	}

	/**
	 * @return array
	 */
	protected function getUninstallActions()
	{
		return [
			1 => 'deleteFolder'
		];
	}

	protected function init()
	{
		if (file_exists(\Yii::$app->basePath . Constants::PICTURES_PATH) == false)
		{
			mkdir(\Yii::$app->basePath . Constants::PICTURES_PATH, 0777);
		}
	}

	protected function deleteFolder()
	{
		if (file_exists(\Yii::$app->basePath . Constants::PICTURES_PATH))
		{
			unlink(\Yii::$app->basePath . Constants::PICTURES_PATH);
		}
	}
}