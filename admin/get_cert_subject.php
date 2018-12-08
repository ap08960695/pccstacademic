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
    $sql = "  SELECT r.score, s.display, r.subject_id, r.name as name , rt.name as tname FROM register as r, school as s, register_teacher as rt 
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
    // var_dump($obj_array);
    function genCert($data_array) {
      $pdf=new FPDF();

      
      for($i=0;$i<count($data_array);$i++){
        $pdf->AddFont('TH Charm of AU','','TH Charm of AU.php');
        $pdf->AddPage('L');
        $pdf->Image('cerpccstth.jpg', 0, 0, 299, 205); 
        echo $data_array[$i]["score"];

        if($data_array[$i]["score"]!=NULL){

          if(intVal($data_array[$i]["score"]) >= 80){
            $str = "ได้รับรางวัลเกียรติบัตรเหรียญทอง การแข่งขัน";
          } elseif($score >= 70){
            $str = "ได้รับรางวัลเกียรติบัตรเหรียญเงิน การแข่งขัน";
          } elseif($score >= 60){
            $str = "ได้รับรางวัลเกียรติบัตรเหรียญทองแดง การแข่งขัน";
          } else {
            $str = "ได้เข้าร่วมการแข่งขัน";
          }
        }else {
          $str ="err";
          
         }
         		$pdf->SetFont('TH Charm of AU','',26);
            $pdf->setXY(15,88);
            $pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',"asdf"),0,1,"C");
            $pdf->SetFont('TH Charm of AU','',18);
            $pdf->setXY(15,98);
            // if($no > 0){
              $pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$str.$data_array[$i]["subject_id"].' '),0,1,"C");
            // } else { 
            //   $pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','ครูผู้ฝึกซ้อมนักเรียน'.$str.$subject.' '.$level),0,1,"C");
            // }
      }
        $pdf->Output();
    }
    genCert($obj_array);
?>
