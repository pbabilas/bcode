<?php
/**
 * @user: Pawel Babilas
 * @date: 21.12.2015
 */

namespace app\common;


use app\module\module\models\Module;
use yii\base\Exception;
use yii\data\ArrayDataProvider;

abstract class AbstractInstallator
{

	/** @var array  */
	private $errorMessages = [];

	/** @var \yii\db\Connection  */
	protected $db;

	/**
	 * @param Module $module
	 */
	public function __construct(Module $module)
	{
		$this->module = $module;
		$this->db = \Yii::$app->getDb();
	}

	/**
	 * @return bool
	 */
	public function install()
	{
		try
		{
			$actions = $this->getInstallActions();
			ksort($actions);

			$version = $this->module->version;
			$installableActions = array_slice($actions, $version, null, true);

			foreach($installableActions as $versionId => $action)
			{
				$this->$action();
				$this->module->version = $versionId;
			}

			if ($this->module->save() == false)
			{
				$this->errorMessages = array_merge($this->errorMessages, $this->module->getErrors());
				return false;
			}
			return true;
		}
		catch (Exception $e)
		{
			$this->errorMessages[] = $e->getMessage();
			return false;
		}
	}

	/**
	 * @return bool
	 */
	public function uninstall()
	{
		try
		{
			$actions = $this->getUninstallActions();
			krsort($actions);

			foreach($actions as $versionId => $action)
			{
				$this->$action();
			}

			if ($this->module->delete() == false)
			{
				$this->errorMessages = array_merge($this->errorMessages, $this->module->getErrors());
				return false;
			}
			return true;
		}
		catch (Exception $e)
		{
			$this->errorMessages[] = $e->getMessage();
			return false;
		}
	}

	/**
	 * @return array
	 */
	abstract protected function getInstallActions();

	/**
	 * @return array
	 */
	abstract protected function getUninstallActions();

	/**
	 * @return array
	 */
	public function getErrorMessages()
	{
		return $this->errorMessages;
	}

	/**
	 * @return int
	 */
	public function getActualVersion()
	{
		return max(array_keys($this->getInstallActions()));
	}

}