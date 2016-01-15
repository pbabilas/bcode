<?php
/**
 * @user: Pawel Babilas
 * @date: 21.12.2015
 */

namespace app\module\module;


use app\common\AbstractInstallator;
use app\helper\LanguageHelper;
use app\module\language\models\Language;

class Installator extends AbstractInstallator
{

	/**
	 * @return array
	 */
	protected function getInstallActions()
	{
		return [
			1 => 'createTable',
			2 => 'createCategory',
			3 => 'createCategoryConnection',
			4 => 'addOrdering'
		];
	}

	/**
	 * @return array
	 */
	protected function getUninstallActions()
	{
		return [
			1 => 'dropTable',
			2 => 'dropCategoryTable'
		];
	}

	protected function createTable()
	{
		$cols['id'] = 'pk';
		$cols['name'] = 'varchar(255) COLLATE utf8_unicode_ci NOT NULL';
		$cols['is_active'] = 'tinyint(4) NOT NULL';

		foreach (Language::find()->all() as $lang)
		{
			$title = LanguageHelper::processForLang('long_name', $lang);
			$cols[$title] = "varchar(255) COLLATE utf8_unicode_ci NOT NULL";
		}

		$cols['version'] = "int(11) NOT NULL DEFAULT '0'";
		$cols['technical_user_only'] = "tinyint(1) NOT NULL DEFAULT '0'";
		$cols['admin_access'] = "tinyint(1) NOT NULL DEFAULT '1'";
		$cols['icon'] = "varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL";

		$options = "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

		$query = \Yii::$app->getDb()->queryBuilder;
		$createTableSyntax = $query->createTable('core_module', $cols, $options);

		$db = \Yii::$app->getDb();
		$db->createCommand($createTableSyntax)->execute();

		$query = $this->db->queryBuilder;
		$createIndexSyntax = $query->createIndex('name', 'core_module', 'name', true);
		$this->db->createCommand($createIndexSyntax)->execute();

	}

	protected function dropTable()
	{
		$sql = 'DROP TABLE `core_module`';

		$db = \Yii::$app->getDb();
		$db->createCommand($sql)->execute();
	}

	public function createCategory()
	{
		$cols['id'] = 'pk';
		foreach (Language::find()->all() as $lang)
		{
			$name = LanguageHelper::processForLang('name', $lang);
			$cols[$name] = "varchar(255) DEFAULT NULL";
		}
		$cols['ordering'] = 'int(11) DEFAULT NULL';

		$options = 'ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8';

		$query = $this->db->getQueryBuilder();
		$createTableSyntax = $query->createTable('core_category', $cols, $options);

		$this->db->createCommand($createTableSyntax)->execute();
	}

	public function dropCategoryTable()
	{
		$sql = "DROP TABLE `core_category`";

		$this->db->createCommand($sql);
	}

	public function createCategoryConnection()
	{
		$sql = "ALTER TABLE `core_module` ADD `category_id` INT(11)  NOT NULL DEFAULT 3  AFTER `icon`;";
		$this->db->createCommand($sql)->execute();

		$addForeginKeySyntax = "ALTER TABLE `core_module` ADD FOREIGN KEY (`category_id`) REFERENCES `core_category` (`id`)";
		$this->db->createCommand($addForeginKeySyntax)->execute();
	}

	public function dropCategoryConnection()
	{
		$sql = "ALTER TABLE `core_module` DROP COLUMN `category_id`";

		$this->db->createCommand($sql)->execute();
	}

	public function addOrdering()
	{
		$sql = "ALTER TABLE `core_module` ADD `ordering` INT(2)  NOT NULL  AFTER `category_id`";

		$this->db->createCommand($sql)->execute();
	}
}