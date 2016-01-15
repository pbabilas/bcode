<?php

namespace app\module\user\controllers;

use app\common\AbstractAdminController;
use app\common\Message;
use app\module\user\models\User;
use app\module\user\security\Auth;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class AuthAdminController extends AbstractAdminController
{
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
                    'logout' => ['get']
				],
			],
		];
	}

	public function init()
	{
		Yii::$app->layout = 'login.tpl';
		parent::init();
	}

	/**
	 * Lists all User models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$this->redirect('user/login');
	}

    public function actionLogout()
    {
		$auth = new Auth();
		if ($auth->logout())
		{
			$this->addMessage('user', 'logout_succesfull', Message::INFO);
		}

		return $this->redirect('/admin/user/auth/login');
    }

    public function actionLogin()
    {
        $userCandidate = new User();

		if (\Yii::$app->request->isPost)
		{
			$userCandidate->load(\Yii::$app->request->post());

			$auth = new Auth();
			$result = $auth->login($userCandidate);

			if ($result)
			{
				$this->addMessage('user', 'login_succesfull', Message::INFO);
				return $this->redirect(\Yii::$app->user->getReturnUrl());
			}

			$userCandidate->password = '';
			$this->addMessage('user', 'wrong_data_given', Message::ALERT);
		}

		return $this->render('admin/login.tpl', [
			'user' => $userCandidate,
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
		if (($model = User::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
