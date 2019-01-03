<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AnimateAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'plugins/animate/css/animate.css',
    ];
    
    public $js = [
        'plugins/animate/js/init.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
