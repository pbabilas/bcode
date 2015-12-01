<?php

namespace app\module\dashboard\controllers;


use app\common\AbstractAdminController;

class DefaultAdminController extends AbstractAdminController
{
	/**
	 * @return mixed
	 */
	public function actionIndex()
	{
       die('default admin dashboard');
	}

}
