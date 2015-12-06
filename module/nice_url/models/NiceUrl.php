<?php

namespace app\module\nice_url\models;

use app\module\language\models\Language;
use app\module\nice_url\exceptions\ObjectDoesNotExistsException;
use app\module\nice_url\interfaces\NiceUrlInterface;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "nice_url".
 *
 * @property integer $id
 * @property string $object_class
 * @property integer $object_id
 * @property string $slug
 * @property string $url
 * @property integer $language_id
 *
 * @property Language $language
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
            [['object_id', 'language_id'], 'required'],
            [['object_id', 'language_id'], 'integer'],
            [['object_type', 'slug', 'url'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * @inheritdoc
     * @return NiceUrlQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NiceUrlQuery(get_called_class());
    }

	/**
	 * @return NiceUrlInterface
	 *
	 * @throws ObjectDoesNotExistsException
	 */
    public function getObject()
    {
        $class = $this->object_class;

        if (file_exists($class) === false)
        {
            throw new ObjectDoesNotExistsException();
        }

		/** @var NiceUrlInterface $object */
		$object = $class::findOne($this->object_id);

		if (is_null($object))
		{
			throw new ObjectDoesNotExistsException;
		}

		return $object;
    }
}
