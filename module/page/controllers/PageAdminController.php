<?php

namespace app\module\page\controllers;

use app\common\AbstractAdminController;
use app\common\Message;
use PDO;
use Yii;
use app\module\page\models\Page;
use app\module\page\models\PageSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PageAdminController implements the CRUD actions for Page model.
 */
class DefaultAdminController extends AbstractAdminController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {

//		$sql = "SELECT symbol FROM language";
//		$langs = \Yii::$app->getDb()->createCommand($sql)->queryAll(PDO::FETCH_COLUMN);
//		$defaultLang = \Yii::$app->sourceLanguage;
//
//		unset( $langs[ array_search($defaultLang, $langs )] ); // now contains langs without defaultLang
//
//		var_dump($langs);
//		die();

        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$this->view->title = '`page.pages`';
		$this->addBreadcrumb([$this->view->title]);

        return $this->render('index.tpl', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Page();

		if (Yii::$app->request->isPost)
		{
			$model->load(Yii::$app->request->post());

			if ($model->save())
			{
				return $this->redirect(['/admin/page']);
			}

			$this->addErrorMessagesFromModel($model);
		}

		$this->view->title = '`page.create_page`';
		$this->addBreadcrumb([
			['label' => '`page.Pages`', 'url' => ['index']],
			$this->view->title
		]);
		return $this->render('create.tpl', [
			'page' => $model,
		]);
    }

	public function actionEdit($id)
	{
		/** @var Page $model */
		$model = Page::findOne(['id' => $id]);

		if (Yii::$app->request->isPost)
		{
			$model->load(Yii::$app->request->post());

			if ($model->save())
			{
				$this->addMessage('page', 'updated_successful', Message::INFO);
				return $this->redirect(['/admin/page']);
			}

			$this->addErrorMessagesFromModel($model);
		}

		$this->view->title = '`page.edit_page`';
		$this->addBreadcrumb([
			['label' => '`page.Pages`', 'url' => ['index']],
			$this->view->title
		]);
		return $this->render('edit.tpl', [
			'page' => $model,
		]);
	}

    public function actionUpdate($id)
    {
		try
		{
			$model = $this->findModel($id);

			if (Yii::$app->request->isPost)
			{
				$model->load(Yii::$app->request->post());

				if ($model->save())
				{
					return $this->redirect(['/admin/page']);
				}

				$this->addErrorMessagesFromModel($model);
			}

			$this->view->title = '`page.update`';
			$this->addBreadcrumb([
				['label' => '`page.pages`', 'url' => ['index']],
				'`page.update`'
			]);

			$this->addMessage('page', 'updated_successful', Message::INFO);
			return $this->render('update.tpl', [
				'page' => $model,
			]);
		}
		catch (NotFoundHttpException $e)
		{
			$this->addMessage('page', 'not_found', Message::ALERT);
			return $this->redirect('index');
		}

    }

    public function actionDelete($id)
    {
		try
		{
			$this->findModel($id)->delete();
			$this->addMessage('page', 'deleted_successful', Message::INFO);
		}
		catch (NotFoundHttpException $e)
		{
			$this->addMessage('page', 'not_found', Message::ALERT);
		}

        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
	 *
     * @return Page
	 *
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}