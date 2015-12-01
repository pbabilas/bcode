<?php

namespace app\module\user\models;

use yii\base\Model;

/**
 * UserSearch represents the model behind the search form about User.
 */
class UserSearch extends Model
{
	public $id;
	public $name;
	public $password;
	public $authKey;
	public $email;

	public function rules()
	{
		return [
			[['name', 'password', 'authKey', 'email'], 'safe'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'name' => 'Name',
			'password' => 'Password',
			'authKey' => 'authKey',
			'email' => 'Email',
		];
	}


}
