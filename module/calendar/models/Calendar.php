<?php

namespace app\module\calendar\models;

use Yii;

/**
 * This is the model class for table "calendar".
 *
 * @property integer $ID
 * @property string $title
 * @property string $start
 * @property string $end
 * @property integer $all_day
 */
class Calendar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start', 'end'], 'required'],
            [['start', 'end'], 'safe'],
            [['all_day'], 'integer'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'title' => 'Title',
            'start' => 'Start',
            'end' => 'End',
            'all_day' => 'All Day',
        ];
    }

    /**
     * @inheritdoc
     * @return CalendarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CalendarQuery(get_called_class());
    }
}
