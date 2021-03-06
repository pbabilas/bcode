<?php

namespace app\module\user\models;

use app\common\model\AbstractModel;
use app\module\thumbnailer\Constants;
use app\module\thumbnailer\interfaces\HasPictureInterface;
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
 * @property string $picture_filename
 * @property string $first_name
 * @property string $surname
 * @property string $phone_number
 *
 */
class User extends AbstractModel implements IdentityInterface, HasPictureInterface
{

    const PICTURE_DIR = 'user/';

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
            [['name', 'authKey', 'accessToken', 'email'], 'string', 'max' => 100],
            [['password', 'picture_filename'], 'string', 'max' => 255],
            [['first_name', 'surname'], 'string', 'max' => 64],
            [['phone_number'], 'string', 'max' => 32],
            [['name'], 'unique'],
            [['picture_filename'], 'unique']
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
            'first_name' => '`user.first_name`',
            'surname' => '`user.surname`',
            'phone_number' => '`user.phone_number`',
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

    /**
     * @param string $filename
     * @param string $size
     *
     * @return string
     */
    public function getPicturePath($filename, $size = 'full_size')
    {
        return sprintf(
            '%s/web%s%s%s/%s',
            \Yii::$app->getBasePath(),
            Constants::PICTURES_PATH,
            User::PICTURE_DIR,
            $size,
            $filename
        );
    }

    /**
     * @param string $filename
     * @param string $size
     *
     * @return string
     */
    public function getPictureUrl($filename, $size = 'full_size')
    {
        return sprintf(
            '%s%s%s/%s',
            'pictures/',
            User::PICTURE_DIR,
            $size,
            $filename
        );
    }
}
