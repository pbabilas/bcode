<?php
/**
 * @user: Pawel Babilas
 * @date: 26.12.2015
 */

namespace app\common\query;


use yii\db\mssql\QueryBuilder;

class Builder extends QueryBuilder
{
	public function createTable($table, $columns, $options = null)
	{
		$primaryKey = '';
		$cols = [];
		foreach ($columns as $name => $type) {
			if (is_string($name)) {
				$cols[] = "\t" . $this->db->quoteColumnName($name) . ' ' . $this->getColumnType($type);
			} else {
				$cols[] = "\t" . $type;
			}

			if ($type == 'pk')
			{
				$primaryKey = "PRIMARY KEY (`$name`)";
			}
		}

		$sql = sprintf("CREATE TABLE %s \n %s \n %s", $this->db->quoteTableName($table), implode(",\n", $cols), $primaryKey);

		return $options === null ? $sql : $sql . ' ' . $options;
	}
}