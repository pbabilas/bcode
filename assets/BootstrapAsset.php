<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 29.11.15
 * Time: 16:10
 */

namespace app\assets;


use yii\web\AssetBundle;

class BootstrapAsset extends AssetBundle
{

	public $sourcePath = '@app/components/bootstrap/dist';
	public $css = [
		'css/bootstrap.css',
	];

	public $js = [
		'js/bootstrap.js'
	];

}