<?php

namespace app\module\nice_url\models;

use Yii;

/**
 * This is the model class for table "nice_url".
 *
 * @property integer $id
 * @property string $object_type
 * @property integer $object_id
 * @property string $slug
 * @property string $url
 * @property string $lang
 */
class NiceUrl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nice_url';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_id'], 'required'],
            [['object_id'], 'integer'],
            [['object_type'], 'string', 'max' => 100],
            [['slug', 'url'], 'string', 'max' => 255],
            [['lang'], 'string', 'max' => 4],
            [['url'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'object_type' => 'Object Type',
            'object_id' => 'Object ID',
            'slug' => 'Slug',
            'url' => 'Url',
            'lang' => 'Lang',
        ];
    }

    /**
     * @inheritdoc
     * @return NiceUrlQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NiceUrlQuery(get_called_class());
    }
}
