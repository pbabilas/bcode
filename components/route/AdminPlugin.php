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
	const DEFAULT_ROUTE = 'dashboard';

	/**
	 * Method shifts admin prefix and sets Application as Admin site
	 */
	public function init()
	{
		$request = \Yii::$app->getRequest();
		$pregPattern = sprintf('/(%s)+?/', AdminPlugin::ADMIN_PREFIX);

		if (preg_match($pregPattern, $request->getPathInfo()))
		{
			$newPathInfo = preg_replace($pregPattern, '', $request->getPathInfo());

			if ($newPathInfo == '' || $newPathInfo == '/')
			{
				$newPathInfo = AdminPlugin::DEFAULT_ROUTE;
			}
			$request->setPathInfo(
				$newPathInfo
			);

			Settings::getInstance()->setAdminMode();
		}
	}
}