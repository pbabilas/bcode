<?php
/**
 * @author: Paweł Babilas
 * @date: 07.04.2015
 */

namespace app\decorator;

use app\helper\LanguageHelper;
use app\module\language\models\Language;
use yii\db\ActiveRecord;
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
			$langOptions = ['data-lang' => $lang->symbol];

			if (array_key_exists('class', $options))
			{
				$options['class'] .= ' lang';
			}
			else
			{
				$options['class'] = 'lang';
			}

			$options = array_merge($options, $langOptions);

			$reflectionCLass = new \ReflectionClass($object);
			$shortName = $reflectionCLass->getShortName();

			$fieldName = $shortName.'['.$field.']';

			$html .= parent::input($type, $fieldName, $value, $options);
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
			$langOptions = ['data-lang' => $lang->symbol];

			if (array_key_exists('class', $options))
			{
				$options['class'] .= ' lang';
			}
			else
			{
				$options['class'] = 'lang';
			}

			$options = array_merge($options, $langOptions);

			$reflectionCLass = new \ReflectionClass($object);
			$shortName = $reflectionCLass->getShortName();

			$fieldName = $shortName.'['.$field.']';

			$html .= parent::textarea($fieldName, $value, $options);
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
			if ($i > 0)
			{
				$html .= ' | ';
			}

			$currentClass = $currentLang == $language->symbol ? ' class="current"' : '';

			$html .= '<a href="#" data-src="'.$language->symbol.'"'.$currentClass.'>'.strtoupper($language->symbol).'</a>';
			$i++;
		}

		$html .= '</div>';

		return $html;
	}
}