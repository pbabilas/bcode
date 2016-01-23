<?php
/**
 * @user: Pawel Babilas
 * @date: 19.01.2016
 */

namespace app\module\dashboard\widget;


use app\module\dashboard\interfaces\WidgetInterface;
use Yii;

class Finder
{
	const WIDGET_CLASS_MAP_PATH = '/runtime/widget_class_map.php';

	/** @var array  */
	private $widgetsClassName;

	public function __construct()
	{
		$classMapPath = Yii::$app->getBasePath() . Finder::WIDGET_CLASS_MAP_PATH;
		$this->widgetsClassName = require_once( $classMapPath );
	}

	/**
	 * @return array
	 */
	public function getAll()
	{
		$widgets = [];
		foreach ($this->widgetsClassName as $className)
		{
			$widgets[] = new $className();
		}

		return $widgets;
	}

	/**
	 * @param int $offset
	 * @return WidgetInterface
	 */
	public function offsetGet($offset)
	{
		return $this->widgetsClassName[$offset];
	}
}