<?php
/**
 * Component will recognize if request is admin mod by prefix, next drop prefix and sets AppMode to Admin
 * @user: Pawel Babilas
 * @date: 05.01.2016
 */

namespace app\components\route;


use app\common\Settings;
use Yii;
use yii\base\Component;

class AdminPlugin extends Component
{
	const ADMIN_PREFIX = 'admin';
	const SEPARATOR = '/';

	/**
	 * Method shifts admin prefix and sets Application as Admin site
	 */
	public function init()
	{
		$request = \Yii::$app->getRequest();
		$pregPattern = sprintf('/(%s\%s)+?/', AdminPlugin::ADMIN_PREFIX, AdminPlugin::SEPARATOR);

		if (preg_match($pregPattern, $request->getPathInfo()))
		{
			$request->setPathInfo(
				preg_replace($pregPattern, '', $request->getPathInfo())
			);

			Settings::getInstance()->setAdminMode();
		}
	}
}