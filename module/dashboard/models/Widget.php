<?php

namespace app\module\dashboard\models;

use app\common\model\AbstractModel;
use app\module\dashboard\interfaces\WidgetInterface;
use Yii;

/**
 * This is the model class for table "dashboard_widget".
 *
 * @property integer $id
 * @property string $class_name
 * @property string $params
 */
class Widget extends AbstractModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dashboard_widget';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['params'], 'string'],
            [['class_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'class_name' => 'Class Name',
            'params' => 'Params',
        ];
    }

    /**
     * @return WidgetInterface
     */
    public function getObject()
    {
        if (is_null($this->params))
        {
            return new $this->class_name();
        }

        $params = json_decode($this->params);
        return new $this->class_name($params);
    }

}
