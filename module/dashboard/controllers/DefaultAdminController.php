<?php

namespace app\module\dashboard\controllers;


use app\common\AbstractAdminController;
use app\helper\LanguageHelper;
use app\module\language\models\Language;
use app\module\user\models\User;
use Yii;

class DefaultAdminController extends AbstractAdminController
{
	/**
	 * @return mixed
	 */
	public function actionIndex()
	{

		$cols = [
			'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
			'created_at' => 'datetime NOT NULL',

		];

		$langCols = [];
		foreach (Language::find()->all() as $lang)
		{
			$langCols[LanguageHelper::processForLang('title', $lang)] = 'varchar(255) NOT NULL';
			$langCols[LanguageHelper::processForLang('body', $lang)] = 'longtext';
		}

		$cols = array_merge($cols, $langCols);


		$queryBuilder = \Yii::$app->getDb()->getQueryBuilder();
		$sql = $queryBuilder->createTable('page', $cols, 'ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;');

		var_dump($sql);
		die();

//		$auth = \Yii::$app->authManager;
//		$admin = $auth->createRole('accessModule');
//		$auth->add($admin);
//
//		$auth = Yii::$app->authManager;
//		$moduleRole = $auth->createRole('adminAccess');
//		$auth->add($moduleRole);
//
//		/** @var User $user */
//		$user = User::findOne(['id' => 3]);
//		$role = $auth->getRole('accessModule');
//		$auth->assign($role, $user->getId());
//
//		die('added');

       	return $this->render('index.tpl');
	}

}
