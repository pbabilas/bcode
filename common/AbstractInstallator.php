<?php
/**
 * @user: Pawel Babilas
 * @date: 21.12.2015
 */

namespace app\common;


use app\module\module\models\Module;
use yii\base\Exception;

abstract class AbstractInstallator
{

	/** @var array  */
	private $errorMessages = [];

	/**
	 * @param Module $module
	 */
	public function __construct(Module $module)
	{
		$this->module = $module;
	}

	/**
	 * @return bool
	 */
	public function run()
	{
		try
		{
			$actions = $this->getActions();

			$version = $this->module->version;
			$version = 0;
			$installableActions = array_splice($actions, $version);

			foreach($installableActions as $action)
			{
				$this->$action();
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
	abstract protected function getActions();

	/**
	 * @return array
	 */
	public function getErrorMessages()
	{
		return $this->errorMessages;
	}

}