<?php

namespace app\module\user\controllers;

use app\common\AbstractAdminController;
use app\common\Message;
use app\module\module\Finder;
use app\module\thumbnailer\Constants;
use app\module\thumbnailer\picture\Uploader;
use app\module\user\models\User;
use app\module\user\models\UserSearch;
use Yii;
use yii\db\IntegrityException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;


class UserAdminController extends AbstractAdminController
{

	const MENU_NAME = 'Konta';

	/**
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new UserSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		$this->view->title = '`user.users`';

		$this->addBreadcrumb([$this->view->title]);

		return $this->render('admin/index.tpl', [
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

			$this->handleUploadedPicture($user);

			if ($user->save())
			{
				return $this->redirect('/admin/user');
			}

			$user->password = '';
			$this->addErrorMessagesFromModel($user);
		}

		$this->view->title = '`page.create_page`';

		$this->addBreadcrumb([
			['label' => '`user.user`', 'url' => ['index']],
			$this->view->title
		]);

		return $this->render('admin/create.tpl', [
			'user' => $user,
			'roles' => Yii::$app->getAuthManager()->getRolesByUser($user->id),
			'finder' => new Finder()
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
			$transaction = Yii::$app->getDb()->beginTransaction();
			$data = Yii::$app->request->post('User');

			$user->name = $data['name'];
			$user->email = $data['email'];
			$user->first_name = $data['first_name'];
			$user->surname = $data['surname'];
			$user->phone_number = $data['phone_number'];

			if ($data['password'] != '')
			{
				$user->setAccessToken();
				$user->setAuthKey();
				$user->password = Yii::$app->getSecurity()->generatePasswordHash($data['password']);
			}

			$this->handleUploadedPicture($user);

			if ($user->save())
			{
				$transaction->commit();
				$auth = Yii::$app->getAuthManager();
				$role = $auth->getRole(
					Yii::$app->request->post('Role')
				);

				$auth->revokeAll($user->id);
				$auth->assign($role, $user->id);

				$this->addMessage('user', 'all_done');
				return $this->redirect('/admin/user');
			}

			$transaction->rollBack();
			$this->addErrorMessagesFromModel($user);
		}

		$user->password = '';

		$this->view->title = '`user.update_user`';

		$this->addBreadcrumb([
			['label' => '`user.user`', 'url' => ['index']],
			$this->view->title
		]);

		return $this->render('admin/edit.tpl', [
			'user' => $user,
			'roles' => Yii::$app->getAuthManager()->getRolesByUser($user->id),
			'finder' => new Finder()
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
	 * @param User $user
	 */
	private function handleUploadedPicture(User $user)
	{
		$uploadedFile = UploadedFile::getInstanceByName('userPicture');
		if (is_null($uploadedFile) == false)
		{
			$uploader = new Uploader(Constants::PICTURES_PATH . User::PICTURE_DIR, true);
			$filename = $uploader->runforFile($uploadedFile);

			if ($filename == false)
			{
				$user->addError('picture_filename', '`user.file_upload_failed`');
			}
			else
			{
				$user->picture_filename = $filename;
			}
		}
	}
}
