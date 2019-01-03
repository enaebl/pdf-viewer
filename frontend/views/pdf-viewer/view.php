<?php
/* @var $this View */
/* @var $form ActiveForm */
/* @var $model SignupForm */

use frontend\models\SignupForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\web\View;

$this->registerJSFile('@web/plugins/angularjs/controladores/PDFAnnotateController.js', ['depends' => 'frontend\assets\PDFAnnotateAsset']);
$this->title = 'View PDF';
?>
<div ng-controller="PDFAnnotateController" ng-init="init('<?= Url::base(true) ?>', '<?= $pdf_file ?>', '<?= $id ?>')">

    <div id="viewer" class="pdfViewer"></div>

    <div style="display: none;" id="modal-open-file" class="modal fade" aria-labelledby="gridModalLabel" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Uploaded Documents</h4>
                </div>
                <div class="modal-body">
                    <div class="my-pdfs" style="margin-left: 10px;">
                        <?php
                        $docs_count = 0;
                        if (count($pdfs) > 0) {
                            foreach ($pdfs as $pdf) {
                                $docs_count++;
                                echo '<i class="fa fa-file-pdf-o"></i> <a data-toggle="tooltip" data-placement="right" title="' . $pdf->generic_file_name . '" href="' . Url::to(['view', 'pdf_file' => $pdf->generic_file_name]). '">' . $pdf->original_file_name . '</a></br>';
                            }
                        } else {
                            echo '<i class="fa fa-info-circle"></i> No additional documents have been uploaded.';
                        }
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                </div>
            </div>
        </div>
    </div>

</div>
