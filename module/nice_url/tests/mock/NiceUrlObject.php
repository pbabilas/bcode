<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 08.12.2015
 * Time: 20:08
 */

namespace app\module\nice_url\tests\mock;


use app\module\nice_url\interfaces\NiceUrlInterface;
use app\module\nice_url\models\NiceUrl;
use app\module\page\models\Page;

class NiceUrlObject extends NiceUrl
	implements NiceUrlInterface
{

	public $name__pl = 'Testowy obiekt 23 - asd';
	public $name__en = '';

	public $id = 1;

	/**
	 * @return string
	 */
	public function getFieldForNiceUrl()
	{
		return 'name';
	}

	/**
	 * @return string
	 */
	public function getNiceUrlModuleName()
	{
		return 'test';
	}

	/**
	 * @return string
	 */
	public function getNiceUrlModuleAction()
	{
		return 'show';
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * If multilang, return array like
	 *
	 *    [
	 *        field,
	 *        field,
	 *        ...,
	 *        field
	 *    ]
	 *
	 * @return array
	 */
	public function getMultiLangFields()
	{
		return [
			'name'
		];
	}

	/**
	 * @param string $field
	 * @param bool $identical
	 *
	 * @return bool
	 */
	public function isAttributeChanged($field, $identical = true)
	{
		if ($field == 'name__pl')
		{
			return true;
		}

		return false;
	}

	/**
	 * @return string
	 */
	public function getNiceUrlControllerId()
	{
		return 'test';
	}

	public function getObject()
	{
		return new Page();
	}

}