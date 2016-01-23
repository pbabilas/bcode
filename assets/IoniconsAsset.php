<?php
/**
 * @user: Pawel Babilas
 * @date: 19.01.2016
 */

namespace app\assets;


use yii\web\AssetBundle;

class IoniconsAsset extends AssetBundle
{
	public $sourcePath = '@bower/ionicons';
	public $css = [
		'css/ionicons.css',
	];
}