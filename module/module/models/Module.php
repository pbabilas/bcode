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
 * @property integer $category_id
 * @property integer $ordering
 */
class Module extends AbstractMultiLangModel
{

	public $category_name;

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
			[['name', 'is_active', 'category_id', 'ordering'], 'required'],
			[['is_active', 'version', 'technical_user_only', 'admin_access', 'category_id', 'ordering'], 'integer'],
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

	/**
	 * @return Category|null
	 */
	public function getCategory()
	{
		return $this->hasOne(Category::className(), ['id' => 'category_id'])->one();
	}

	public function beforeValidate()
	{
		$sql = "SELECT * FROM core_module WHERE category_id = :categoryId ORDER BY ordering DESC";

		/** @var Module $module */
		$module = Module::findBySql($sql, [':categoryId' => $this->category_id])->one();
		$maxOrdering = is_null($module) ? 1 : $module->ordering +1;

		$this->ordering = $maxOrdering +1;

		return parent::beforeValidate(); // TODO: Change the autogenerated stub
	}

	public function getAdminControllers()
	{
		$module = Yii::$app->getModule($this->name);
		if (is_null($module))
		{
			return false;
		}

		/** @var string $file */
		foreach(glob($module->getControllerPath().'/*AdminController.php') as $file)
		{
			$className = basename($file, '.php');
			$reflectionClass = new \ReflectionClass($module->controllerNamespace . '\\' . $className);

			if($reflectionClass->isSubclassOf('app\common\AbstractController'))
			{
				if ($reflectionClass->getConstant('MENU_ITEM'))
				{
					$controllers[] = strtolower(str_replace('AdminController', '', $reflectionClass->getShortName()));
				}
			}
		}


		return isset($controllers) ? $controllers : false;
	}

}
