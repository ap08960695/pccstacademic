<?php
 session_start();
	include_once('../condb.php');
  include_once('admin_check.php');
  $upOne = realpath(__DIR__ . '/..');  
  require( $upOne.'/pccstcer/fpdf.php');
  define('FPDF_FONTPATH','font/');

  $sql = "SELECT register.school_id, register.id, register.score, school.display, register.subject_id, register.name FROM register INNER JOIN school ON register.school_id=school.code";
  if($student_result = mysql_query($sql, $conn)) {
    $obj_array = [];
    while($row = mysql_fetch_assoc($student_result)) {
      array_push($obj_array, $row);
    }
    genCert($obj_array);
    header("location:report_subject.php?act=success_cer");
    exit();
  }else {
    header("location:report_subject.php?act=error_get_data");
    exit();
  }
  function genCert($data_array) {
    $dir_up = realpath(__DIR__ . '/..');  
      for($i=0;$i<count($data_array);$i++){
        $pdf=new FPDF();
        $pdf->AddFont('TH Charm of AU','','TH Charm of AU.php');
        $pdf->AddPage('L');
        $pdf->Image('cerpccst.jpg', 0, 0, 299, 205); 

        if($data_array[$i]["score"]!=-1){
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
          $pdf->SetFont('TH Charm of AU','',26);
          $pdf->setXY(15,88);
          $pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$data_array[$i]["name"]),0,1,"C");
          $pdf->SetFont('TH Charm of AU','',18);
          $pdf->setXY(15,98);
          $pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$str.$data_array[$i]["subject_id"].' '),0,1,"C");
          $filename = $data_array[$i]["subject_id"]."_".$data_array[$i]["school_id"]."_".str_pad($data_array[$i]["id"],7,"0",STR_PAD_LEFT).".pdf";
          $pdf->Output($dir_up."/pccstcer/certfile/".$filename,"F");
        } 		
      }
    }
?>
