<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 29.11.15
 * Time: 16:10
 */

namespace app\assets;


use yii\web\AssetBundle;

class WysiwygAsset extends AssetBundle
{
	public $sourcePath = '@app/components/bootstrap3-wysihtml5-bower/dist';
	public $css = [
		'bootstrap3-wysihtml5.css',
	];
	public $js = [
		'bootstrap3-wysihtml5.all.js'
	];
}