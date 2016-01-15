<?php

namespace app\module\module\models;

use app\common\model\AbstractMultiLangModel;
use app\module\language\factory\LanguageFieldFactory;
use Yii;

/**
 * @property integer $id
 * @property string $name
 * @property integer $ordering
 */
class Category extends AbstractMultiLangModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'core_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ordering'], 'integer'],
            LanguageFieldFactory::process('name', ['string', 'max' => 255])
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '`model.name`',
            'ordering' => 'Ordering',
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
            'name'
        ];
    }
}
