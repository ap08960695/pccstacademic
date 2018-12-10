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
    $sql = "  SELECT r.school_id, r.id, r.score, s.display, r.subject_id, r.name as name , rt.name as tname FROM register as r, school as s, register_teacher as rt 
     WHERE rt.school_id= r.school_id AND rt.subject_id=r.subject_id AND
    r.school_id=s.code AND r.subject_id='".$subject_id."'";
    if($student_result = mysql_query($sql, $conn)) {
      $obj_array = [];
      while($row = mysql_fetch_assoc($student_result)) {
        // var_dump($row);
        // echo $row['name'].$row['tname'].$row['display'].$row['subject_id'].$row['score']."<br>";
        array_push($obj_array, $row);
      }
    } else {
      echo "err";
    }
    
    function genCert($data_array) {
       $dir_up = realpath(__DIR__ . '/..');  
      
      for($i=0;$i<count($data_array);$i++){
        $pdf=new FPDF();
        $pdf->AddFont('TH Charm of AU','','TH Charm of AU.php');
        $pdf->AddPage('L');
        $pdf->Image('cerpccstth.jpg', 0, 0, 299, 205); 

        if($data_array[$i]["score"]!=NULL){
          $score = intVal($data_array[$i]["score"]);
          if($score >= 80){
            $str = "ได้รับรางวัลเกียรติบัตรเหรียญทอง การแข่งขัน";
          } else if($score >= 70){
            $str = "ได้รับรางวัลเกียรติบัตรเหรียญเงิน การแข่งขัน";
          } else if($score >= 60){
            $str = "ได้รับรางวัลเกียรติบัตรเหรียญทองแดง การแข่งขัน";
          } else {
            $str = "ได้เข้าร่วมการแข่งขัน";
          }
        }else {
          $str = "ได้เข้าร่วมการแข่งขัน";
        }
         		$pdf->SetFont('TH Charm of AU','',26);
            $pdf->setXY(15,88);
            $pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$data_array[$i]["name"]),0,1,"C");
            $pdf->SetFont('TH Charm of AU','',18);
            $pdf->setXY(15,98);
            // if($no > 0){
              $pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$str.$data_array[$i]["subject_id"].' '),0,1,"C");
            // } else { 
            //   $pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','ครูผู้ฝึกซ้อมนักเรียน'.$str.$subject.' '.$level),0,1,"C");
            // }
            $filename = $data_array[$i]["subject_id"]."_".$data_array[$i]["school_id"]."_".str_pad($data_array[$i]["id"],7,"0",STR_PAD_LEFT).".pdf";
            $pdf->Output($dir_up."\\pccstcer\\certfile\\".$filename,"F");
          }
          // zipArchiver(realpath("files"));
          // $pdf-> Output();
      // echo "adsfsad";
    }
  
    function zipArchiver($rootPath) {
      $zip = new ZipArchive();
      $zip->open('file.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

      // Initialize empty "delete list"
      $filesToDelete = array();

     
      $files = new RecursiveIteratorIterator(
          new RecursiveDirectoryIterator($rootPath),
          RecursiveIteratorIterator::LEAVES_ONLY
      );

      foreach ($files as $name => $file)
      {
          // Skip directories (they would be added automatically)
          if (!$file->isDir())
          {
              // Get real and relative path for current file
              $filePath = $file->getRealPath();
              $relativePath = substr($filePath, strlen($rootPath) + 1);

              // Add current file to archive
              $zip->addFile($filePath, $relativePath);

              // Add current file to "delete list"
              // delete it later cause ZipArchive create archive only after calling close function and ZipArchive lock files until archive created)
              if ($file->getFilename() != 'important.txt')
              {
                  $filesToDelete[] = $filePath;
              }
          }
      }

      // Zip archive will be created only after closing object
      $zip->close();

      // Delete all files from "delete list"
      // foreach ($filesToDelete as $file)
      // {
      //     unlink($file);
      // }
    }
    genCert($obj_array);
?>
