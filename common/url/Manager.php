<?php
/**
 * @user: Pawel Babilas
 * @date: 06.01.2016
 */

namespace app\common\url;


use app\common\Settings;
use yii\web\UrlManager;

class Manager extends UrlManager
{

	/** @var array */
	private $ignoreModules = [ 'gii', 'debug' ];

	public function createUrl($params)
	{
		if (in_array(\Yii::$app->controller->module->id, $this->ignoreModules))
		{
			return parent::createUrl($params);
		}
		if (is_array($params))
		{
			@list($module, $controllerId, $action) = explode('/', $params[0], 3);

			if ($module != $controllerId)
			{
				$route = sprintf('%s/%s/%s', $module, $controllerId, $action);
			}
			else
			{
				$route = sprintf('%s/%s', $module, $action);
			}

			unset($params[0]);

			if (!empty($params) && ($query = http_build_query($params)) !== '')
			{
				$route .= '?' . $query;
			}

			return sprintf('%s%s', Settings::getInstance()->isAdmin() ? 'admin/' : '', $route);
		}

		return parent::createUrl($params);
	}
}