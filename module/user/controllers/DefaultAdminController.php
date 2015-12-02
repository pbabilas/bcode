<?php

namespace app\module\user\controllers;

use app\common\AbstractAdminController;
use app\module\user\models\User;
use app\module\user\models\UserSearch;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class DefaultAdminController extends AbstractAdminController
{

	/**
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new UserSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		$this->view->title = '`user.users`';
		$this->view->params['breadcrumbs'][] = $this->view->title;

		return $this->render('index.tpl', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionCreate()
	{
		$user = new User();

		if (Yii::$app->request->isPost)
		{
			$user->load(Yii::$app->request->post());
			$user->setAccessToken();
			$user->setAuthKey();
			$user->password = Yii::$app->getSecurity()->generatePasswordHash($user->password);

			if ($user->save())
			{
				return $this->redirect(['/admin/user']);
			}


			$user->password = '';
			$this->addErrorMessagesFromModel($user);
		}

		$this->view->title = '`page.create_page`';
		$this->view->params['breadcrumbs'][] = ['label' => '`user.user`', 'url' => ['index']];
		$this->view->params['breadcrumbs'][] = $this->view->title;;
		return $this->render('create.tpl', [
			'user' => $user,
		]);
	}


	/**
	 * Finds the User model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return User the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = User::find($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
