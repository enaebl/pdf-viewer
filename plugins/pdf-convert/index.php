<?php

require_once('tcpdf/tcpdf.php');
require_once('fpdi/fpdi.php');

function annotationsByPage($json, $page) {
    $res = [];
    foreach ($json as $value) {
        if ($value->class == 'Annotation' && $value->page == $page) {
            $res[] = [$value, commentByAnnotation($json, $value->uuid)];
        }
    }
    return $res;
}

function commentByAnnotation($json, $uuid) {
    $res = null;
    foreach ($json as $value) {
        if ($value->class == 'Comment' && $value->annotation == $uuid) {
            $res = $value;
            if (!isset($value->content)) {
                $value->content = '';
            }
            break;
        }
    }
    if (!$res) {
        $res = new stdClass();
        $res->content = '';
    }
    return $res;
}

function decodeRealColor($color) {
    $res = '';
    switch ($color) {
        case '308ffd':
            $res = '92c1f7';
            break;
        case 'da39fc':
            $res = 'eda0fd';
            break;
        case '5834fe':
            $res = 'a794ff';
            break;
        case '616060':
            $res = 'aeaeae';
            break;
        case 'fe2c2c':
            $res = 'fb8e8e';
            break;
        case 'fc9e04':
            $res = 'fec567';
            break;
        case 'fdec1d':
            $res = 'fff793';
            break;
        case '80e618':
            $res = 'b8e986';
            break;
        default:
            $res = $color;
            break;
    }
    return $res;
}

function hexToRgb($hex, $alpha = false) {
    $hex = str_replace('#', '', $hex);
    $length = strlen($hex);
    $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
    $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
    $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
    if ($alpha) {
        $rgb['a'] = $alpha;
    }
    return $rgb;
}

function adjustBrightness($hex, $steps) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Normalize into a six character long hex string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
    }

    // Split into three parts: R, G and B
    $color_parts = str_split($hex, 2);
    $return = '#';

    foreach ($color_parts as $color) {
        $color = hexdec($color); // Convert to decimal
        $color = max(0, min(255, $color + $steps)); // Adjust color
        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
    }

    return $return;
}

$pdf = new FPDI('', 'pt', 'A4', true, 'UTF-8', false, false);

try {
    $file_name = $_GET['pdf_file'];
    $id = $_GET['id'];
    $base_url = $_GET['base_url'];
    $annotations_url = $base_url . "/api/annotations?document_id=$file_name";
    $annotations = file_get_contents($annotations_url);
    $json = NULL;
    if ($annotations) {
        $json = json_decode(json_decode($annotations));
    }
    $pageCount = $pdf->setSourceFile("../../items/$id/$file_name");
    for ($i = 1; $i <= $pageCount; $i++) {
        $tplIdx = $pdf->importPage($i, '/MediaBox');
        $pdf->AddPage();
        if ($json) {
            $page_annotations = annotationsByPage($json, $i);
            foreach ($page_annotations as $annotation) {
                $curr_annotation = $annotation[0];
                if ($curr_annotation->type == 'point') {
                    if ($annotation[1]->class == 'Comment') {
                        $pdf->Annotation($curr_annotation->x, $curr_annotation->y, 100, 70, $annotation[1]->content, ['Subtype' => 'Text', 'Name' => 'Comment', 'C' => array(255, 255, 0)]);
                    }
                } else {
                    $rectangles = $curr_annotation->rectangles;
                    foreach ($rectangles as $rect) {
                        $x = round($rect->x);
                        $y = round($rect->y);
                        $width = round($rect->width);
                        $height = round($rect->height);
                        $pdf->SetX($x, true);
                        $pdf->SetY($y, false, true);
                        if ($curr_annotation->type == 'highlight') {
                            $pdf->SetFillColorArray(hexToRgb(decodeRealColor($curr_annotation->color)));
                            $pdf->Cell($width, $height, '', 0, 0, 'R', true, null, 0, false, 'T', 'T');
                        }
                        else if ($curr_annotation->type == 'strikeout') {
                            $pdf->Cell($width, $height, '', ['T' => ['width' => 1, 'color' => hexToRgb($curr_annotation->color)]], 0, 'R', false);
                        }
                    }
                }
            }
        }
        $pdf->useTemplate($tplIdx);
    }
    $pdf->Output($file_name, 'D');
} catch (Exception $exc) {
    $pdf->AddPage();
    $pdf->Text(200, 200, $exc->getMessage());
    $pdf->Output('Exception', 'D');
}
