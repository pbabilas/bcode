<?php


error_reporting(E_ALL);
ini_set('memory_limit', '512M');

echo '<pre>';
doComposerUpdate();
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
