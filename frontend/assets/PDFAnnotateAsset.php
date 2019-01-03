<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class PDFAnnotateAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'css/bootstrap.min.css',
        'css/font-awesome.min.css',
        'plugins/pdf-annotate/shared/toolbar.css',
        'plugins/pdf-annotate/shared/pdf_viewer.css',
        'plugins/pdf-annotate/shared/styles.css',
        'plugins/pdf-annotate/popup-toolbar.css',
    ];
    
    public $js = [
        'js/bootstrap.min.js',
        'js/init-tooltip.js',
        'plugins/pdf-annotate/shared/pdf.js',
        'plugins/pdf-annotate/shared/pdf_viewer.js',
        'plugins/jquery-fullscreen/jquery.fullscreen-min.js',
        'plugins/jquery-fullscreen/init.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
        'frontend\assets\AngularJSAsset'
    ];
}
