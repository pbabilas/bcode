<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 06.12.2015
 * Time: 14:27
 */

namespace app\module\nice_url\interfaces;


interface NiceUrlInterface
{

	/**
	 * @return string
	 */
	public function getFieldForNiceUrl();

	/**
	 * @return string
	 */
	public function getNiceUrlModuleName();

	/**
	 * @return string
	 */
	public function getNiceUrlModuleAction();

	/**
	 * @return integer
	 */
	public function getId();
}