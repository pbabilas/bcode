<?php

namespace app\module\user\models;

use app\common\model\AbstractModel;
use app\module\nice_url\interfaces\NiceUrlInterface;
use Yii;
use \yii\db\ActiveRecord;
use \yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $password
 * @property string $authKey
 * @property string $email
 * @property string $accessToken
 *
 */
class User extends AbstractModel implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'password', 'email'], 'required'],
            [['name', 'authKey', 'accessToken', 'email'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 255],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '`user.name`',
            'password' => '`user.password`',
            'email' => '`user.email`',
        ];
    }

	/**
	 * @param int|string $id
	 * @return array|null|ActiveRecord
	 */
    public static function findIdentity($id)
    {

        $user = User::find()
            ->where(['id' => $id])
            ->one();
        return $user;
    }

	/**
	 * @param $username
	 * @return array|null|ActiveRecord
	 */
    public static function findByUsername($username)
    {
        $user = User::find()
            ->where(['name' => $username])
            ->one();
        return $user;
    }

	/**
	 * @return int
	 */
    public function getId()
    {
        return $this->id;
    }

	/**
	 * @return string
	 */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function setAuthKey()
    {
        $this->authKey = Yii::$app->getSecurity()->generateRandomString(8);
    }

    public function setAccessToken()
    {
        $this->accessToken = Yii::$app->getSecurity()->generateRandomString(8);
    }

    /**
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return array|null|ActiveRecord|IdentityInterface
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = User::find()
            ->where(['accessToken' => $token])
            ->one();
        return $user;
    }
}
