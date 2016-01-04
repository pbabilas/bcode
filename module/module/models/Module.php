<?php

namespace app\module\module\models;

use app\common\AbstractInstallator;
use app\common\model\AbstractMultiLangModel;
use app\module\language\factory\LanguageFieldFactory;
use app\module\module\exception\ModuleInstallatorNotFound;
use app\module\module\BaseInstallator;
use Yii;

/**
 * This is the model class for table "module".
 *
 * @property integer $id
 * @property string $name
 * @property integer $is_active
 * @property string $long_name
 * @property integer $version
 * @property integer technical_user_only
 * @property integer admin_access
 * @property string $icon
 */
class Module extends AbstractMultiLangModel
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'core_module';
	}

	public function init()
	{
		$this->fillEmptyMultilangFields();
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			LanguageFieldFactory::process('long_name', ['required']),
			[['name', 'is_active'], 'required'],
			[['is_active', 'version', 'technical_user_only', 'admin_access'], 'integer'],
			LanguageFieldFactory::process('long_name', ['string', 'max' => 255]),
			[['name'], 'string', 'max' => 255],
			[['icon'], 'string', 'max' => 32],
			[['name'], 'unique']
		];
	}

	/**
	 * If multilang, return array like
	 *
	 *    [
	 *        field,
	 *        field,
	 *        ...,
	 *        field
	 *    ]
	 *
	 * @return array
	 */
	public function getMultiLangFields()
	{
		return [
			'long_name'
		];
	}

	/**
	 * @return boolean
	 */
	public function isEnabled()
	{
		return $this->is_active;
	}

	/**
	 * @return int
	 */
	public function getNewestVersionId()
	{
		try
		{
			$installator = $this->getInstallator();
			return $installator->getActualVersion();
		}
		catch (ModuleInstallatorNotFound $e)
		{
			return 0;
		}
	}

	/**
	 * @return bool
	 */
	public function isActual()
	{
		return $this->version >= $this->getNewestVersionId();
	}

	/**
	 * @return AbstractInstallator
	 *
	 * @throws ModuleInstallatorNotFound
	 */
	public function getInstallator()
	{
		$installatorClassName = sprintf(BaseInstallator::MODULE_NAMESPACE_PATTERN, $this->name);

		if (class_exists($installatorClassName))
		{
			$installator = new $installatorClassName($this);

			if ($installator instanceof AbstractInstallator)
			{
				return $installator;
			}
		}

		throw new ModuleInstallatorNotFound($this->name);
	}
}
