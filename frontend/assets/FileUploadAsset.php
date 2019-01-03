<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class FileUploadAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        //'css/bootstrap.min.css',
        'plugins/jquery-file-upload/css/blueimp-gallery.min.css',
        'plugins/jquery-file-upload/css/jquery.fileupload.css',
        'plugins/jquery-file-upload/css/jquery.fileupload-ui.css',
        'plugins/jquery-file-upload/css/dropzone.css',
    ];
    
    public $js = [
        'plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js',
        'plugins/jquery-file-upload/js/tmpl.min.js',
        'plugins/jquery-file-upload/js/load-image.all.min.js',
        'plugins/jquery-file-upload/js/canvas-to-blob.min.js',
        'plugins/jquery-file-upload/js/jquery.blueimp-gallery.min.js',
        'plugins/jquery-file-upload/js/jquery.iframe-transport.js',
        'plugins/jquery-file-upload/js/jquery.fileupload.js',
        'plugins/jquery-file-upload/js/jquery.fileupload-process.js',
        'plugins/jquery-file-upload/js/jquery.fileupload-image.js',
        'plugins/jquery-file-upload/js/jquery.fileupload-audio.js',
        'plugins/jquery-file-upload/js/jquery.fileupload-video.js',
        'plugins/jquery-file-upload/js/jquery.fileupload-validate.js',
        'plugins/jquery-file-upload/js/jquery.fileupload-ui.js',
        'plugins/jquery-file-upload/js/dropzone-transition.js',
    ];
    
    public $depends = [
        'frontend\assets\AppAsset',
    ];

}
