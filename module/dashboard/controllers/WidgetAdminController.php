<?php

namespace app\module\dashboard\controllers;


use app\common\AbstractAdminController;
use app\module\dashboard\models\Widget;
use app\module\dashboard\widget\Finder;
use Yii;
use yii\base\Exception;

class WidgetAdminController extends AbstractAdminController
{

	const MENU_ITEM = false;

	/**
	 * @return mixed
	 */
	public function actionAdd($offset)
	{
		$finder = new Finder();

		$className = $finder->offsetGet($offset);

		$widget = new Widget();
		$widget->class_name = $className;
		$widget->save();

		$widgets = Widget::find()->all();
		return $this->renderAjax('admin/widgets.tpl', [
			'widgets' => $widgets
		]);
	}

	/**
	 * @param integer $id
	 *
	 * @return string
	 *
	 * @throws \Exception
	 */
	public function actionDelete($id)
	{
		try
		{
			/** @var Widget $widget */
			$widget = Widget::findOne(['id' => $id]);
			$widget->delete();
		}
		catch( Exception $e )
		{
		}

		$widgets = Widget::find()->all();
		return $this->renderAjax('admin/widgets.tpl', [
			'widgets' => $widgets
		]);
	}
}
