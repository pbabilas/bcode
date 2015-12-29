<?php

namespace app\module\module;

use app\common\AbstractInstallator;
use app\module\module\exception\InstallFailedException;
use app\module\module\exception\ModuleInstallatorNotFound;
use app\module\module\exception\ModuleValidationException;
use app\module\module\models\Module as ModuleModel;
use yii\base\Module as BaseModule;

/**
 * @user: Pawel Babilas
 * @date: 21.12.2015
 */
class Installator
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
	public function runWithData($data)
	{
		$module = $this->getModule();
		$module->load($data);
		if ($module->save() == false)
		{
			$exception = new ModuleValidationException();
			$exception->setModel($module);
			throw $exception;
		}

		$installator = $this->getModuleInstallator($module);
		$result = $installator->run();

		if ($result == false)
		{
			$messages = $installator->getErrorMessages();
			throw new InstallFailedException(join("\n", $messages));
		}

		return $result;
	}

	/**
	 * @param ModuleModel $module
	 *
	 * @return AbstractInstallator|bool
	 *
	 * @throws ModuleInstallatorNotFound
	 */
	private function getModuleInstallator(ModuleModel $module)
	{
		$installatorClassName = sprintf(Installator::MODULE_NAMESPACE_PATTERN, $this->module->id);

		if (class_exists($installatorClassName))
		{
			$installator = new $installatorClassName($module);

			if ($installator instanceof AbstractInstallator)
			{
				return $installator;
			}
		}

		throw new ModuleInstallatorNotFound($module->name);
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