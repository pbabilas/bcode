<?php
/**
 * @user: Pawel Babilas
 * @date: 21.12.2015
 */

namespace app\module\dashboard;


use app\common\AbstractInstallator;

class Installator extends AbstractInstallator
{

	/**
	 * @return array
	 */
	protected function getInstallActions()
	{
		return [
			1 => 'initModule',
		];
	}

	/**
	 * @return array
	 */
	protected function getUninstallActions()
	{
		return [
			1 => 'dropModule',
		];
	}

	public function initModule()
	{
		$sql = "
		  CREATE TABLE `dashboard_widget` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `class_name` varchar(255) NOT NULL DEFAULT '',
			  `params` text,
			  `width` int(2) NOT NULL,
			  `offset` int(2) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		$this->db->createCommand($sql)->execute();
	}

	public function dropModule()
	{
		$sql = "DROP TABLE `dashboard_widget`";

		$this->db->createCommand($sql)->execute();
	}

}