<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 28.11.15
 * Time: 22:30
 */

namespace app\common;


use Yii;

abstract class AbstractAdminController extends AbstractController
{
	public function init()
	{
		\Yii::$app->layout = 'admin.tpl';
	}

	public function beforeAction($action)
	{
		if (\Yii::$app->user->isGuest)
		{
			\Yii::$app->user->setReturnUrl(\Yii::$app->request->url);
			$this->addMessage('user', 'restricted_area', Message::ALERT);
			$this->redirect('/user/login');
			return false;
		}
		return true;
	}
}