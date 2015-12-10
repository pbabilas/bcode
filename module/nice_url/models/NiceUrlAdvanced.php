<?php

namespace app\module\nice_url\models;

use Yii;

/**
 * This is the model class for table "nice_url_advanced".
 *
 * @property integer $id
 * @property string $nice_url
 * @property string $oryginal_url
 */
class NiceUrlAdvanced extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nice_url_advanced';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nice_url', 'oryginal_url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nice_url' => 'Nice Url',
            'oryginal_url' => 'Oryginal Url',
        ];
    }
}
