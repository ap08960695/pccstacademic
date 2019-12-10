<?php

session_start();
include_once('../condb.php');
include_once('admin_check.php');
require_once __DIR__ . '/vendor/autoload.php';

$objPHPExcel = new PHPExcel();
$sql = "SELECT code,contest_name,education,type,(SELECT count(*) FROM register WHERE register.running_year='$running_year' AND register.subject_id = contest.code) AS sumary FROM contest WHERE running_year='$running_year' ORDER BY code ASC ";
$obj_array = [];
if ($contest_result = mysqli_query_log($conn, $sql)) {
    while ($row = mysqli_fetch_assoc($contest_result)) {
        array_push($obj_array, $row);
    }
}
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', "Code")
    ->setCellValue('B1', "Contest")
    ->setCellValue('C1', "Count");
for ($i = 0; $i < count($obj_array); $i++) {
    $indexing = $i + 2;
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . strval($indexing), $obj_array[$i]['code'])
        ->setCellValue('B' . strval($indexing), $obj_array[$i]["contest_name"])
        ->setCellValue('C' . strval($indexing), $obj_array[$i]["sumary"]);

    $objPHPExcel->createSheet($i + 1)
        ->setCellValue('A1', $obj_array[$i]['code'])
        ->setCellValue('B1', $obj_array[$i]["contest_name"])
        ->setCellValue('C1', $obj_array[$i]["education"])
        ->setCellValue('D1', $obj_array[$i]["type"]);

    $objPHPExcel->setActiveSheetIndex($i + 1)
        ->setCellValue('A2', "Index")
        ->setCellValue('B2', "Name")
        ->setCellValue('C2', "School");
    $sql = "SELECT school.display,register.name FROM register INNER JOIN school ON register.school_id=school.code AND register.running_year='$running_year' WHERE register.running_year='$running_year' AND register.subject_id = '" . $obj_array[$i]['code'] . "' ORDER BY register.score DESC, school.display ASC";
    if ($student_result = mysqli_query_log($conn, $sql)) {
        $j = 3;
        while ($row = mysqli_fetch_assoc($student_result)) {
            $objPHPExcel->setActiveSheetIndex($i + 1)
                ->setCellValue('A' . $j, $j - 2)
                ->setCellValue('B' . $j, $row['name'])
                ->setCellValue('C' . $j, $row['display']);
            $j++;
        }
        $objPHPExcel->setActiveSheetIndex($i + 1)->setTitle($obj_array[$i]['code']);
    }
}
$objPHPExcel->setActiveSheetIndex(0)->setTitle('Sumary');
$fileExportName =  "Sumary.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $fileExportName . '"');
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_end_clean();
$objWriter->save('php://output');
