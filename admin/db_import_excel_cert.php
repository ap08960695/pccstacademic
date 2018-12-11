<?php 
  session_start();
  include_once('../condb.php');
  include_once('admin_check.php');
  $upOne = realpath(__DIR__ . '/..');  
  require( $upOne.'\\pccstcer\\fpdf.php');
  define('FPDF_FONTPATH','font/');
  require_once __DIR__ . '/vendor/autoload.php';

  $uploaddir = __DIR__."\\files\\";
  $uploadfile = $uploaddir . basename($_FILES['myFile']['name']);

  if (move_uploaded_file($_FILES['myFile']['tmp_name'], $uploadfile)) {
    // echo "File is valid, and was successfully uploaded.\n";
    // echo $uploadfile;
  } else {
      echo "Possible file upload attack!\n";
  }


  /** PHPExcel_IOFactory */

  $inputFileName =  $uploadfile;
  // $inputFileName = __DIR__.'\\files\\report_11101_24_11_2018_065804.xlsx';
  // echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory to identify the format<br />';
  $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
  // echo '<hr />';
  $sheetData = $objPHPExcel->getSheet(0)->toArray(null,true,true,true);
  
  function genCert($data_array) {
      $dir_up = realpath(__DIR__ . '/..');  
      $temp_arr = array();
      for($i=2;$i<count($data_array);$i++){
        
        $pdf=new FPDF();
        $pdf->AddFont('TH Charm of AU','','TH Charm of AU.php');
        $pdf->AddPage('L');
        $pdf->Image('cerpccstth.jpg', 0, 0, 299, 205); 

         		$pdf->SetFont('TH Charm of AU','',26);
            $pdf->setXY(15,88);
            $pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$data_array[$i]["A"]),0,1,"C");
            $pdf->SetFont('TH Charm of AU','',18);
            $pdf->setXY(15,98);
            $filename = "temp_".$i.".pdf";
            $pdf->Output($dir_up."\\pccstcer\\joincertfile\\".$filename,"F");
            array_push($temp_arr,$filename);
          }
        $archive_file_name = "temp_all_download.zip";
        $file_path = $dir_up."\\pccstcer\\joincertfile\\";
        $file_path_temp = $dir_up."\\pccstcer\\temp\\";
        archiver_download($temp_arr, $archive_file_name, $file_path, $file_path_temp);
        
    }
    
  function archiver_download($file_names,$archive_file_name,$file_path, $file_path_temp){ //sending download
   $zip = new ZipArchive();
    //create the file and throw the error if unsuccessful
    $dir_temp = $file_path_temp;
    if ($zip->open($dir_temp.$archive_file_name, ZIPARCHIVE::CREATE )!==TRUE) {
        exit("cannot open <$archive_file_name>\n");
    }

    //add each files of $file_name array to archive
    foreach($file_names as $files)
    {
        $zip->addFile($file_path.$files,$files);
        // echo $file_path.$files,$files;
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
    genCert($sheetData);
  ?>