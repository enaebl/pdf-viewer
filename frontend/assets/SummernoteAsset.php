<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class SummernoteAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'plugins/summernote/dist/summernote.css',
    ];
    
    public $js = [
        'plugins/summernote/dist/summernote.min.js',
        'plugins/summernote/js/init.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
