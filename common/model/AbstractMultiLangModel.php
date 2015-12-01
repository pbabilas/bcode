<?php
/**
 * @author: Paweł Babilas
 * @date: 08.04.2015
 */

namespace app\common\model;

use app\common\interfaces\MultiLangModelInterface;
use yii\db\ActiveRecord;

abstract class AbstractMultiLangModel extends ActiveRecord implements MultiLangModelInterface
{
	public function get($field)
	{
		$language = \Yii::$app->language;

		$langField = $field.'__'.$language;

		return $this->$langField;
	}
}