<?php

namespace app\module\module;

use app\module\module\exception\InstallFailedException;
use app\module\module\exception\ModuleValidationException;
use app\module\module\models\Module as ModuleModule;

/**
 * @user: Pawel Babilas
 * @date: 21.12.2015
 */
class BaseUninstallator
{

	const MODULE_NAMESPACE_PATTERN = 'app\module\%s\Installator';

	/** @var ModuleModule*/
	private $module;

	/**
	 * @param ModuleModule $module
	 */
	public function __construct(ModuleModule $module)
	{
		$this->module = $module;
	}

	/**
	 * @return bool
	 *
	 * @throws InstallFailedException
	 * @throws ModuleValidationException
	 */
	public function run()
	{
		$installator = $this->module->getInstallator();
		$result = $installator->uninstall();

		if ($result == false)
		{
			$messages = $installator->getErrorMessages();
			throw new InstallFailedException(join("\n", $messages));
		}

		return $result;
	}

}