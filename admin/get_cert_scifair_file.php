<?php
session_start();
include_once('../condb.php');
include_once('admin_check.php');
$upOne = realpath(__DIR__ . '/..');
require($upOne . '/pccstcer/fpdf.php');
define('FPDF_FONTPATH', 'font/');
require_once __DIR__ . '/vendor/autoload.php';
ini_set('memory_limit', '1024M');
ini_set('max_execution_time', 3600);
if ($_FILES['myFile']['name'] == "") {
  header("location:cert_maker.php?act=empty_file");
  exit();
}
$uploaddir = __DIR__ . "/files/";
$uploadfile = $uploaddir . basename($_FILES['myFile']['name']);
$uploadfilepath = $_FILES['myFile']['tmp_name'];
$objPHPExcel = PHPExcel_IOFactory::load($uploadfilepath);
$sheetData = $objPHPExcel->getSheet(0)->toArray(null, true, true, true);
genCert($sheetData, $dir_temp);

function genCert($data_array, $dir_temp)
{
  $temp_arr = array();
  for ($i = 1; $i <= count($data_array); $i++) {
    $pdf = new FPDF();
    $pdf->AddFont('TH Charm of AU', '', 'TH Charm of AU.php');
    $pdf->AddPage('L');
    $charset = "cp874//IGNORE";
    $pdf->Image('cert_scifair_student.png', 0, 0, 299, 205);
    $str = "has been awarded a " . $data_array[$i]["B"] . " medal certificate in " . $data_array[$i]["C"];
    $pdf->SetFont('TH Charm of AU', '', 26);
    $pdf->setXY(15, 90);
    $pdf->Cell(0, 0, iconv('UTF-8', $charset, $data_array[$i]["A"]), 0, 1, "C");
    $pdf->SetFont('TH Charm of AU', '', 21);
    $pdf->setXY(15, 91);
    $pdf->Cell(0, 0, iconv('UTF-8', $charset, $str), 0, 1, "C");
    $filename = "temp_" . date("Ymdhis") . "_" . str_pad(strval($i), 4, "0", STR_PAD_LEFT);
    $filename_temp = $filename;
    $same = 9999;
    while (file_exists($dir_temp . "/" . $filename . ".pdf")) {
      $filename = $filename_temp . "_" . str_pad(strval($same--), 4, "0", STR_PAD_LEFT);
    }
    $filename .= ".pdf";
    $pdf->Output($dir_temp . $filename, "F");
    array_push($temp_arr, $filename);
  }
  archiver_download($temp_arr, date("Ymdhis"), $dir_temp);
  foreach ($temp_arr as $files) {
    unlink($dir_temp . $files);
  }
}

function archiver_download($file_names, $archive_file_name, $file_path)
{ //sending download
  $zip = new ZipArchive();
  $countfile = 1;
  $filename = $archive_file_name;
  $archive_file_name = $filename . str_pad(strval($countfile++), 4, "0", STR_PAD_LEFT) . ".zip";
  while ($zip->open($file_path . $archive_file_name, ZIPARCHIVE::CREATE) !== TRUE) {
    $archive_file_name = $filename . str_pad(strval($countfile++), 4, "0", STR_PAD_LEFT) . ".zip";
  }
  foreach ($file_names as $files) {
    $zip->addFile($file_path . $files, $files);
  }
  $zip->close();
  header("Content-type: application/zip");
  header("Content-Disposition: attachment; filename=$archive_file_name");
  header("Content-length: " . filesize($file_path . $archive_file_name));
  header("Pragma: no-cache");
  header("Expires: 0");
  ob_clean();
  flush();
  readfile($file_path . $archive_file_name);
  unlink($file_path . $archive_file_name);
}
