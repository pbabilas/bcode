<?php
/**
 * @user: Pawel Babilas
 * @date: 15.12.2015
 */

namespace app\common;


use yii\base\Module;
use yii\web\NotFoundHttpException;

abstract class AbstractModule extends Module
{
	public $controllerNamespace = 'app\module\%s\controllers';

	public function init()
	{
		$this->controllerNamespace = sprintf($this->controllerNamespace, $this->id);
		parent::init();
	}

	public function beforeAction($action)
	{
		$moduleName = $this->id;

		/** @var \app\module\module\models\Module $moduleInstalled */
		$moduleInstalled = \app\module\module\models\Module::findOne(['name' => $moduleName]);

		if (is_null($moduleInstalled) || $moduleInstalled->isEnabled() == false)
		{
			throw new NotFoundHttpException(sprintf('Module %s not installed or disabled', $moduleName));
		}

		$this->checkModuleAccess($moduleInstalled);

		return true;
	}

	/**
	 * @param \app\module\module\models\Module $moduleInstalled
	 * @throws NotFoundHttpException
	 */
	private function checkModuleAccess($moduleInstalled)
	{
		if ($moduleInstalled->technical_user_only)
		{
			if (\Yii::$app->user->can('accessModule') == false)
			{
				throw new NotFoundHttpException('You are not authorized to access this area');
			}
		}
	}
}