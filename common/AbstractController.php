<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 29.11.15
 * Time: 19:44
 */

namespace app\common;


use Yii;
use yii\db\ActiveRecord;
use yii\web\Controller;

class AbstractController extends Controller
{
	public function init()
	{
		//here
	}

	/**
	 * @param ActiveRecord $model
	 */
	public function addErrorMessagesFromModel(ActiveRecord $model)
	{
		foreach ($model->getErrors() as $fieldWithErrors)
		{
			foreach($fieldWithErrors as $error)
			{
				$this->addMessage(null, $error, Message::ALERT);
			}
		}
	}

	/**
	 * @param string $type
	 * @param string $module
	 * @param string $message
	 */
	public function addMessage($module = null, $message, $type = null)
	{
		if (is_null($module))
		{
			$message = new Message("`$module.$message`", $type);
		}
		else
		{
			$message = new Message($message, $type);
		}
		Yii::$app->session->addFlash($message->getType(), $message->getContent());
	}

	/**
	 * @param array $pieces
	 */
	public function addBreadcrumb($pieces = [])
	{
		foreach ($pieces as $pice)
		{
			$this->view->params['breadcrumbs'][] = $pice;
		}
	}
}