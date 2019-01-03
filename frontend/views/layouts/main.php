<?php
/* @var $this View */
/* @var $content string */

use frontend\assets\AngularJSAsset;
use frontend\assets\AnimateAsset;
use frontend\assets\AppAsset;
use frontend\assets\FileUploadAsset;
use frontend\assets\FileUploadAssetNoScript;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$this->title = 'PDFViewer';

AppAsset::register($this);
AnimateAsset::register($this);
FileUploadAsset::register($this);
FileUploadAssetNoScript::register($this);
AngularJSAsset::register($this);
$this->registerJsFile('@web/plugins/angularjs/controladores/IndexController.js', ['depends' => 'frontend\assets\AngularJSAsset']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body ng-app="MyApp">
        <?php $this->beginBody() ?>

        <div class="wrap" ng-controller="IndexController" ng-init="init('<?= Url::base(true) ?>', '<?= $this->context->auth_info ?>', '<?= Yii::$app->session->get('exception') ?>')">

            <nav id="w0" class="navbar-fixed-top navbar"></nav>

            <nav class="menu-derecho"></nav>

            <div class="container-fluid" id="page-container">
                <?= $content ?>
                <div id="auto-hide-message" ng-cloak ng-show="auto_hide_message" class="label label-info">
                    <i class="fa fa-refresh fa-spin"></i> {{auto_hide_message}}
                </div>

                <div id="div-contenedor-gral" class="row">
                </div>
            </div>

            <div style="display: none;" id="upload-files" class="modal fade" aria-labelledby="gridModalLabel" data-backdrop="static">

            </div>
        </div>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
