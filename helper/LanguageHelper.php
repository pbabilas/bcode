<?php
/**
 * @author: Paweł Babilas
 * @date: 02.04.2015
 */

namespace app\helper;


use app\module\language\models\Language;

class LanguageHelper
{
	public static function process($field)
	{
		$lang = \Yii::$app->language;

		return $field.'__'.$lang;
	}

	public static function processForLang($field, Language $lang)
	{
		return $field.'__'.$lang->symbol;
	}
}