<?php

namespace app\module\user\controllers;

use app\common\AbstractAdminController;
use app\common\Message;
use app\module\thumbnailer\Constants;
use app\module\thumbnailer\picture\Uploader;
use app\module\user\models\User;
use app\module\user\models\UserSearch;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;


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

		$this->addBreadcrumb([$this->view->title]);

		return $this->render('index.tpl', [
			'searchModel'  => $searchModel,
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

			if ($user->picture_filename = $this->handleUploadedPicture() == false)
			{
				$user->addError('picture_filename', '`user.file_upload_failed`');
			}

			if ($user->save())
			{
				if (Yii::$app->request->post('technical_user'))
				{
					$auth = Yii::$app->getAuthManager();
					$role = $auth->getRole('accessModule');
					$auth->assign($role, $user->getId());
				}

				return $this->redirect(['/admin/user']);
			}

			$user->password = '';
			$this->addErrorMessagesFromModel($user);
		}

		$this->view->title = '`page.create_page`';

		$this->addBreadcrumb([
			['label' => '`user.user`', 'url' => ['index']],
			$this->view->title
		]);

		return $this->render('create.tpl', [
			'user' => $user,
		]);
	}

	public function actionEdit($id)
	{
		/** @var User $user */
		$user = User::findOne(['id' => $id]);

		if (is_null($user))
		{
			return $this->redirect('admin/user');
		}

		if (Yii::$app->request->isPost)
		{
			$data = Yii::$app->request->post('User');

			$user->name = $data['name'];
			$user->email = $data['email'];

			if ($data['password'] != '')
			{
				$user->setAccessToken();
				$user->setAuthKey();
				$user->password = Yii::$app->getSecurity()->generatePasswordHash($data['password']);
			}

			$filename = $this->handleUploadedPicture();

			if ($filename == false)
			{
				$user->addError('picture_filename', '`user.file_upload_failed`');
			}
			else
			{
				$user->picture_filename = $filename;
			}

			if ($user->save())
			{
				$auth = Yii::$app->getAuthManager();
				if (Yii::$app->request->post('technical_user'))
				{
					$role = $auth->getRole('accessModule');
					$auth->assign($role, $user->getId());
				}
				else
				{
					//delete auth
				}

				return $this->redirect(['/admin/user']);
			}

			$this->addErrorMessagesFromModel($user);
		}

		$user->password = '';

		$this->view->title = '`user.update_user`';

		$this->addBreadcrumb([
			['label' => '`user.user`', 'url' => ['index']],
			$this->view->title
		]);

		return $this->render('edit.tpl', [
			'user' => $user,
		]);
	}

	public function actionDelete($id)
	{
		try
		{
			/** @var User $user */
			$user = $this->findModel($id);

			$user->delete();
			$this->addMessage('user', 'delete_success', Message::INFO);
		}
		catch (NotFoundHttpException $e)
		{
			$this->addMessage('user', 'not_found', Message::ALERT);
		}

		return $this->redirect('/admin/user');

	}


	/**
	 * @param integer $id
	 * @return User the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = User::findOne($id)) !== null)
		{
			return $model;
		}
		else
		{
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	/**
	 * @return bool|string filename
	 */
	private function handleUploadedPicture()
	{
		$uploadedFile = UploadedFile::getInstanceByName('userPicture');

		$uploader = new Uploader(Constants::PICTURES_PATH . User::PICTURE_DIR, true);
		return $uploader->runforFile($uploadedFile);
	}
}