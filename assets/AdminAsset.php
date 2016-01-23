<?php
/**
 * @user: Paweł Babilas
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Paweł Babilas <babilas.pawel@gmail.com>
 * @since 2.0
 */
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'awsome/css/font-awesome.min.css',
        'css/admin.css',
    ];
    public $js = [
		'js/file-input.js',
        'js/admin.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',
        'app\assets\BootstrapAsset',
        'app\assets\LTEAsset',
        'app\assets\WysiwygAsset',
        'app\assets\IoniconsAsset'
    ];
}
