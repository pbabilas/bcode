<?php

namespace app\module\page\controllers;

use app\common\AbstractAdminController;
use app\common\Message;
use app\common\model\Searcher;
use PDO;
use Yii;
use app\module\page\models\Page;
use app\module\page\models\PageSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PageAdminController implements the CRUD actions for Page model.
 */
class PageAdminController extends AbstractAdminController
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

    public function actionIndex($page = 1)
    {
		$search = new Searcher(new Page());
		$search->setPage($page);
		$params = \Yii::$app->getRequest()->post('Page');
		$search->setParams((array) $params);

		$this->view->title = '`page.pages`';
		$this->addBreadcrumb([$this->view->title]);

        return $this->render('admin/index.tpl', [
            'search' => $search,
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
				$this->addMessage('page', 'new_created');
				return $this->redirect('page');
			}

			$this->addErrorMessagesFromModel($model);
		}

		$this->view->title = '`page.create_page`';
		$this->addBreadcrumb([
			['label' => '`page.Pages`', 'url' => ['index']],
			$this->view->title
		]);
		return $this->render('admin/create.tpl', [
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
		return $this->render('admin/edit.tpl', [
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
					return $this->redirect('admin/page');
				}

				$this->addErrorMessagesFromModel($model);
			}

			$this->view->title = '`page.update`';
			$this->addBreadcrumb([
				['label' => '`page.pages`', 'url' => ['index']],
				'`page.update`'
			]);

			$this->addMessage('page', 'updated_successful', Message::INFO);
			return $this->render('admin/update.tpl', [
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

        return $this->redirect('/admin/page/');
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
