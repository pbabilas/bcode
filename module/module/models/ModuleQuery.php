<?php
/**
 * @user: Pawel Babilas
 * @date: 14.01.2016
 */

namespace app\module\module\models;


use yii\db\ActiveQuery;

class ModuleQuery extends ActiveQuery
{
	public static function findAllOrdered()
	{
		$sql = "SELECT cm.*, cc.name__pl as category_name FROM core_module cm
			JOIN core_category cc ON cc.id = cm.category_id
			ORDER BY cc.`ordering`,  cm.ordering";

		return Module::findBySql($sql)->all();
	}
}