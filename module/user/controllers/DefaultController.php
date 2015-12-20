<?php

namespace app\module\user\controllers;

use app\common\AbstractController;
use app\common\Message;
use app\module\user\models\User;
use app\module\user\security\Auth;
use Yii;
use yii\base\ErrorException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class DefaultController extends AbstractController
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

		return $this->redirect('/user/login');
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

		return $this->render('login.tpl', [
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
