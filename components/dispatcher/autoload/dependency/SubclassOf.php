<?php
/**
 * @user: Pawel Babilas
 * @date: 13.01.2016
 */

namespace app\components\dispatcher\autoload\dependency;

use app\components\dispatcher\interfaces\DependencyInterface;
use ReflectionClass;

class SubclassOf implements DependencyInterface
{

	/** @var ReflectionClass  */
	private $reflectionClass;
	private $subclass;

	public function __construct($subclass)
	{
		$this->subclass = $subclass;
	}

	public function setClassName($className)
	{
		$this->reflectionClass = new ReflectionClass($className);
	}

	/**
	 * @return bool
	 */
	public function isMet()
	{
		return $this->reflectionClass->isSubclassOf($this->subclass);
	}
}