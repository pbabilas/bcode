<?php
/**
 * @author: Paweł Babilas
 * @date: 07.04.2015
 */

namespace app\decorator;

use app\helper\LanguageHelper;
use app\module\language\models\Language;
use yii\db\ActiveRecord;
use yii\flags\Flags;
use yii\helpers\Html;

class HTMLDecorator extends Html
{
	public static function multiLangInput(ActiveRecord $object, $type, $name = null, $options = [])
	{
		$languages = Language::find()->all();

		$html = '';
		/** @var Language $lang */
		foreach ($languages as $lang)
		{
			$field = LanguageHelper::processForLang($name, $lang);
			$value = $object->$field;

			$reflectionCLass = new \ReflectionClass($object);
			$shortName = $reflectionCLass->getShortName();

			$fieldName = $shortName.'['.$field.']';

			$langSymbol = $lang->symbol;
			$html .= "<div class='lang' data-lang='$langSymbol'>";
			$html .= parent::input($type, $fieldName, $value, $options);
			$html .= "</div>";
		}

		return $html;
	}

	public static function multiLangTextarea($object, $name, $options)
	{
		$languages = Language::find()->all();

		$html = '';
		/** @var Language $lang */
		foreach ($languages as $lang)
		{
			$field = LanguageHelper::processForLang($name, $lang);
			$value = $object->$field;

			$reflectionCLass = new \ReflectionClass($object);
			$shortName = $reflectionCLass->getShortName();

			$fieldName = $shortName.'['.$field.']';

			$langSymbol = $lang->symbol;
			$html .= "<div class='lang' data-lang='$langSymbol'>";
			$html .= parent::textarea($fieldName, $value, $options);
			$html .= "</div>";
		}

		return $html;
	}

	public static function langSwitcher()
	{
		$languages = Language::find()->all();

		$html = '<div class="pull-right langs">';

		$i = 0;
		/** @var Language $language */
		foreach ($languages as $language)
		{
			$currentLang = \Yii::$app->language;

			$currentClass = $currentLang == $language->symbol ? ' class="current"' : '';

			$lang = $language->symbol == 'en' ? 'gb' : $language->symbol;
			$langIco = $flag = Flags::widget([
				'flag' => $lang,
				'type' => Flags::SHINY_16,
				'useSprite' => false
			]);
			$html .= '<a href="#" data-src="'.$language->symbol.'"'.$currentClass.'>'.$langIco.'</a>';
			$i++;
		}

		$html .= '</div>';

		return $html;
	}
}