<?php
/* @var $this View */
/* @var $content string */

use frontend\assets\ContextMenuAsset;
use frontend\assets\PDFAnnotateAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

//AnnotoriousOKFNAsset::register($this);
PDFAnnotateAsset::register($this);
ContextMenuAsset::register($this);
$this->registerJsFile('https://code.responsivevoice.org/responsivevoice.js', ['depends' => 'frontend\assets\PDFAnnotateAsset']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="google" content="notranslate">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body ng-app="MyApp">
        <?php $this->beginBody() ?>
        <div class="new-toolbar">
            <div class="text-center">
                <a id="btn-open-file" href="" title="Open file"><?= Html::img('@web/img/pdf-toolbar/1x/Open.png') ?></a>
                <a id="btn-save" href="" title="Save"><?= Html::img('@web/img/pdf-toolbar/1x/Save.png') ?></a>
                <a id="btn-download-pdf" href="" title="Download file"><?= Html::img('@web/img/pdf-toolbar/1x/Download.png') ?></a>
                <a id="btn-share" href="" title="Share"><?= Html::img('@web/img/pdf-toolbar/1x/Share.png') ?></a>
                <a id="btn-print" href="javascript:window.print()" title="Print page"><?= Html::img('@web/img/pdf-toolbar/1x/Print.png') ?></a>
                <a id="btn-search" href="" title="Search"><?= Html::img('@web/img/pdf-toolbar/1x/Search.png') ?></a>
                <a id="btn-menu" href="" title="Menu"><?= Html::img('@web/img/pdf-toolbar/1x/Menu.png') ?></a>

                <form id="download-pdf-form" method="get" action="<?= Url::to ([/*'plugins/pdf-convert/index.php'*/'download']) ?>">
                    <input type="hidden" name="pdf_file" value="<?= Yii::$app->request->get('pdf_file') ?>" />
                </form>
            </div>
        </div>
        
        <div class="msg-div" style="display: none;"></div>

        <div class="toolbar hidden">
            <div class="text-center">
                <button class="cursor" type="button" title="Cursor" data-tooltype="cursor">➚</button>
                <div class="spacer"></div>
                <button class="rectangle" type="button" title="Rectangle" data-tooltype="area">&nbsp;</button>
                <div class="spacer"></div>
                <button class="text" type="button" title="Text Tool" data-tooltype="text"></button>
                <select class="text-size toolbar-select"></select>
                <div class="text-color"></div>
                <div class="spacer"></div>
                <button class="pen" type="button" title="Pen Tool" data-tooltype="draw">✎</button>
                <select class="pen-size toolbar-select"></select>
                <div class="pen-color"></div>
                <div class="spacer"></div>
                <a href="javascript://" class="rotate-ccw hidden" title="Rotate Counter Clockwise">⟲</a>
                <a href="javascript://" class="rotate-cw hidden" title="Rotate Clockwise">⟳</a>
                <a href="javascript://" class="clear" title="Clear annotations"><i class="fa fa-times-rectangle"></i></a>
            </div>
        </div>

        <div id="content-wrapper">
            <?= $content ?>
        </div>

        <div id="popup" class="annotate-toolbar-container" style="display: none;">
            <div class="annotate-toolbar">
                <div class="left-panel pull-left">
                    <div class="left-panel-row-1">
                        <div class="annotation-button-container"><a data-toggle="tooltip" data-placement="bottom" title="Blue" id="btn-blue" href=""><?= Html::img('@web/img/pdf-toolbar/1x/Colour 6.png') ?></a></div>
                        <div class="annotation-button-container"><a data-toggle="tooltip" data-placement="bottom" title="Magenta" id="btn-magenta" href=""><?= Html::img('@web/img/pdf-toolbar/1x/Colour 5.png') ?></a></div>
                        <div class="annotation-button-container"><a data-toggle="tooltip" data-placement="bottom" title="Violet" id="btn-violet" href=""><?= Html::img('@web/img/pdf-toolbar/1x/Colour 4.png') ?></a></div>
                        <div class="annotation-button-container"><a data-toggle="tooltip" data-placement="bottom" title="Gray" id="btn-gray" href=""><?= Html::img('@web/img/pdf-toolbar/1x/Colour 3.png') ?></a></div>
                    </div>
                    <div class="left-panel-row-2">
                        <div class="annotation-button-container"><a data-toggle="tooltip" data-placement="bottom" title="Brick" id="btn-brick" href=""><?= Html::img('@web/img/pdf-toolbar/1x/Colour 2.png') ?></a></div>
                        <div class="annotation-button-container"><a data-toggle="tooltip" data-placement="bottom" title="Mustard" id="btn-mustard" href=""><?= Html::img('@web/img/pdf-toolbar/1x/Colour 1.png') ?></a></div>
                        <div class="annotation-button-container"><a data-toggle="tooltip" data-placement="bottom" title="Yellow" id="btn-yellow" href=""><?= Html::img('@web/img/pdf-toolbar/1x/Colour 8.png') ?></a></div>
                        <div class="annotation-button-container"><a data-toggle="tooltip" data-placement="bottom" title="Green" id="btn-green" href=""><?= Html::img('@web/img/pdf-toolbar/1x/Colour 7.png') ?></a></div>
                    </div>
                    <div class="left-panel-row-3">
                        <div class="annotation-button-container">
                            <button class="highlight" type="button" data-toggle="tooltip" data-placement="bottom" title="Highlight" data-tooltype="highlight"></button>
                        </div>
                        <div class="annotation-button-container">
                            <button class="underline" type="button" data-toggle="tooltip" data-placement="bottom" title="Underline" data-tooltype="underline"></button>
                        </div>
                        <div class="annotation-button-container">
                            <button class="strikeout" type="button" data-toggle="tooltip" data-placement="bottom" title="Strikeout" data-tooltype="strikeout"></button>
                        </div>
                        <div class="annotation-button-container">
                            <button class="comment" type="button" data-toggle="tooltip" data-placement="bottom" title="Comment" data-tooltype="point"></button>
                        </div>
                    </div>
                </div>
                <div class="right-panel">
                    <div class="options-button" style="padding-top: 6px;"><a id="btn-dictionary" data-toggle="tooltip" data-placement="right" title="Dictionary" href=""><?= Html::img('@web/img/pdf-toolbar/1x/Dictionary.png') ?></a></div>
                    <div class="options-button"><a id="btn-wikipedia" data-toggle="tooltip" data-placement="right" title="Wikipedia" href=""><?= Html::img('@web/img/pdf-toolbar/1x/Wikipedia.png') ?></a></div>
                    <div class="options-button"><a id="btn-tts" data-toggle="tooltip" data-placement="right" title="Text to speech" href=""><?= Html::img('@web/img/pdf-toolbar/1x/Test to speech.png') ?></a></div>
                    <div class="options-button"><a data-toggle="tooltip" data-placement="right" title="Readable view" href=""><?= Html::img('@web/img/pdf-toolbar/1x/Pop readable view.png') ?></a></div>
                </div>
            </div>
        </div>

        <div id="comment-wrapper" class="hidden">
            <h4>Comments</h4>
            <div class="comment-list">
                <div class="comment-list-container">
                    <div class="comment-list-item">No comments</div>
                </div>
                <form class="comment-list-form" style="display:none;">
                    <input type="text" placeholder="Add a Comment"/>
                </form>
            </div>
        </div>

        <div id="right-toolbar-wrapper">
            <div id="right-toolbar-container" class="pull-right">
                <div class="right-toolbar-obj text-right">
                    <a id="full-screen" title="Enable fullscreen" href=""><?= Html::img('@web/img/pdf-toolbar/1x/Fullscreen.png') ?></a>
                    
                </div>
                <div class="right-toolbar-obj text-right">
                    <a id="fit-to-page" title="Fit to page" href=""><?= Html::img('@web/img/pdf-toolbar/1x/Fit to page.png') ?></a>
                    <a id="fit-to-width" title="Fit to width" href="" class="hidden"><?= Html::img('@web/img/pdf-toolbar/1x/Fit to width.png') ?></a>
                </div>
                <div class="right-toolbar-obj text-right">
                    <a id="zoom-in" title="Zoom in" href=""><?= Html::img('@web/img/pdf-toolbar/1x/Zoom in.png') ?></a>
                </div>
                <div class="right-toolbar-obj text-right">
                    <a id="zoom-out" title="Zoom out" href=""><?= Html::img('@web/img/pdf-toolbar/1x/Zoom out.png') ?></a>
                </div>
            </div>
        </div>
        
        <?php $this->endBody() ?>

        <!--<script type="text/javascript">
            $("#download-btn").click(function () {
                $.post("http://localhost:8080/pdf-app/viewer/frontend/web/pdf-viewer/generate",
                        {
                            head: $('head').html(),
                            content_wrapper: $('#content-wrapper').html()
                        },
                        function (data, status) {
                            alert("Data: " + data + "\nStatus: " + status);
                        });
            });
        </script>-->
    </body>
</html>
<?php $this->endPage() ?>
