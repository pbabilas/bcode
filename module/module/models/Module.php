<?php

namespace app\module\module\models;

use app\common\model\AbstractMultiLangModel;
use app\module\language\factory\LanguageFieldFactory;
use Yii;

/**
 * This is the model class for table "module".
 *
 * @property integer $id
 * @property string $name
 * @property integer $is_active
 * @property integer $is_visible
 * @property string $long_name__pl
 * @property string $long_name__en
 * @property integer $version
 * @property integer technical_user_only
 */
class Module extends AbstractMultiLangModel
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'module';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			LanguageFieldFactory::process('long_name', ['required']),
			[['name', 'is_active'], 'required'],
			[['is_active', 'is_visible', 'version', 'technical_user_only'], 'integer'],
			LanguageFieldFactory::process('long_name', ['string', 'max' => 255]),
			[['name'], 'string', 'max' => 255],
			[['name'], 'unique']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id'            => 'ID',
			'name'          => 'Name',
			'is_active'     => 'Is Active',
			'is_visible'    => 'Is Visible',
			'long_name__pl' => 'Long Name  Pl',
			'long_name__en' => 'Long Name  En',
			'version'       => 'Version',
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
}
