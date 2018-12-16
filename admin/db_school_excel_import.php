<?php 
  session_start();
  include_once('../condb.php');
  include_once('admin_check.php');
  require_once __DIR__ . '/vendor/autoload.php';

  $uploaddir = __DIR__."\\files\\";
  if($_FILES['myFile']['name']==""){
    header("location:report_subject.php?act=empty_file");
    exit();
  }
  $uploadfile = $uploaddir . basename($_FILES['myFile']['name']);
  $uploadfilepath = $_FILES['myFile']['tmp_name'];
  $objPHPExcel = PHPExcel_IOFactory::load($uploadfilepath);
  $sheetData = $objPHPExcel->getSheet(0)->toArray(null,true,true,true);
  
  if(isset($_GET["s"])){
    $subject_id = $_GET["s"];
    $sql = "UPDATE register SET status = 0 WHERE subject_id='".$subject_id."'";
    if($result = mysql_query($sql, $conn)) {
      for($i=2; $i<=count($sheetData); $i++) {
        $score = $sheetData[$i]["E"]==""? -1 : intval($sheetData[$i]["E"]); 
        $sql = "INSERT INTO register (school_id, subject_id, name, status, score) VALUES ('".$sheetData[$i]["D"]."','".$subject_id."','".$sheetData[$i]["B"]."',1,".$score.")";
        if(!mysql_query($sql, $conn)) {
          $sql = "DELETE FROM register WHERE subject_id='".$subject_id."' AND status=1";
          mysql_query($sql, $conn);
          $sql = "UPDATE register SET status = 1 WHERE subject_id='".$subject_id."' AND status=0";
          mysql_query($sql, $conn);      
          header("location:report_subject.php?act=student_error_insert");
          exit();
        }
      }
      $sql = "DELETE FROM register WHERE subject_id='".$subject_id."' AND status=0";
      if(!mysql_query($sql, $conn)){
        $sql = "DELETE FROM register WHERE subject_id='".$subject_id."' AND status=1";
        mysql_query($sql, $conn);
        $sql = "UPDATE register SET status = 1 WHERE subject_id='".$subject_id."' AND status=0";
        mysql_query($sql, $conn);      
        header("location:report_subject.php?act=student_error_delete");
        exit();
      }
    }else{
      header("location:report_subject.php?act=student_error_excel");
      exit();
    }
    $sheetData = $objPHPExcel->getSheet(1)->toArray(null,true,true,true);
    $sql = "UPDATE register_teacher SET status= 0 WHERE subject_id='".$subject_id."'";
    if(mysql_query($sql, $conn)) {
      for($i=2; $i<=count($sheetData); $i++) {
        $sql = "INSERT INTO register_teacher (school_id, subject_id, name, status) VALUES ('".$sheetData[$i]["D"]."','".$subject_id."','".$sheetData[$i]["B"]."',1)";
        if(!mysql_query($sql, $conn)) {
          $sql = "DELETE FROM register_teacher WHERE subject_id='".$subject_id."' AND status=1";
          mysql_query($sql, $conn);
          $sql = "UPDATE register_teacher SET status = 1 WHERE subject_id=".$subject_id." AND status=0";
          mysql_query($sql, $conn);      
          header("location:report_subject.php?act=teacher_error_insert");
          exit();
        }
        $sql = "DELETE FROM register_teacher WHERE subject_id='".$subject_id."' AND status=0";
        if(mysql_query($sql, $conn)){
          header("location:report_subject.php?act=success");
          exit();
        }else {
          $sql = "DELETE FROM register_teacher WHERE subject_id='".$subject_id."' AND status=1";
          mysql_query($sql, $conn);
          $sql = "UPDATE register_teacher SET status = 1 WHERE subject_id=".$subject_id." AND status=0";
          mysql_query($sql, $conn);      
          header("location:report_subject.php?act=teacher_error_delete");
          exit();
        }
      }
    }else{
      header("location:report_subject.php?act=teacher_error_excel");
      exit();
    }
  }else{
    header("location:report_subject.php?act=empty_contest");
    exit();
  }  
?>