<?php
/**
 * @user: Pawel Babilas
 * @date: 21.12.2015
 */

namespace app\module\page;


use app\common\AbstractInstallator;
use app\helper\LanguageHelper;
use app\module\language\models\Language;
use yii\db\mssql\QueryBuilder;

class Installator extends AbstractInstallator
{

	/**
	 * @return array
	 */
	protected function getActions()
	{
		return [
			1 => 'createTable'
		];
	}

	protected function createTable()
	{
		$cols['id'] = 'pk';
		$cols['created_at'] = 'datetime NOT NULL';

		foreach (Language::find()->all() as $lang)
		{
			$title = LanguageHelper::processForLang('title', $lang);
			$cols[$title] = "varchar(255) NOT NULL";
			$body = LanguageHelper::processForLang('body', $lang);
			$cols[$body] = "longtext";
		}
		$options = "ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		$query = \Yii::$app->getDb()->queryBuilder;
		$createTableSyntax = $query->createTable('page', $cols, $options);

		$db = \Yii::$app->getDb();
		$db->createCommand($createTableSyntax)->execute();
	}
}