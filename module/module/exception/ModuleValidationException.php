<?php
/**
 * @user: Pawel Babilas
 * @date: 27.12.2015
 */

namespace app\module\module\exception;


use app\module\module\models\Module;

class ModuleValidationException extends \Exception
{

	private $module;

	public function setModel(Module $module)
	{
		$this->module = $module;
	}

	/**
	 * @return mixed
	 */
	public function getModule()
	{
		return $this->module;
	}
}