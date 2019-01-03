<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class FileUploadAssetNoScript extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $cssOptions = ['noscript' => true];
    
    public $css = [
        'plugins/jquery-file-upload/css/jquery.fileupload-noscript.css',
        'plugins/jquery-file-upload/css/jquery.fileupload-ui-noscript.css',
    ];
    
    public $js = [
    ];
    
    public $depends = [
        'frontend\assets\FileUploadAsset',
    ];

}
