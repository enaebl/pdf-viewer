<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ContextMenuAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'plugins/context-menu/contextMenu.css',
    ];
    
    public $js = [
        'plugins/context-menu/contextMenuScript.js',
        'plugins/context-menu/init.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
