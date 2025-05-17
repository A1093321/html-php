<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Josh_pdf_watermark extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->zi_init->header('be'); // 網頁 header
    return;
  }
  public function test_for_pic() {
    require_once('FPDI-master/src/autoload.php');
    require_once('FPDF-master/fpdf.php');
    require_once('tfpdf/tfpdf.php');

    $date_text = '更新於 '.date("Y-m-d H:i:s"); // .' at '.date("H:i:s")
    $target_pdf = "test01.pdf";
    $existing_pdf = new \setasign\Fpdi\Tfpdf\Fpdi();
    
    $watermark_text = "test_watermark";
    $width = strlen($watermark_text);
    $text_result = "";
    for ($i = 0; $i < 100 ; $i += $width) {
      $text_result .= " ".$watermark_text;
    }
    // var_dump($text_result);
    $pages = $existing_pdf->setSourceFile($target_pdf);
    for ($i = 1 ; $i <= $pages ; $i++) {
      $existing_pdf->AddPage();
      $existing_pdf->AddFont('msjh','','msjh.ttf',true);
      $existing_pdf->SetFont('msjh','',12);
      $existing_pdf->SetTextColor(180, 180, 180);
      $existing_pdf->Text(2, 4, $date_text);

      $existing_pdf->SetFont('Arial', 'B', 20);
      $existing_pdf->SetTextColor(230, 230, 230);
      for ($j = 70 ; $j <= 450 ; $j+=20) {
        $existing_pdf->RotatedText(0, $j, $text_result, 45); 
      }
      $tplIdx = $existing_pdf->importPage($i);
      $existing_pdf->useTemplate($tplIdx);
    }
    $existing_pdf->Output();
    // $existing_pdf->Output('final_document.pdf', 'D');
  }
}