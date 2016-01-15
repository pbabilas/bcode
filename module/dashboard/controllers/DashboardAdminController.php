<?php

namespace app\module\dashboard\controllers;


use app\common\AbstractAdminController;
use app\module\user\models\User;
use Yii;

class DashboardAdminController extends AbstractAdminController
{
	/**
	 * @return mixed
	 */
	public function actionIndex()
	{
//		$auth = \Yii::$app->authManager;
//		$admin = $auth->createRole('adminAccess');
//		$auth->add($admin);
//
//		$auth = Yii::$app->authManager;
//		$moduleRole = $auth->createRole('accessModule');
//		$auth->add($moduleRole);
//
//		/** @var User $user */
//		$user = User::findOne(['id' => 3]);
//		$role = $auth->getRole('accessModule');
//		$auth->assign($role, $user->getId());
//
//		die('done');
       	return $this->render('admin/index.tpl');
	}

}
