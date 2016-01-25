<?php
/**
 * @user: Pawel Babilas
 * @date: 21.12.2015
 */

namespace app\module\task;


use app\common\AbstractInstallator;

class Installator extends AbstractInstallator
{

	/**
	 * @return array
	 */
	protected function getInstallActions()
	{
		return [
			1 => 'createTable',
		];
	}

	/**
	 * @return array
	 */
	protected function getUninstallActions()
	{
		return [
			1 => 'dropTable'
		];
	}

	protected function createTable()
	{
		$sql = "
			CREATE TABLE `task` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `title` varchar(255) NOT NULL DEFAULT '',
			  `description` text,
			  `user_id` int(11) NOT NULL,
			  `created_at` datetime NOT NULL,
			  `updated_at` datetime NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		$this->db->createCommand($sql)->execute();
	}

	protected function dropTable()
	{
		$sql = "DROP TABLE `task`";

		$this->db->createCommand($sql)->execute();
	}
}