<?php

namespace app\module\calendar\models;

/**
 * This is the ActiveQuery class for [[Calendar]].
 *
 * @see Calendar
 */
class CalendarQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Calendar[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Calendar|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}