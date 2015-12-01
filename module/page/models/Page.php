<?php

namespace app\module\page\models;

use app\common\model\AbstractMultiLangModel;
use app\module\language\factory\LanguageFieldFactory;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $title
 * @property string $body
 * @property string $created_at
 */
class Page extends AbstractMultiLangModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			LanguageFieldFactory::process('body', ['string']),
            [['created_at'], 'safe'],
			LanguageFieldFactory::process('title', ['string', 'max' => 255]),
			LanguageFieldFactory::process('title', ['required']),
        ];
    }

	public function behaviors()
	{
		return [
			'dateTime' => [
				'class' => 'app\behaviour\DateTimeBehavior',
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
				],
			],
		];
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('page', 'id'),
            'title__pl' => Yii::t('page', 'title'),
            'body__pl' => Yii::t('page', 'body'),
            'created_at' => Yii::t('page', 'created_at'),
        ];
    }

    /**
     * @inheritdoc
     * @return PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
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
			'body',
			'title'
		];
	}
}
