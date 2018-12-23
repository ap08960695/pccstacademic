<?php 
  session_start();
  include_once('condb.php');
  include_once('user_check.php');
  function archiver_download($file_names,$archive_file_name,$file_path,$dir_temp){ //sending download
    $zip = new ZipArchive();
    $countfile = 1;
    $filename = $archive_file_name;
    $archive_file_name = $filename.str_pad(strval($countfile++),4,"0",STR_PAD_LEFT).".zip";
    while ($zip->open($dir_temp.$archive_file_name, ZIPARCHIVE::CREATE )!==TRUE) {
      $archive_file_name = $filename.str_pad(strval($countfile++),4,"0",STR_PAD_LEFT).".zip"; 
    }
    foreach($file_names as $files){  
      $zip->addFile($file_path.$files,$files);
    }
    $zip->close();
    echo "Wait for zip processing...<br>";
    header("Content-type: application/zip"); 
    header("Content-Disposition: attachment; filename='$archive_file_name'");
    header("Content-length: " . filesize($dir_temp.$archive_file_name));
    header("Pragma: no-cache"); 
    header("Expires: 0"); 
    ob_clean();
	  flush();
    readfile($dir_temp.$archive_file_name);
    unlink($dir_temp.$archive_file_name);
    exit();
  }
  $arr = array();
  if(isset($_GET["subject"]) && isset($_GET["school"])) {
   $archive_file_name = date("Ymdhis");
   $pattern = $dir_path."teacher_".$_GET["subject"]."_".$_GET["school"]."_*.pdf";
    foreach (glob($pattern) as $filename) {
      array_push($arr,basename($filename)); //add array
   }
   if($arr){
      archiver_download($arr, $archive_file_name, $dir_path,$dir_temp);
   }
  }
  else if(isset($_GET["school"])){   
    $archive_file_name = date("Ymdhis");
    $pattern = $dir_path."teacher_"."*_".$_GET["school"]."_*.pdf";
    foreach (glob($pattern) as $filename) {
      array_push($arr,basename($filename)); //add array
    }
    if($arr){
      archiver_download($arr, $archive_file_name, $dir_path,$dir_temp);
    }
  }
?>