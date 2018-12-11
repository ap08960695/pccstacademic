<?php 

  function archiver_download($file_names,$archive_file_name,$file_path){ //sending download
   $zip = new ZipArchive();
    //create the file and throw the error if unsuccessful
    $dir_temp = __DIR__."\\pccstcer\\temp\\";
    if ($zip->open($dir_temp.$archive_file_name, ZIPARCHIVE::CREATE )!==TRUE) {
        exit("cannot open <$archive_file_name>\n");
    }
    //add each files of $file_name array to archive
    foreach($file_names as $files)
    {
        $zip->addFile($file_path.$files,$files);
        //echo $file_path.$files,$files."
    }
    $zip->close();
    header("Content-type: application/zip"); 
    header("Content-Disposition: attachment; filename=$archive_file_name");
    header("Content-length: " . filesize($dir_temp.$archive_file_name));
    header("Pragma: no-cache"); 
    header("Expires: 0"); 
    readfile($dir_temp.$archive_file_name);
    exit;
  }
  $dir_path = __DIR__."\\pccstcer\\certfile\\";
  $archive_file_name = "";
  $arr = array();
  if(isset($_GET["subject"]) && isset($_GET["school"])) {
   $archive_file_name = "arc_".$_GET["subject"]."_".$_GET["school"].".zip";
   $pattern = $dir_path.$_GET["subject"]."_".$_GET["school"]."_*.pdf";
    foreach (glob($pattern) as $filename) {
     array_push($arr,basename($filename)); //add array
   }
   if($arr){
      archiver_download($arr, $archive_file_name, $dir_path);
   }
  }
  else if(isset($_GET["school"])){
    $archive_file_name = "arc_".$_GET["school"].".zip";
    $pattern = $dir_path."*_".$_GET["school"]."_*.pdf";
    foreach (glob($pattern) as $filename) {
      array_push($arr,basename($filename)); //add array
    }
    if($arr){
      archiver_download($arr, $archive_file_name, $dir_path);
    }
  }
  else {
    //do nothing
  }
?>