<?php

namespace app\components\dispatcher\interfaces;

/**
 * @user: Pawel Babilas
 * @date: 13.01.2016
 */
interface DependencyInterface
{

	/**
	 * @return bool
	 */
	public function isMet();

	public function setClassName($className);
}