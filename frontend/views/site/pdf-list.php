<?php
/* @var $this View */

use yii\helpers\Url;
use yii\web\View;
?>

<div id="uploaded-pdfs" class="col-lg-12">
    <div class="line"></div>
    <div class="file-content" ng-show="files_list.length === 0">
        No uploaded files were found.
    </div>
    <div class="file-content" ng-cloak ng-repeat="file in files_list">
        <a title="View file" ng-cloak href="<?= Url::to(['/pdf-viewer/view?pdf_file=']) ?>{{file.generic_file_name}}"><h4>{{file.generic_file_name}}</h4></a>
        <p ng-cloak>Title: {{file.original_file_name}}</p>
    </div>
    <div class="line"></div>
</div>
