<?php
/**
 * @user: Pawel Babilas
 * @date: 21.12.2015
 */

namespace app\module\user;


use app\common\AbstractInstallator;

class Installator extends AbstractInstallator
{

	/**
	 * @return array
	 */
	protected function getInstallActions()
	{
		return [
			1 => 'init',
			2 => 'addUserPic',
			3 => 'addUserRoles'
		];
	}

	/**
	 * @return array
	 */
	protected function getUninstallActions()
	{
		return [
			1 => 'dopTable',
			2 => 'dropUserPic',
			3 => 'dropUserRoles'
		];
	}

	protected function init()
	{
		$sql = "CREATE TABLE `user` (
		  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `name` varchar(100) NOT NULL DEFAULT '',
		  `password` varchar(255) NOT NULL DEFAULT '',
		  `authKey` varchar(100) DEFAULT '',
		  `accessToken` varchar(100) DEFAULT NULL,
		  `email` varchar(100) NOT NULL DEFAULT '',
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `name` (`name`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		$this->db->createCommand($sql)->execute();
	}

	protected function dropTable()
	{
		$this->db->createCommand('DROP TABLE `user`')->execute();
	}

	protected function addUserPic()
	{
		$sql = "ALTER TABLE `user` ADD COLUMN `picture_filename` VARCHAR(255) NULL";
		$sql2 = "ALTER TABLE `user` ADD UNIQUE INDEX (`picture_filename`)";
		$this->db->createCommand($sql)->execute();
		$this->db->createCommand($sql2)->execute();
	}

	protected function dropUserPic()
	{
		$sql = "ALTER TABLE `user` DROP COLUMN `picture_filename`";
		$sql2 = "ALTER TABLE `user` DROP INDEX `picture_filename`";
		$this->db->createCommand($sql)->execute();
		$this->db->createCommand($sql2)->execute();
	}

	public function addUserRoles()
	{
		$auth = \Yii::$app->getAuthManager();
		$admin = $auth->createRole('admin');
		$other = $auth->createRole('other');

		$auth->add($admin);
		$auth->add($other);
	}

	public function dropUserRoles()
	{
		$auth = \Yii::$app->getAuthManager();
		$admin = $auth->getRole('admin');
		$other = $auth->getRole('other');

		$auth->remove($admin);
		$auth->remove($other);
	}
}