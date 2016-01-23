<?php
/**
 * @user: Pawel Babilas
 * @date: 16.01.2016
 */

namespace app\module\user\models;


use ReflectionClass;
use yii\rbac\Permission;
use yii\rbac\Role;

class Group extends Role
{

	/**
	 * @var Permission[]
	 */
	private $permissions = [];

	/** @var array */
	private $errors = [];

	/**
	 * @param array $data
	 * @param string $formName
	 *
	 * @return bool
	 */
	public function load($data, $formName = null)
	{
		$scope = $formName === null ? $this->formName() : $formName;
		if ($scope === '' && !empty($data)) {
			$this->setAttributes($data);
			$this->setPermissions($data);
			return true;
		} elseif (isset($data[$scope])) {
			$this->setAttributes($data[$scope]);
			$this->setPermissions($data);
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @param array $data
	 *
	 */
	private function setPermissions($data)
	{
		if (isset($data['Permission']) == false)
		{
			return;
		}

		$permissions = [];
		$auth = \Yii::$app->getAuthManager();

		foreach($data['Permission'] as $permissionName)
		{
			$permission = $auth->getPermission($permissionName);

			if (is_null($permission))
			{
				$permissions[] = $auth->createPermission($permissionName);
			}
			else
			{
				$permissions[] = $permission;
			}
		}

		$this->permissions = $permissions;

	}

	/**
	 * @return string
	 */
	public function formName()
	{
		$reflector = new ReflectionClass($this);

		return $reflector->getShortName();
	}

	/**
	 * @param array $values
	 */
	public function setAttributes($values)
	{
		if (is_array($values))
		{
			foreach ($values as $name => $value)
			{
				$this->$name = $value;
			}
		}
	}

	/**
	 * @return \yii\rbac\Role[]
	 */
	public static function findAll()
	{
		return \Yii::$app->getAuthManager()->getRoles();
	}

	/**
	 * @param $name
	 *
	 * @return null|Group
	 */
	public static function findOne($name)
	{
		$auth = \Yii::$app->getAuthManager();
		$role = $auth->getRole($name);
		if (is_null($role) == false)
		{
			$group = new Group();
			$group->setRole($role);

			$group->permissions = $auth->getPermissionsByRole($group->name);

			return $group;
		}

		return null;
	}

	/**
	 * return void
	 */
	public function save()
	{
		try
		{
			$auth = \Yii::$app->getAuthManager();

			if (is_null($auth->getRole($this->name)))
			{
				$auth->add($this);
			}
			else
			{
				$auth->update($this->name, $this);
			}

			$auth->removeChildren($this);

			foreach($this->permissions as $permission)
			{
				if (is_null($auth->getPermission($permission->name)))
				{
					$auth->add($permission);
				}

				if ($auth->hasChild($this, $permission) == false)
				{
					$auth->addChild($this, $permission);
				}
			}
		}
		catch (\Exception $e)
		{
			$this->errors[] = $e->getMessage();
			return false;
		}

		return true;
	}

	/**
	 * @return array
	 */
	public function getErrors()
	{
		return $this->errors;
	}

	/**
	 * @param Role $role
	 */
	private function setRole(Role $role)
	{
		$reflectionClass = new ReflectionClass($role);

		$properties = $reflectionClass->getDefaultProperties();

		foreach ($properties as $property => $value)
		{
			$this->$property = $role->$property;
		}
	}

	/**
	 * @return \yii\rbac\Permission[]
	 */
	public function getPermissions()
	{
		return $this->permissions;
	}

	/**
	 * @return bool
	 */
	public function delete()
	{
		return \Yii::$app->getAuthManager()->remove($this);
	}
}