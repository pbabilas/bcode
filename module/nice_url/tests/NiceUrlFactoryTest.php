<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 10.12.2015
 * Time: 19:05
 */

namespace app\module\nice_url\tests;


use app\module\nice_url\factory\NiceUrlFactory;
use app\module\nice_url\models\Collection;
use app\module\nice_url\models\NiceUrl;
use app\module\nice_url\tests\mock\NiceUrlObject;
use app\module\nice_url\tests\mock\SlugCounter;

class NiceUrlFactoryTest extends \PHPUnit_Framework_TestCase
{

	/** @var NiceUrlFactory */
	private $factory;

	public function setUp()
	{
		$this->factory = new NiceUrlFactory( new SlugCounter() );
	}

	public function testGenerateStandardNiceUrl()
	{
		$object = new NiceUrlObject();

		$collection = $this->factory->generate($object);

		$this->assertInstanceOf(get_class(new Collection()), $collection);

		/** @var NiceUrl $niceUrl */
		foreach($collection as $niceUrl)
		{
			$this->assertInstanceOf(get_class(new NiceUrl()), $niceUrl, $niceUrl->url);
		}
	}

}