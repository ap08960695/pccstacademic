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
if ($_GET['type'] == 'student') {
    $sql = "SELECT * FROM register_scifair WHERE running_year = '$running_year' AND type='student' ORDER BY school_name DESC";
    $result = mysqli_query_log($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $date_student = array();
        while ($row = mysqli_fetch_array($result))
            array_push($date_student, $row);
        genCert($date_student, $dir_temp);
    }
} else if ($_GET['type'] == 'teacher') {
    $sql = "SELECT * FROM register_scifair WHERE running_year = '$running_year' AND type='teacher' ORDER BY school_name DESC";
    $result = mysqli_query_log($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $date_teacher = array();
        while ($row = mysqli_fetch_array($result))
            array_push($date_teacher, $row);
        genCertTeacher($date_teacher, $dir_temp);
    }
} else {
    mysqli_close($conn);
    header("location:cert_maker_scifair.php?act=error_empty");
    exit();
}
mysqli_close($conn);

function genCertTeacher($data_array, $dir_temp)
{
    $temp_arr = array();
    for ($i = 0; $i < count($data_array); $i++) {
        $pdf = new FPDF();
        $pdf->AddFont('TH Charm of AU', '', 'TH Charm of AU.php');
        $pdf->AddPage('L');
        $charset = "cp874//IGNORE";
        $pdf->Image('cert_scifair_teacher.png', 0, 0, 299, 205);
        $pdf->SetFont('TH Charm of AU', '', 26);
        $pdf->setXY(15, 90);
        $str = "as a project work advisor in " . $data_array[$i]["subject"];
        $pdf->Cell(0, 0, iconv('UTF-8', $charset, $data_array[$i]["name"]), 0, 1, "C");
        $pdf->SetFont('TH Charm of AU', '', 21);
        $pdf->setXY(15, 101);
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
function genCert($data_array, $dir_temp)
{
    $temp_arr = array();
    for ($i = 0; $i < count($data_array); $i++) {
        $pdf = new FPDF();
        $pdf->AddFont('TH Charm of AU', '', 'TH Charm of AU.php');
        $pdf->AddPage('L');
        $charset = "cp874//IGNORE";
        $pdf->Image('cert_scifair_student.png', 0, 0, 299, 205);
        $str = "has been awarded a " . $data_array[$i]["reward"] . " medal certificate in " . $data_array[$i]["subject"];
        $pdf->SetFont('TH Charm of AU', '', 26);
        $pdf->setXY(15, 90);
        $pdf->Cell(0, 0, iconv('UTF-8', $charset, $data_array[$i]["name"]), 0, 1, "C");
        $pdf->SetFont('TH Charm of AU', '', 21);
        $pdf->setXY(15, 101);
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
