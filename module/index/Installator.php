<?php
/**
 * @user: Pawel Babilas
 * @date: 21.12.2015
 */

namespace app\module\index;


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
		return true;
	}

	public function dropModule()
	{
		return true;
	}

}