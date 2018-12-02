<?php
 session_start();
	include_once('../condb.php');
  include_once('admin_check.php');
  $upOne = realpath(__DIR__ . '/..');  
  require( $upOne.'\\pccstcer\\fpdf.php');
  define('FPDF_FONTPATH','font/');
  
  
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
    echo $sql;
    if($teacher_result = mysql_query($sql, $conn)) {
      $obj_array_t = [];
      while($row = mysql_fetch_assoc($teacher_result)) {
        array_push($obj_array_t, $row);
      }
    } else {
      echo "err";
    }
    
?>
