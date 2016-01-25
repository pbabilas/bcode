<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 09.12.2015
 * Time: 17:51
 */

namespace app\module\nice_url\tests\generators;


use app\module\nice_url\generators\SlugGenerator;

class SlugGeneratorTest extends \PHPUnit_Framework_TestCase
{

	/** @var SlugGenerator */
	private $slugGenerator;

	private $stringForSlugGeneratorArray = [
		'Nazwa testowa',
		'nazwa-testowa',
		'nazwa_testowa 123',
		'nazwa raz dwa-! %^&'
	];

	public function setUp()
	{
		$this->slugGenerator = new SlugGenerator();
	}

	public function testGenerateFrom()
	{
		foreach($this->stringForSlugGeneratorArray as $string)
		{
			$slug = $this->slugGenerator->generateFrom($string);

			$result = (bool) preg_match('/^[a-zA-Z0-9_]+$/', $slug);

			$this->assertTrue($result);
		}
	}

}