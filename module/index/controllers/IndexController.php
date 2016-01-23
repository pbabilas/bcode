<?php

namespace app\module\index\controllers;


use app\common\AbstractController;
use Yii;

class IndexController extends AbstractController
{
	/**
	 * @return mixed
	 */
	public function actionIndex()
	{
       	return $this->render('index.tpl');
	}

}
