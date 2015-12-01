<?php
/**
 * @author: Paweł Babilas
 * @date: 02.04.2015
 */

namespace app\module\language\factory;


use app\module\language\models\Language;

class LanguageFieldFactory
{
	/**
	 * @param string $field
	 * @param array $rules
	 * @return array
	 */
	public static function process($field, $rules)
	{
		$languages = Language::find()->all();

		$fields = [];
		/** @var Language $language */
		foreach($languages as $language)
		{
			$fields[] = $field.'__'.$language->symbol;
		}

		$fields = array_merge([$fields], $rules);

		return $fields;
	}

}