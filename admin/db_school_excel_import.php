<?php
session_start();
include_once('../condb.php');
include_once('admin_check.php');
require_once __DIR__ . '/vendor/autoload.php';

$uploaddir = __DIR__ . "/files/";
if ($_FILES['myFile']['name'] == "") {
  header("location:report_subject.php?act=empty_file");
  exit();
}
$uploadfile = $uploaddir . basename($_FILES['myFile']['name']);
$uploadfilepath = $_FILES['myFile']['tmp_name'];
$objPHPExcel = PHPExcel_IOFactory::load($uploadfilepath);
$sheetData = $objPHPExcel->getSheet(0)->toArray(null, true, true, true);

if (isset($_GET["s"])) {
  $subject_id = $_GET["s"];
  $sql = "UPDATE register SET status = 0 WHERE running_year = '$running_year' AND subject_id='" . $subject_id . "'";
  if ($result = mysqli_query($conn, $sql)) {
    $strinsert = "";
    for ($i = 2; $i <= count($sheetData); $i++) {
      if ($sheetData[$i]["E"] == "0")
        $score = 0;
      else if ($sheetData[$i]["E"] == "")
        $score = -1;
      else $score = intval($sheetData[$i]["E"]);
      $strinsert .= "('" . $sheetData[$i]["D"] . "','" . $subject_id . "','" . $sheetData[$i]["B"] . "',1," . $score . ",'" . $running_year . "'),";
    }

    $strinsert = substr($strinsert, 0, -1);
    $sql = "INSERT INTO register (school_id, subject_id, name, status, score,running_year) VALUES " . $strinsert;
    if (!mysqli_query($conn, $sql)) {
      $sql = "DELETE FROM register WHERE running_year = '$running_year' AND subject_id='" . $subject_id . "' AND status=1";
      mysqli_query($conn, $sql);
      $sql = "UPDATE register SET status = 1 WHERE running_year = '$running_year' AND subject_id='" . $subject_id . "' AND status=0";
      mysqli_query($conn, $sql);
      header("location:report_subject.php?act=student_error_insert");
      exit();
    }
    $sql = "DELETE FROM register WHERE running_year = '$running_year' AND subject_id='" . $subject_id . "' AND status=0";
    if (!mysqli_query($conn, $sql)) {
      $sql = "DELETE FROM register WHERE running_year = '$running_year' AND subject_id='" . $subject_id . "' AND status=1";
      mysqli_query($conn, $sql);
      $sql = "UPDATE register SET status = 1 WHERE running_year = '$running_year' AND subject_id='" . $subject_id . "' AND status=0";
      mysqli_query($conn, $sql);
      header("location:report_subject.php?act=student_error_delete");
      exit();
    }
  } else {
    header("location:report_subject.php?act=student_error_excel");
    exit();
  }
  $sheetData = $objPHPExcel->getSheet(1)->toArray(null, true, true, true);
  $sql = "UPDATE register_teacher SET status= 0 WHERE running_year = '$running_year' AND subject_id='" . $subject_id . "'";
  if (mysqli_query($conn, $sql)) {
    $strinsert = "";
    for ($i = 2; $i <= count($sheetData); $i++) {
      $strinsert .= "('" . $sheetData[$i]["D"] . "','" . $subject_id . "','" . $sheetData[$i]["B"] . "',1,'" . $running_year . "'),";
    }
    $strinsert = substr($strinsert, 0, -1);
    $sql = "INSERT INTO register_teacher (school_id, subject_id, name, status,running_year) VALUES " . $strinsert;
    if (!mysqli_query($conn, $sql)) {
      $sql = "DELETE FROM register_teacher WHERE subject_id='" . $subject_id . "' AND running_year = '$running_year' status=1";
      mysqli_query($conn, $sql);
      $sql = "UPDATE register_teacher SET status = 1 WHERE running_year = '$running_year' AND subject_id=" . $subject_id . " AND status=0";
      mysqli_query($conn, $sql);;
      header("location:report_subject.php?act=teacher_error_insert");
      exit();
    }
    $sql = "DELETE FROM register_teacher WHERE running_year = '$running_year' AND subject_id='" . $subject_id . "' AND status=0";
    if (mysqli_query($conn, $sql)) {
      header("location:report_subject.php?act=success");
      exit();
    } else {
      $sql = "DELETE FROM register_teacher WHERE running_year = '$running_year' AND subject_id='" . $subject_id . "' AND status=1";
      mysqli_query($conn, $sql);
      $sql = "UPDATE register_teacher SET status = 1 WHERE running_year = '$running_year' AND subject_id=" . $subject_id . " AND status=0";
      mysqli_query($conn, $sql);
      header("location:report_subject.php?act=teacher_error_delete");
      exit();
    }
  } else {
    header("location:report_subject.php?act=teacher_error_excel");
    exit();
  }
} else {
  header("location:report_subject.php?act=empty_contest");
  exit();
}
