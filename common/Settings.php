<?php
/**
 * @user: Pawel Babilas
 * @date: 05.01.2016
 */

namespace app\common;


class Settings
{
	/** @var Settings */
	private static $instance = null;
	/** @var bool  */
	private $isAdmin = false;

	/**
	 * @return Settings
	 */
	public static function getInstance()
	{
		if ( is_null( self::$instance ))
		{
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * @return bool
	 */
	public function isAdmin()
	{
		return $this->isAdmin;
	}

	public function setAdminMode()
	{
		$this->isAdmin = true;
	}

	public function disableAdminMode()
	{
		$this->isAdmin = false;
	}

}