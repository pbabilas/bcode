<?php

namespace app\module\user\controllers;

use app\common\AbstractController;
use app\common\Message;
use app\module\user\models\User;
use Yii;
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
		if (\Yii::$app->user->logout())
		{
			$this->addMessage('user', 'logout_succesfull', Message::INFO);
			return $this->redirect('/user/login');
		}

		return $this->redirect('/user/login');
    }

    public function actionLogin()
    {
        $user = new User();

        if (\Yii::$app->request->isPost)
        {
			$userCandidate =  \Yii::$app->request->post('User');

			/** @var User $user */
			$user = User::find()
				->where(['name' => $userCandidate['name']])
				->one();

			if (
				is_null($user) == false &&
				$user->password == \Yii::$app->getSecurity()->validatePassword($userCandidate['password'], $user->password))
			{
				\Yii::$app->user->login($user, 3600);
				$this->addMessage('user', 'login_succesfull', Message::INFO);
				return $this->redirect(\Yii::$app->user->getReturnUrl());
			}

			$this->addMessage('user', 'wrong_data_given', Message::ALERT);
			$user->password = '';
        }

		return $this->render('login.tpl', [
			'user' => $user,
		]);

    }

	public function actionCreate()
	{
		$user = new User();

		$user->name = 'pbabilas';
		$user->email = 'babilas.pawel@gmail.com';
		$user->password = 'pawel123';

		$user->setAccessToken();
		$user->setAuthKey();
		$user->password = Yii::$app->getSecurity()->generatePasswordHash($user->password);
		var_dump($user);
		die('Dodaj ręcznie');

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
