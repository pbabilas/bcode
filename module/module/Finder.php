<?php
/**
 * @user: Pawel Babilas
 * @date: 21.12.2015
 */

namespace app\module\module;


class Finder
{
	/** @var array */
	private $modules;

	public function __construct()
	{
		$this->modules = \Yii::$app->getModules();
	}

	/**
	 * @return array
	 */
	public function getToInstall()
	{
		$modulesInstalled = \app\module\module\models\Module::find()->all();
		$modules = $this->modules;

		/** @var Module $installedMod */
		foreach ($modulesInstalled as $installedMod)
		{
			if (array_key_exists($installedMod->name, $modules))
			{
				unset($modules[$installedMod->name]);
			}
		}

		unset($modules['debug']);
		unset($modules['gii']);

		return $modules;
	}

	/**
	 * @return array
	 */
	public function getAll()
	{
		return $this->modules;
	}

	/**
	 * @return array
	 */
	public function getAllSystemModules()
	{
		$modules = $this->modules;

		unset($modules['debug']);
		unset($modules['gii']);

		return $modules;
	}
}