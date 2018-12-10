<?php 
  session_start();
  include_once('../condb.php');
  include_once('admin_check.php');
  require_once __DIR__ . '/vendor/autoload.php';

  $uploaddir = __DIR__."\\files\\";
  $uploadfile = $uploaddir . basename($_FILES['myFile']['name']);

  if (move_uploaded_file($_FILES['myFile']['tmp_name'], $uploadfile)) {
    echo "File is valid, and was successfully uploaded.\n";
    echo $uploadfile;
  } else {
      echo "Possible file upload attack!\n";
  }
  /** PHPExcel_IOFactory */

  $inputFileName =  $uploadfile;
  // $inputFileName = __DIR__.'\\files\\report_11101_24_11_2018_065804.xlsx';
  echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory to identify the format<br />';
  $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
  echo '<hr />';
  $sheetData = $objPHPExcel->getSheet(0)->toArray(null,true,true,true);
  // var_dump($sheetData);
  if(isset($_GET["s"])){
    $subject_id = $_GET["s"];
    // INSERT INTO `register`(`id`, `school_id`, `subject_id`, `name`, `u_date`, `score`, `status`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7])
    $sql = "UPDATE register SET status = 0 WHERE subject_id=".$subject_id;
    if($result = mysql_query($sql, $conn)) {
      echo "OK";
      for($i=2; $i<=count($sheetData); $i++) {
        $score = $sheetData[$i]["E"]==""? -1 : parseInt($sheetData[$i]["E"]); 
        $sql = "INSERT INTO register (school_id, subject_id, name, status, score) VALUES ('".$sheetData[$i]["D"]."','".$subject_id."','".$sheetData[$i]["B"]."',1,".$score.")";
        $result = mysql_query($sql, $conn);
        if($result) {
          echo "INSERT OK";
          
        }else {
          echo "err".$i;
        }
      }
      $sql = "DELETE FROM register WHERE subject_id='".$subject_id."' AND status=0";
      echo $sql;
      if(mysql_query($sql, $conn)){
        echo "DELETE OK";
      }else {
        echo "err delete";
      }
    }else {
      $sql = "DELETE FROM register WHERE subject_id='".$subject_id."' AND status=1";
      mysql_query($sql, $conn);
      $sql = "UPDATE register SET status = 1 WHERE subject_id=".$subject_id." AND status=0";
      mysql_query($sql, $conn);      
      header("location:report_subject.php?act=student_error_delete");
    }
    //teacher part
    $sheetData = $objPHPExcel->getSheet(1)->toArray(null,true,true,true);
    $sql = "UPDATE register_teacher SET status= 0 WHERE subject_id=".$subject_id;
    if(mysql_query($sql, $conn)) {
      for($i=2; $i<=count($sheetData); $i++) {
        $sql = "INSERT INTO register_teacher (school_id, subject_id, name, status) VALUES ('".$sheetData[$i]["D"]."','".$subject_id."','".$sheetData[$i]["B"]."',1)";
        if(!mysql_query($sql, $conn)) {
          $sql = "DELETE FROM register_teacher WHERE subject_id='".$subject_id."' AND status=1";
          mysql_query($sql, $conn);
          $sql = "UPDATE register_teacher SET status = 1 WHERE subject_id=".$subject_id." AND status=0";
          mysql_query($sql, $conn);      
          header("location:report_subject.php?act=teacher_error_insert");
        }
        $sql = "DELETE FROM register_teacher WHERE subject_id='".$subject_id."' AND status=0";
        if(mysql_query($sql, $conn)){
          header("location:report_subject.php?act=success");
        }else {
          $sql = "DELETE FROM register_teacher WHERE subject_id='".$subject_id."' AND status=1";
          mysql_query($sql, $conn);
          $sql = "UPDATE register_teacher SET status = 1 WHERE subject_id=".$subject_id." AND status=0";
          mysql_query($sql, $conn);      
          header("location:report_subject.php?act=teacher_error_delete");
        }
      }
    } else {
    }
      header("location:report_subject.php?act=teacher_error_update_status");
  }  
      
      
      
  ?>