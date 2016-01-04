<?php

namespace app\module\module\controllers;

use app\common\AbstractAdminController;
use app\common\Message;
use app\module\module\BaseUninstallator;
use app\module\module\exception\InstallFailedException;
use app\module\module\exception\ModuleInstallatorNotFound;
use app\module\module\exception\ModuleValidationException;
use app\module\module\Finder;
use app\module\module\BaseInstallator;
use app\module\module\models\Module;
use yii\filters\VerbFilter;

/**
 * @user: Pawel Babilas
 * @date: 15.12.2015
 */
class DefaultAdminController extends AbstractAdminController
{
	public function behaviors()
	{
		return [
//			'verbs' => [
//				'class' => VerbFilter::className(),
//				'actions' => [
//					'do-install' => ['post'],
//				],
//			],
		];
	}

	public function actionIndex()
	{
		$modules = Module::find()->all();

		$this->view->title = '`module.modules`';
		$this->addBreadcrumb([$this->view->title]);

		return $this->render('index.tpl', [
			'modules' => $modules,
		]);
	}

	public function actionInstall()
	{
		$moduleFinder = new Finder();

		return $this->render('install.tpl', [
			'moduleFinder' => $moduleFinder,
			'module'       => new Module()
		]);
	}

	public function actionDoinstall()
	{
		$transaction = \Yii::$app->getDb()->beginTransaction();

		try
		{
			$data = \Yii::$app->request->post();
			$moduleId = $data['Module']['name'];
			$installator = new BaseInstallator(\Yii::$app->getModule($moduleId));
			$installator->runWithData($data);

			$transaction->commit();
			$this->addMessage('module', sprintf('Module %s was succesfull installed', $moduleId), Message::INFO);
		}
		catch (ModuleValidationException $e)
		{
			$transaction->rollBack();
			$this->addErrorMessagesFromModel($e->getModule());

			$moduleFinder = new Finder();

			return $this->render('install.tpl', [
				'moduleFinder' => $moduleFinder,
				'module' => $e->getModule()
			]);
		}
		catch (ModuleInstallatorNotFound $e)
		{
			$transaction->rollBack();
			$this->addMessage('module', 'instalator_not_found', Message::ALERT);
		}
		catch (InstallFailedException $e)
		{
			$transaction->rollBack();

			$message = sprintf("<pre>%s</pre>", $e->getMessage());

			$message = sprintf("`module.installation_error_with_message` \n %s", $message);
			$this->addMessage(null, $message, Message::ALERT);
		}

		return $this->redirect('/admin/module');
	}

	public function actionUninstall($id)
	{
		/** @var Module $module */
		$module = Module::findOne(['id' => $id]);
		if (is_null($module))
		{
			$this->addMessage('module', 'module_not_found', Message::ALERT);
			return $this->redirect('/admin/module');
		}

		$transaction = \Yii::$app->getDb()->beginTransaction();

		try
		{
			$installator = new BaseUninstallator($module);
			$installator->run();

			$transaction->commit();
			$this->addMessage('module', sprintf('Module %s was succesfull uninstalled', $module->name), Message::INFO);
		}
		catch (ModuleInstallatorNotFound $e)
		{
			$transaction->rollBack();
			$this->addMessage('module', 'instalator_not_found', Message::ALERT);
		}
		catch (InstallFailedException $e)
		{
			$transaction->rollBack();

			$message = sprintf("<pre>%s</pre>", $e->getMessage());

			$message = sprintf("`module.uninstall_error_with_message` \n %s", $message);
			$this->addMessage(null, $message, Message::ALERT);
		}

		return $this->redirect('/admin/module');
	}

	public function actionUpdate($id)
	{
		/** @var Module $module */
		$module = Module::findOne(['id' => $id]);
		if (is_null($module))
		{
			$this->addMessage('module', 'module_not_found', Message::ALERT);
			return $this->redirect('/admin/module');
		}

		$transaction = \Yii::$app->getDb()->beginTransaction();

		try
		{
			$installator = new BaseInstallator(\Yii::$app->getModule($module->name));
			$installator->runWithData();

			$transaction->commit();
			$this->addMessage('module', sprintf('Module %s was succesfull updated', $module->name), Message::INFO);
		}
		catch (ModuleInstallatorNotFound $e)
		{
			$transaction->rollBack();
			$this->addMessage('module', 'instalator_not_found', Message::ALERT);
		}
		catch (InstallFailedException $e)
		{
			$transaction->rollBack();

			$message = sprintf("<pre>%s</pre>", $e->getMessage());

			$message = sprintf("`module.uninstall_error_with_message` \n %s", $message);
			$this->addMessage(null, $message, Message::ALERT);
		}

		return $this->redirect('/admin/module');
	}
}