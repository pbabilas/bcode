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
	public function init()
	{
		\Yii::$app->layout = 'admin.tpl';
	}

	public function beforeAction($action)
	{
		if (\Yii::$app->user->isGuest)
		{
			\Yii::$app->user->setReturnUrl(\Yii::$app->request->url);
			$this->addMessage('user', 'restricted_area', Message::ALERT);
			$this->redirect('/user/login');
			return false;
		}

		$moduleName = $this->module->id;
		/** @var Module $module */
		$module = Module::findOne(['name' => $moduleName]);
		$this->checkAdminAccess($module);

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
}