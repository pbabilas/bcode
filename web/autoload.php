<?php


use app\components\dispatcher\autoload\dependency\SubclassOf;
use app\components\dispatcher\autoload\Generator;

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

defined('YII_TEST_ENTRY_URL') or define('YII_TEST_ENTRY_URL', 'index-test.php');
defined('YII_TEST_ENTRY_FILE') or define('YII_TEST_ENTRY_FILE', dirname(dirname(__DIR__)) . '/web/index-test.php');

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$_SERVER['SCRIPT_FILENAME'] = YII_TEST_ENTRY_FILE;
$_SERVER['SCRIPT_NAME'] = YII_TEST_ENTRY_URL;
$_SERVER['SERVER_NAME'] = 'bcode.lh';
$_SERVER['SERVER_PORT'] =  '80';

Yii::setAlias('@app', dirname(__DIR__));

$config = require(__DIR__ . '/../config/console.php');
(new yii\web\Application($config));



//need to make autoloader with index components load aliases, ar, or else. Then find all files in root, go after every file, getconstants from file, find namespace and save classmap to file
error_reporting(E_ALL);
ini_set('memory_limit', '512M');

echo '<pre>';
doComposerUpdate();
doSubscriberClassMapUpdate();
echo '</pre>';


function doComposerUpdate()
{
	echo "<h3>Composer</h3>";
	echo "Running composer install \n";
	flush();
	ob_start();
	$output = array();
	echo exec("cd ./..; php composer.phar install 2>&1", $output);

	if(count($output) == 0)
	{
		echo '<h1 style="background: #ff0000; color: yellow">Error occurred on composer install! Probably permissions issue.</h1>';
	}
	else
	{
		echo '<ul>';
		foreach ($output as $outLine)
		{
			echo '<li>'.$outLine.'</li>';
		}
		echo '</ul>';
	}

	echo "\n";
	echo "Done \n";
	flush();
}

function doSubscriberClassMapUpdate()
{
	echo '<h3>Subscriber ClassMap generator running</h3>';
	$generator = new Generator()
	$generator->setDependency(new SubclassOf('app\common\interfaces\SubscriberInterface'));
	$generator->run(\Yii::$app->getBasePath().'/module');
	if ($generator->saveTo(\Yii::$app->getBasePath().'/runtime/class_map.php'))
	{
		echo 'ClassMap done';
	}
	else
	{
		echo 'ClassMap fault';
	}
}