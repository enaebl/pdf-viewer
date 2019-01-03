<?php

namespace frontend\controllers;

use frontend\models\Item;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;
use const YII_ENV_TEST;

/**
 * Site controller
 */
class PdfViewerController extends Controller {

    public $layout = 'pdf-viewer';

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view', 'get-file', 'generate', 'download'],
                'rules' => [
                        [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'generate' => ['get', 'post'],
                    'download' => ['get', 'post'],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    private function getUserPDFs($pdf_file) {
        $user_id = Yii::$app->user->identity->id;
        $models = Item::findAll(['user_id' => $user_id]);
        $file_dir = Yii::$app->getBasePath() . "/../items/$user_id";
        $res = [];
        foreach ($models as $model) {
            if ($model->generic_file_name !== $pdf_file) {
                $full_file_path = "$file_dir/$model->generic_file_name";
                if (file_exists($full_file_path)) {
                    $res[] = $model;
                }
            }
        }
        return $res;
    }

    public function actionView($pdf_file) {
        $item = Item::findOne(['generic_file_name' => $pdf_file]);
        if ($item) {
            if ($item->user_id == Yii::$app->user->identity->id) {
                $full_file_path = Yii::$app->getBasePath() . "/../items/$item->user_id/$pdf_file";
                if (file_exists($full_file_path)) {
                    $this->layout = 'annotate';
                    $id = Yii::$app->user->identity->id;
                    Yii::$app->session->set('id', $id);
                    $pdfs = $this->getUserPDFs($pdf_file);
                    return $this->render('view', ['pdf_file' => $pdf_file, 'id' => $id, 'pdfs' => $pdfs]);
                } else {
                    throw new NotFoundHttpException("The resource you are trying to reach doesn't exist in our server.");
                }
            } else {
                throw new UnauthorizedHttpException("You are not allowed to reach the requested resource.");
            }
        } else {
            throw new NotFoundHttpException("The resource you are trying to reach is not available.");
        }
    }

    public function actionGetFile($pdf_file) {
        $item = Item::findOne(['generic_file_name' => $pdf_file]);
        if ($item) {
            if ($item->user_id == Yii::$app->user->identity->id) {
                $full_file_path = Yii::$app->getBasePath() . "/../items/$item->user_id/$pdf_file";
                if (file_exists($full_file_path)) {
                    $stream = fopen($full_file_path, 'r');
                    return Yii::$app->response->sendStreamAsFile($stream, $item->original_file_name, ['mimeType' => 'application/pdf'])->send();
                } else {
                    throw new NotFoundHttpException("The resource you are trying to reach doesn't exist in our server.");
                }
            } else {
                throw new UnauthorizedHttpException("You are not allowed to reach the requested resource.");
            }
        } else {
            throw new NotFoundHttpException("The resource you are trying to reach is not available.");
        }
    }

    public function actionGenerate(/* $pdf_file */) {


        /* $pdf = new FPDI('P', 'mm', 'A4', true, 'UTF-8', false, true);

          $full_file_path = Yii::$app->getBasePath() . "/../items/2/3QaZevDpzEW5qJbB5QJZvTX32ttt3CFY.pdf";
          $pageCount = $pdf->setSourceFile($full_file_path);
          for ($i = 1; $i <= 1; $i++) {
          $tplIdx = $pdf->importPage($i, '/MediaBox');
          $pdf->AddPage();
          $pdf->useTemplate($tplIdx);
          }
          //$pdf->Output('example_036.pdf', 'D');
          $pdf->Output('example_036.pdf'); */

        /* $pdf = new TCPDF();
          $pdf->SetCreator(PDF_CREATOR);
          $pdf->SetAuthor('Nicola Asuni');
          $pdf->SetTitle('TCPDF Example 036');
          $pdf->SetSubject('TCPDF Tutorial');
          $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
          $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 036', PDF_HEADER_STRING);
          $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
          $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
          $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
          $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
          $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
          $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
          $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
          $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
          $pdf->SetFont('times', '', 16);
          $pdf->AddPage();
          $txt = 'Example of Text Annotation. Move your mouse over the yellow box or double click on it to display the annotation text.';
          $pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);
          $pdf->Annotation(83, 27, 10, 10, "Text annotation example\naccented letters test: àèéìòù", array('Subtype' => 'Text', 'Name' => 'Comment', 'T' => 'title example', 'Subj' => 'example', 'C' => array(255, 255, 0)));
          $pdf->Output('example_036.pdf', 'D'); */

        /*
          $base_path = Yii::$app->getBasePath();$head = Yii::$app->request->post()['head'];
          $content_wrapper = Yii::$app->request->post()['content_wrapper'];
          $content = file_get_contents('http://localhost:8080/pdf-app/viewer/frontend/web/pdf-viewer/download?pdf_file=49zPZ10UE3uJaUueNe9WLnsk40wYcjhY.pdf');
          return $content; */
    }

    public function actionDownload() {
        try {
            $pdf_file = Yii::$app->request->get('pdf_file');
            $user_id = Yii::$app->user->identity->id;
            $model = Item::findOne(['generic_file_name' => $pdf_file]);
            if (!$model) {
                throw new NotFoundHttpException("The resource you are trying to reach is not available.");
            }
            if ($model->user_id != $user_id) {
                throw new UnauthorizedHttpException("You are not allowed to reach the requested resource.");
            }
            $base_url = Url::base(true);
            $full_url = htmlspecialchars("$base_url/plugins/pdf-convert/index.php?pdf_file=$pdf_file&id=$user_id&base_url=$base_url");
            $res = file_get_contents($full_url);
            return Yii::$app->response->sendContentAsFile($res, $model->original_file_name, ['mimeType' => 'application/pdf']);
        } catch (\Exception $exc) {
            throw $exc;
        }
    }

}
