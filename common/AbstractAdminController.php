<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 28.11.15
 * Time: 22:30
 */

namespace app\common;

use app\module\module\models\Module;
use app\module\module\models\ModuleQuery;
use Yii;
use yii\web\NotFoundHttpException;

abstract class AbstractAdminController extends AbstractController
{
	/** @var array  */
	public $menuItems = [];
	/** @var Module  */
	public $currentModule = null;

	public static $allowedControllerAction = [
		'user' => [
			'auth' => [
				'login',
				'index'
			]
		]
	];

	public function init()
	{
		$moduleName = $this->module->id;
		/** @var Module $module */
		$this->currentModule = Module::findOne(['name' => $moduleName]);

		if ($this->needAuthentication() == false)
		{
			return true;
		}

		if (\Yii::$app->user->isGuest)
		{
			\Yii::$app->user->setReturnUrl(\Yii::$app->request->url);
			$this->addMessage('user', 'restricted_area', Message::ALERT);
			$this->redirect('/admin/user/auth/login');
			return false;
		}

		$this->checkModuleAccess();
		$this->checkAdminAccess();

		/** @var Module $menuItem */
		foreach(ModuleQuery::findAllOrdered() as $menuItem)
		{
			if ($this->hasAdminController($menuItem->name))
			{
				$category = $menuItem->getCategory();
				$this->menuItems[$category->name][] = $menuItem;
			}
		}

		\Yii::$app->layout = 'admin.tpl';
	}

	/**
	 * @throws NotFoundHttpException
	 */
	private function checkModuleAccess()
	{
		if ($this->currentModule->technical_user_only)
		{
			if (\Yii::$app->user->can('accessModule') == false)
			{
				throw new NotFoundHttpException('You are not authorized to access this area');
			}
		}
	}

	/**
	 * @throws NotFoundHttpException
	 */
	private function checkAdminAccess()
	{
		if ($this->currentModule->admin_access == false)
		{
			if (\Yii::$app->user->can('accessModule') == false)
			{
				throw new NotFoundHttpException('You are not authorized to access this area');
			}
		}
	}

	/**
	 * @param $moduleId
	 *
	 * @return bool
	 */
	private function hasAdminController($moduleId)
	{
		$module = Yii::$app->getModule($moduleId);
		if (is_null($module))
		{
			return false;
		}

		/** @var string $file */
		foreach(glob($module->getControllerPath().'/*AdminController.php') as $file)
		{
			$className = basename($file, '.php');
			$reflectionClass = new \ReflectionClass($module->controllerNamespace . '\\' . $className);

			if($reflectionClass->isSubclassOf('app\common\AbstractController'))
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * @return bool
	 */
	private function needAuthentication()
	{
		if (isset(AbstractAdminController::$allowedControllerAction[$this->module->id]) == false)
		{
			return true;
		}

		$unauthorizedModuleControllers = AbstractAdminController::$allowedControllerAction[$this->module->id];

		if (isset($unauthorizedModuleControllers[$this->id]) == false)
		{
			return true;
		}

		return false;
	}
}