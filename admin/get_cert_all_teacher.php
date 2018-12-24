<?php
 session_start();
	include_once('../condb.php');
  include_once('admin_check.php');
  $upOne = realpath(__DIR__ . '/..');  
  require( $upOne.'/pccstcer/fpdf.php');
  define('FPDF_FONTPATH','font/');
  ini_set('max_execution_time', 300);
  $sql = "SELECT register_teacher.school_id, register_teacher.id, school.display, register_teacher.subject_id, register_teacher.name,contest.contest_name,contest.education FROM register_teacher INNER JOIN school ON register_teacher.school_id=school.code INNER JOIN contest ON register_teacher.subject_id=contest.code";
  if($student_result = mysql_query($sql, $conn)) {
    $obj_array = [];
    while($row = mysql_fetch_assoc($student_result)) {
      $sql = "SELECT MAX(register.score) AS score FROM register WHERE register.subject_id='".$row['subject_id']."' AND register.school_id='".$row['school_id']."'";
      if($score_result = mysql_query($sql, $conn)) {
        $row_score = mysql_fetch_assoc($score_result);
        $row['score'] = $row_score['score']; 
      } 
      array_push($obj_array, $row);
    }
    genCertTeacher($obj_array);
    header("location:report_subject.php?act=success_cer");
    exit();
  }else {
    header("location:report_subject.php?act=error_get_data");
    exit();
  }
    function genCertTeacher($data_array) {
      $dir_up = realpath(__DIR__ . '/..');
        for($i=0;$i<count($data_array);$i++){
          $pdf=new FPDF();
          $pdf->AddFont('TH Charm of AU','','TH Charm of AU.php');
          $pdf->AddPage('L');
          if($data_array[$i]["subject_id"][0]=="1"){
            $charset = "cp874//IGNORE";
            $pdf->Image('cert_th.png', 0, 0, 299, 205); 
          }else if($data_array[$i]["subject_id"][0]=="2"){
            $charset = "cp874//IGNORE";
            $pdf->Image('cert_en.png', 0, 0, 299, 205);
          }
          if(intval($data_array[$i]["score"])!=-1){
            $score = intVal($data_array[$i]["score"]);
            $str = "";
            if($score >= 80){
              if($data_array[$i]["subject_id"][0]=="1"){
                $str = "ครูผู้ฝึกซ้อมนักเรียน ได้รับรางวัลเกียรติบัตรเหรียญทอง การแข่งขัน"; 
              }else if($data_array[$i]["subject_id"][0]=="2"){
                $str = "Has trained a student receiving a gold medal certificate for ";
              }
            } else if($score >= 70){
              if($data_array[$i]["subject_id"][0]=="1"){
                $str = "ครูผู้ฝึกซ้อมนักเรียน ได้รับรางวัลเกียรติบัตรเหรียญเงิน การแข่งขัน"; 
              }else if($data_array[$i]["subject_id"][0]=="2"){
                $str = "Has trained a student receiving a silver medal certificate for ";
              }
            } else if($score >= 60){
              if($data_array[$i]["subject_id"][0]=="1"){
                $str = "ครูผู้ฝึกซ้อมนักเรียน ได้รับรางวัลเกียรติบัตรเหรียญทองแดง การแข่งขัน"; 
              }else if($data_array[$i]["subject_id"][0]=="2"){
                $str = "Has trained a student receiving a bronze medal certificate for ";
              }
            } else {
              if($data_array[$i]["subject_id"][0]=="1"){
                $str = "ครูผู้ฝึกซ้อมนักเรียน ได้รับรางวัลเกียรติบัตรเข้าร่วมการแข่งขัน การแข่งขัน"; 
              }else if($data_array[$i]["subject_id"][0]=="2"){
                $str = "Has trained a student ";
              }
            }
            if($data_array[$i]["subject_id"][0]=="1"){
              $data_array[$i]["education"] = str_replace("ม.","มัธยมศึกษา",$data_array[$i]["education"]);
              $data_array[$i]["education"] = str_replace("ป.","ประถมศึกษา",$data_array[$i]["education"]);
              $str .= $data_array[$i]["contest_name"]." ระดับ".$data_array[$i]["education"]; 
            }else if($data_array[$i]["subject_id"][0]=="2"){
              $str .= $data_array[$i]["contest_name"]." ".$data_array[$i]["education"];
            }
            $pdf->SetFont('TH Charm of AU','',26);
            $pdf->setXY(15,92);
            $pdf->Cell(0,0,iconv( 'UTF-8',$charset,$data_array[$i]["name"]),0,1,"C");
            $pdf->SetFont('TH Charm of AU','',18);
            $pdf->setXY(15,103);
            $pdf->Cell(0,0,iconv( 'UTF-8',$charset,$str),0,1,"C");
            $filename = "teacher_".$data_array[$i]["subject_id"]."_".$data_array[$i]["school_id"]."_".str_pad($data_array[$i]["id"],7,"0",STR_PAD_LEFT).".pdf";
            $pdf->Output($dir_up."/pccstcer/certfile/".$filename,"F");
          } 		
        }
  }  
?>
