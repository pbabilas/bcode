<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 28.11.15
 * Time: 22:30
 */

namespace app\common;


use app\module\module\models\Module;
use Yii;
use yii\web\NotFoundHttpException;

abstract class AbstractAdminController extends AbstractController
{

	/** @var array  */
	public $menuItems = [];
	/** @var null  */
	public $currentModule = null;

	public static $allowedControllerAction = [
		'user' => [
			'login',
			'index'
		]
	];

	public function init()
	{
//		$checkAuth = $this->module->id != 'user' && $this->action == 'login';
//		var_dump($this->module->id != 'user');
//		var_dump(!$this->action);
//		die();

		if (\Yii::$app->user->isGuest)
		{
			\Yii::$app->user->setReturnUrl(\Yii::$app->request->url);
			$this->addMessage('user', 'restricted_area', Message::ALERT);
			$this->redirect('/admin/user/auth/login');
			return false;
		}

		$menuItems = Module::find()->all();
		/** @var Module $menuItem */
		foreach($menuItems as $menuItem)
		{
			if ($this->hasAdminController($menuItem->name))
			{
				$this->menuItems[] = $menuItem;
			}
		}

//		foreach($menuItems as $menuItem)
//		{
//			if ($this->hasAdminController($menuItem->name))
//			{
//				if ($menuItem->icon != '')
//				{
//					$value['icon'] = $menuItem->icon;
//					$value['url'] = '/admin/'.$menuItem->name;
//				}
//				else
//				{
//					$value = '/admin/'.$menuItem->name;
//				}
//				$this->menuItems[$menuItem->long_name] = $value;
//			}
//		}

		\Yii::$app->layout = 'admin.tpl';
	}

	public function beforeAction($action)
	{
		$moduleName = $this->module->id;
		/** @var Module $module */
		$module = Module::findOne(['name' => $moduleName]);
//		$this->checkAdminAccess($module);

		$this->currentModule = $module;

		return true;
	}

	/**
	 * @param \app\module\module\models\Module $moduleInstalled
	 * @throws NotFoundHttpException
	 */
	private function checkAdminAccess($moduleInstalled)
	{
		if ($moduleInstalled->admin_access == false)
		{
			if (\Yii::$app->user->can('accessModule') == false)
			{
				throw new NotFoundHttpException('You are not authorized to access this area');
			}
		}

	}

	/**
	 * @param $moduleId
	 * @return bool
	 */
	private function hasAdminController($moduleId)
	{
		$module = Yii::$app->getModule($moduleId);
		if (is_null($module))
		{
			return false;
		}
		return !empty(glob($module->getControllerPath().'/*AdminController.php'));
	}
}