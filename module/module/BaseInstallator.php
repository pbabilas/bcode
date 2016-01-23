<?php

namespace app\module\module;

use app\module\module\exception\InstallFailedException;
use app\module\module\exception\ModuleValidationException;
use app\module\module\models\Module as ModuleModel;
use yii\base\Module as BaseModule;

/**
 * @user: Pawel Babilas
 * @date: 21.12.2015
 */
class BaseInstallator
{

	const MODULE_NAMESPACE_PATTERN = 'app\module\%s\Installator';

	/** @var BaseModule  */
	private $module;

	/**
	 * @param BaseModule $module
	 */
	public function __construct(BaseModule $module)
	{
		$this->module = $module;
	}

	/**
	 * @param array $data
	 *
	 * @return bool
	 *
	 * @throws InstallFailedException
	 * @throws ModuleValidationException
	 */
	public function runWithData($data = [])
	{
		$module = $this->getModule();
		$module->load($data);
		if ($module->save() == false)
		{
			$exception = new ModuleValidationException();
			$exception->setModel($module);
			throw $exception;
		}

		$installator = $module->getInstallator();
		$result = $installator->install();

		if ($result == false)
		{
			$messages = $installator->getErrorMessages();
			throw new InstallFailedException(join("\n", $messages));
		}

		return $result;
	}

	/**
	 * @return ModuleModel
	 */
	private function getModule()
	{
		/** @var ModuleModel $module */
		$module = ModuleModel::findOne(['name' => $this->module->id]);
		if (is_null($module))
		{
			$module = new ModuleModel();
		}

		return $module;
	}

}