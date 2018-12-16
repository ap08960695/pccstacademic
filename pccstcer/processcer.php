<html>
<head>
<title>Process Cer Pccst</title>
</head>
<body>
<?php
	require('fpdf.php');
	session_start();
    include_once('../condb.php');
    $school_code = $_SESSION["code"];
    $schoolname = $_SESSION["display"];
	define('FPDF_FONTPATH','font/');
	
	$sql = "SELECT r.id,code,r.no,r.name AS 'pname',s.name AS 'subject',level,person,score FROM register r JOIN subject s ON r.subject_id = s.code WHERE r.status = 1;";
    $result = mysql_query($sql ,$conn);
	$i=1;
    if (mysql_num_rows($result) > 0) {
        while($row = mysql_fetch_array($result)) {
			$id = $row['id'];
			$no = $row['no'];
			$person = $row['pname'];
			$score = $row['score'];
			$subject = $row['subject'];
			$level = $row['level'];
			$code = $row['code'];
			gencer($i,$id,$code,$no,$person,$score,$subject,$level);
			$i++;
			//break;
		}
	}
	
	header("location:../report_subject.php?q=1");
    $conn->close();

function gencer($i,$id,$code,$no,$person,$score,$subject,$level) {
	$pdf=new FPDF();
	$pdf->AddPage('L');
	//$pdf->AddFont('TH Fahkwang','','TH Fahkwang.php');
	$pdf->AddFont('TH Charm of AU','','TH Charm of AU.php');
	
	if($code < 20000) {
		$pdf->Image('cerpccst.jpg', 0, 0, 299, 205); 
		if($score >= 80){
			$str = "ได้รับรางวัลเกียรติบัตรเหรียญทอง การแข่งขัน";
		} elseif($score >= 70){
			$str = "ได้รับรางวัลเกียรติบัตรเหรียญเงิน การแข่งขัน";
		} elseif($score >= 60){
			$str = "ได้รับรางวัลเกียรติบัตรเหรียญทองแดง การแข่งขัน";
		} else {
			$str = "ได้เข้าร่วมการแข่งขัน";
		}
		
		$pdf->SetFont('TH Charm of AU','',26);
		$pdf->setXY(15,88);
		$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$person),0,1,"C");
		$pdf->SetFont('TH Charm of AU','',18);
		$pdf->setXY(15,98);
		if($no > 0){
			$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$str.$subject.' '.$level),0,1,"C");
		} else { 
			$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','ครูผู้ฝึกซ้อมนักเรียน'.$str.$subject.' '.$level),0,1,"C");
		}
	
	} else {
		$pdf->Image('cerpccst.jpg', 0, 0, 299, 205); 		
		$pdf->SetFont('TH Charm of AU','',26);
		$pdf->setXY(15,92);
		$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$person),0,1,"C");
		$pdf->SetFont('TH Charm of AU','',18);
		$pdf->setXY(15,100);
		if($no > 0){
			if($score >= 80){
				$str = "has been awarded a gold medal, certificate for ";
			} elseif($score >= 70){
				$str = "has been awarded a silver medal, certificate for ";
			} elseif($score >= 60){
				$str = "has been awarded a bronze medal, certificate for ";
			} else {
				$str = "has attended ";
			}
			$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$str.$subject.' '.$level),0,1,"C");
		} else { 
			if($score >= 80){
				$str = "has trained a student receiving a gold medal, award in ";
			} elseif($score >= 70){
				$str = "has trained a student receiving a silver medal, award in ";
			} elseif($score >= 60){
				$str = "has trained a student receiving a bronze medal, award in ";
			} else {
				$str = "has trained a student ";
			}
			$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$str.$subject.' '.$level),0,1,"C");
		}
		
	}
	/* 
	$pdf->SetFont('TH Fahkwangna','B',16);
	$pdf->setXY( 10, 20  );
	$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'อังสนา ตัวหนา ขนาด 16' )  );
	 
	$pdf->SetFont('TH Fahkwangna','I',24);
	$pdf->setXY( 10, 30  );
	$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'อังสนา ตัวเอียง ขนาด 24' )  );
	*/
	$filename = "cerpccst_2560".$id.$code.$no.".pdf";
	$pdf->Output("pdf/".$filename,"F");
} 
	
?>
</body>
</html>