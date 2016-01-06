<?php
/**
 * @user: Pawel Babilas
 * @date: 15.12.2015
 */

namespace app\common;


use Yii;
use yii\base\Controller;
use yii\base\InvalidConfigException;
use yii\base\Module;
use yii\web\NotFoundHttpException;

abstract class AbstractModule extends Module
{
	const ADMIN_CONTROLLER_SUFFIX = 'AdminController';
	const CONTROLLER_SUFFIX = 'Controller';

	public $controllerNamespace = 'app\module\%s\controllers';

	/** @var  boolean */
	public $isAdminController = false;


	public function init()
	{
		$this->isAdminController = Settings::getInstance()->isAdmin();
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

		return true;
	}

	/**
	 * @inheritdoc
	 */
	public function createControllerByID($id)
	{
		$pos = strrpos($id, '/');
		if ($pos === false) {
			$prefix = '';
			$className = $id;
		} else {
			$prefix = substr($id, 0, $pos + 1);
			$className = substr($id, $pos + 1);
		}

		if (!preg_match('%^[a-z][a-z0-9\\-_]*$%', $className)) {
			return null;
		}
		if ($prefix !== '' && !preg_match('%^[a-z0-9_/]+$%i', $prefix)) {

			return null;
		}

		$controllerSuffix = $this->isAdminController ? AbstractModule::ADMIN_CONTROLLER_SUFFIX : AbstractModule::CONTROLLER_SUFFIX;

		$className = str_replace(' ', '', ucwords(str_replace('-', ' ', $className))) . $controllerSuffix;
		$className = ltrim($this->controllerNamespace . '\\' . str_replace('/', '\\', $prefix)  . $className, '\\');

		if (strpos($className, '-') !== false || !class_exists($className)) {
			return null;
		}
		if (is_subclass_of($className, 'yii\base\Controller')) {
			return Yii::createObject($className, [$id, $this]);
		} elseif (YII_DEBUG) {
			throw new InvalidConfigException("Controller class must extend from \\yii\\base\\Controller.");
		} else {
			return null;
		}
	}
}