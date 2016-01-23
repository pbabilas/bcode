<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 07.12.2015
 * Time: 17:39
 */

namespace app\module\user\tests;


use app\module\user\models\User;
use app\module\user\security\Auth;
use PHPUnit_Framework_TestCase;

class AuthTest extends PHPUnit_Framework_TestCase
{

	private $name = 'pbabilas';

	private $password = 'pawel123';

	public function testLoginSuccess()
	{
		$auth = new Auth();

		$user = new User();
		$user->name = $this->name;
		$user->password = $this->password;

		$result = $auth->login($user);

		$this->assertTrue($result);
	}

	public function testLoginFailed()
	{
		$auth = new Auth();

		$user = new User();
		$user->name = $this->name;
		$user->password = 'sss';

		$result = $auth->login($user);

		$this->assertFalse($result);
	}

	public function testUserNotFound()
	{
		$auth = new Auth();

		$user = new User();
		$user->name = 'beleco';
		$user->password = 'sss';

		$result = $auth->login($user);

		$this->assertFalse($result);
	}

	public function testLogout()
	{
		$auth = new Auth();
		$result = $auth->logout();

		$this->assertTrue($result);
	}

	public function testCheck()
	{
		$auth = new Auth();

		$user = new User();
		$user->name = $this->name;
		$user->password = $this->password;

		$auth->login($user);

		$result = $auth->check();

		$this->assertTrue($result);
	}

}