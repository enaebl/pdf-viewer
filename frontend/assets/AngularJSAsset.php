<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AngularJSAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
    ];
    
    public $js = [
        'plugins/angularjs/lib/angular.min.js',
        'plugins/angularjs/lib/angular-route.min.js',
        'plugins/angularjs/lib/angular-resource.min.js',
        'plugins/angularjs/lib/angular-sanitize.min.js',
        'plugins/angularjs/lib/angular-location-update.min.js',
        'plugins/angularjs/app.js',
    ];
    
    public $depends = [
        /*'frontend\assets\AppAsset',
        'frontend\assets\AnimateAsset',*/
    ];
}
