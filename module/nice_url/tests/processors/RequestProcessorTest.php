<?php
/**
 * @user: Pawel Babilas
 * @date: 25.01.2016
 */

namespace app\module\nice_url\tests\processors;


use app\module\language\models\Language;
use app\module\nice_url\processors\RequestProcessor;
use app\module\nice_url\tests\mock\Finder;
use app\module\nice_url\tests\mock\FinderAdvanced;
use app\module\nice_url\tests\mock\FinderNoObject;
use PHPUnit_Framework_TestCase;
use Yii;

class RequestProcessorTest extends PHPUnit_Framework_TestCase
{

	public function setUp()
	{
		Yii::$app->getRequest()->setPathInfo('page/index');
	}

	public function testNoNiceUrlFound()
	{
		$processor = new RequestProcessor(new Language(), new FinderNoObject());
		$result = $processor->processRequest(Yii::$app->getRequest());

		$isArray = is_array($result);

		$this->assertTrue($isArray);
		$this->assertEquals('page/index', $result[0]);
	}

	public function testNiceUrlFound()
	{
		$processor = new RequestProcessor(new Language(), new Finder());
		$result = $processor->processRequest(Yii::$app->getRequest());

		$isArray = is_array($result);

		$this->assertTrue($isArray);
		$this->assertEquals('page/page/show', $result[0]);
	}

	public function testNiceUrlAdvanced()
	{
		$processor = new RequestProcessor(new Language(), new FinderAdvanced());
		$result = $processor->processRequest(Yii::$app->getRequest());

		$isArray = is_array($result);

		$this->assertTrue($isArray);
		$this->assertEquals('page/page/show', $result[0]);
	}
}
