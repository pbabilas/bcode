<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 07.12.2015
 * Time: 17:14
 */

namespace app\module\user\security;

use app\module\user\models\User;
use Yii;

class Auth
{
	/** @var User  */
	private $user;

	/**
	 * @param User $userCandidate
	 *
	 * @return bool
	 *
	 * @throws \yii\base\InvalidConfigException
	 */
	public function login(User $userCandidate)
	{
		/** @var User $user */
		$user = User::find()
			->where(['name' => $userCandidate->name])
			->one();

		if (is_null($user))
		{
			return false;
		}

		if (\Yii::$app->getSecurity()->validatePassword($userCandidate->password, $user->password))
		{
			\Yii::$app->user->login($user, 3600);
			return true;
		}

		return false;
	}

	/**
	 * @return bool
	 */
	public function logout()
	{
		return \Yii::$app->user->logout();
	}

	/**
	 * @return bool
	 */
	public function check()
	{
		return !\Yii::$app->user->isGuest;
	}
}