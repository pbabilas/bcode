<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 29.11.15
 * Time: 16:10
 */

namespace app\assets;


use yii\web\AssetBundle;

class LTEAsset extends AssetBundle
{
	public $sourcePath = '@vendor/almasaeed2010/adminlte/dist';
	public $css = [
		'css/AdminLTE.min.css',
		'css/skins/skin-green.css',
	];
	public $js = [
		'js/app.js'
	];
}