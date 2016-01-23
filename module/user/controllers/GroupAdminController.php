<?php
/**
 * @user: Pawel Babilas
 * @date: 16.01.2016
 */

namespace app\module\user\controllers;


use app\common\AbstractAdminController;
use app\module\module\Finder;
use app\module\user\models\Group;
use Yii;

class GroupAdminController extends AbstractAdminController
{

	const MENU_NAME = 'Grupy';

	public function actionIndex()
	{
		return $this->render('admin/index.tpl', [
			'groups' => Group::findAll()
		]);
	}

	public function actionNew()
	{
		$model = new Group();

		if (Yii::$app->request->isPost)
		{
			$transaction = Yii::$app->getDb()->beginTransaction();
			$model->load(Yii::$app->request->post());

			if ($model->save())
			{
				$transaction->commit();
				$this->addMessage('group', 'created');
				return $this->redirect('/admin/user/group');
			}

			$transaction->rollBack();
			foreach ($model->getErrors() as $error)
			{
				$this->addMessage(null, $error);
			}
		}

		$this->view->title = '`group.new_group`';
		$this->addBreadcrumb([
			['label' => '`user.user`', 'url' => 'admin/user'],
			['label' => '`group.group`', 'url' => ['index']],
			$this->view->title
		]);
		return $this->render('admin/new.tpl', [
			'group' => $model,
			'finder' => new Finder()
		]);
	}

	public function actionEdit($name)
	{
		$model = Group::findOne($name);

		if (is_null($model))
		{
			$this->addMessage('group', 'no_group_found');
			return $this->redirect('/admin/user/group');
		}

		if (Yii::$app->request->isPost)
		{
			$transaction = Yii::$app->getDb()->beginTransaction();
			$model->load(Yii::$app->request->post());

			if ($model->save())
			{
				$transaction->commit();
				$this->addMessage('group', 'created');
				return $this->redirect('/admin/user/group');
			}

			$transaction->rollBack();
			foreach ($model->getErrors() as $error)
			{
				$this->addMessage(null, $error);
			}
		}

		$this->view->title = '`group.new_group`';
		$this->addBreadcrumb([
			['label' => '`user.user`', 'url' => 'admin/user'],
			['label' => '`group.group`', 'url' => ['index']],
			$this->view->title
		]);
		return $this->render('admin/new.tpl', [
			'group' => $model,
			'finder' => new Finder()
		]);
	}

	public function actionDelete($name)
	{
		$group = Group::findOne($name);

		if ($group->delete())
		{
			$this->addMessage('group', 'delete_sucessfull');
			return $this->redirect('/admin/user/group');
		}
	}

}