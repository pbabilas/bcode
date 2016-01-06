<?php
/**
 * Component will check if Default Controller ({ModuleId}Controller) has mehod in route if yes will change route to module/module/action
 *
 * @user: Pawel Babilas
 * @date: 05.01.2016
 */

namespace app\components\route;


use app\common\AbstractModule;
use app\common\Settings;
use Yii;
use yii\base\Component;

class DefaultModulePlugin extends Component
{
	public function init()
	{
		$request = Yii::$app->getRequest();
		$pathInfo = $request->getPathInfo();
		if ($newPathInfo = $this->handlePathInfo($pathInfo))
		{
			$request->setPathInfo($newPathInfo);
		}
	}

	/**
	 * @param $pathInfo
	 * @return bool|string
	 */
	private function handlePathInfo($pathInfo)
	{
		@list ($id, $route) = explode('/', $pathInfo, 2);
		if (Yii::$app->hasModule($id) == false)
		{
			return false;
		}

		$module = Yii::$app->getModule($id);

		$controllerSuffix = Settings::getInstance()->isAdmin() ? AbstractModule::ADMIN_CONTROLLER_SUFFIX : AbstractModule::CONTROLLER_SUFFIX;
		$className = str_replace(' ', '', ucwords(str_replace('-', ' ', $id)) .$controllerSuffix);
		$className = ltrim($module->controllerNamespace . '\\' . $className, '\\');

		if (strpos($className, '-') !== false || !class_exists($className))
		{
			return false;
		}

		if (isset($route))
		{
			$routePaths = explode('/', $route, 2);
		}
		else
		{
			$routePaths = explode('/', $module->defaultRoute, 2);
		}
		$action = $routePaths[0];

		$reflectionClass = new \ReflectionClass($className);

		if ($reflectionClass->isSubclassOf('yii\base\Controller') && $reflectionClass->hasMethod('action'.$action))
		{
			return sprintf('%s/%s', $id, $pathInfo);
		}

		return false;
	}

}