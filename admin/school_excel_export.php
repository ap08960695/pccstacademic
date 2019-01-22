<?php

session_start();
include_once('../condb.php');
include_once('admin_check.php');
require_once __DIR__ . '/vendor/autoload.php';

  // function querySetBySubjectId($subject_id, $conn){
   
    if(isset($_GET["s"])){
     $subject_id = $_GET["s"];
    }
    $sql = "  SELECT * FROM register, school WHERE register.school_id=school.code AND register.subject_id='".$subject_id."'";
    if($student_result = mysql_query($sql, $conn)) {
      $obj_array = [];
      while($row = mysql_fetch_assoc($student_result)) {
        // var_dump($row);
        array_push($obj_array, $row);
      }
    } else {
      echo "err";
    }
    
    $sql = "  SELECT * FROM register_teacher, school WHERE register_teacher.school_id=school.code AND register_teacher.subject_id='".$subject_id."'";
    // echo $sql;
    if($teacher_result = mysql_query($sql, $conn)) {
      $obj_array_t = [];
      while($row = mysql_fetch_assoc($teacher_result)) {
        array_push($obj_array_t, $row);
      }
    } else {
      echo "err";
    }
    
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');
/** Include PHPExcel */
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', "#")
->setCellValue('B1', "Name")
->setCellValue('C1', "School Name")
->setCellValue('D1', "School Code")
->setCellValue('E1', "Score");
for($i=0; $i<count($obj_array); $i++) {
  $indexing = $i+2;
  $objPHPExcel->setActiveSheetIndex(0)
  ->setCellValue('A'.strval($indexing), $indexing-1)
  ->setCellValue('B'.strval($indexing), $obj_array[$i]["name"])
  ->setCellValue('C'.strval($indexing), $obj_array[$i]["display"])
  ->setCellValue('D'.strval($indexing), strval($obj_array[$i]["code"]))
  ->setCellValue('E'.strval($indexing), $obj_array[$i]["score"]==-1?"":$obj_array[$i]["score"]);
}
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('B')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);

$objPHPExcel->getActiveSheet()->setTitle('Student');

// ->setCellValue('A1', 'Hello')
            // ->setCellValue('B2', 'world!')
            // ->setCellValue('C1', 'Hello')
            // ->setCellValue('D2', 'world!');

// Rename worksheet

// $objPHPExcel->getActiveSheet()->setTitle('Student');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$obj_array = $obj_array_t;
$newsheet = $objPHPExcel->createSheet();
$newsheet
  ->setCellValue('A1', "#")
  ->setCellValue('B1', "Name")
  ->setCellValue('C1', "School Name")
  ->setCellValue('D1', "School Code");
  // ->setCellValue('E1', "Score");
for($i=0; $i<count($obj_array); $i++) {
  $indexing = $i+2;
  $newsheet
  ->setCellValue('A'.strval($indexing), $indexing-1)
  ->setCellValue('B'.strval($indexing), $obj_array[$i]["name"])
  ->setCellValue('C'.strval($indexing), $obj_array[$i]["display"])
  ->setCellValue('D'.strval($indexing), strval($obj_array[$i]["code"]));
  // ->setCellValue('E'.strval($indexing), $obj_array[$i]["score"]);
}
$newsheet->getColumnDimensionByColumn('B')->setAutoSize(false);
$newsheet->getColumnDimension('A')->setWidth(10);
$newsheet->getColumnDimension('B')->setWidth(30);
$newsheet->getColumnDimension('C')->setWidth(40);
$newsheet->getColumnDimension('D')->setWidth(20);
$newsheet->getColumnDimension('E')->setWidth(15);

$newsheet->setTitle('Teacher');

            // ->setCellValue('A1', 'Hello')
            // ->setCellValue('B2', 'world!')
            // ->setCellValue('C1', 'Hello')
            // ->setCellValue('D2', 'world!');

// Rename worksheet
// Redirect output to a client’s web browser (Excel2007)
$fileExportName =  $subject_id.".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$fileExportName.'"');
header('Cache-Control: max-age=0');
// // If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// // If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
ob_end_clean();
$objWriter->save('php://output');
exit;
// $objWriter->save('test/test.xlsx');

 ?>