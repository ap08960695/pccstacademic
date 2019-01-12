<?php 
  session_start();
	include_once('../condb.php');
  include_once('admin_check.php');
  $upOne = realpath(__DIR__ . '/..');  
  require( $upOne.'/pccstcer/fpdf.php');
  define('FPDF_FONTPATH','font/');
	
class PDF extends FPDF
{
  var $widths;
var $aligns;

function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function Row($h, $data)
{
    // Calculate the height of the row
    // $nb=0;
    // for($i=0;$i<count($data);$i++)
    //     $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    // $h=5.75*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    // Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5.5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger){
      $this->AddPage($this->CurOrientation);
      return true;
    } else {
      return false;
    }
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
// Load data
  function LoadData($file)
  {
      // Read file lines
      $lines = file($file);
      $data = array();
      foreach($lines as $line)
          $data[] = explode(';',trim($line));
      return $data;
  }

  // Simple table
  function BasicTable($header, $data)
  {
      // Header
      foreach($header as $col)
          $this->Cell(40,7,$col,1);
      $this->Ln();
      // Data
      foreach($data as $row)
      {
          foreach($row as $col)
              $this->Cell(40,6,$col,1);
          $this->Ln();
      }
  }

  // Better table
  function ImprovedTable($header, $data)
  {
      // Column widths
      $w = array(15, 50, 70, 30,35);
      // Header
      for($i=0;$i<count($header);$i++)
          $this->Cell($w[$i],7,$header[$i],1,0,'C');
      $this->Ln();
      // Data
      // var_dump($data);
      // echo strlen("Princess Chulabhorn Science High School Nakhon");
      
      $x = $this->GetX();
      $y = $this->GetY();
      foreach($data as $row)
      {
        // echo $this->cutOffString($this->getUTF($row["display"]))."<br>";
        // iconv( 'UTF-8','TIS-620', $row["id"]
          
          $this->MultiCell($w[0],6, $this->getUTF($row["id"]),'LR');
          $x+=$w[0];
          $this->SetXY($x,$y);
          $this->MultiCell($w[1],6, $this->getUTF($row["name"]),'LR');
          $x+=$w[1];
          $this->SetXY($x,$y);
          
          $this->MultiCell($w[2],6, $this->cutOffString($this->getUTF($row["display"])),'LR');
          $x+=$w[2];
          $this->SetXY($x,$y);
          
          $this->MultiCell($w[3],6, $this->getUTF($row["changwat"]),'LR');
          $x+=$w[3];
          $this->SetXY($x,$y);
          
          $this->MultiCell($w[4],6, $this->getUTF("___________________"),'LR');
          

          // $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
          // $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
          $this->Ln();
      }
      // Closing line
      $this->Cell(array_sum($w),0,'','T');
  }

  function getUTF($data) {
    return iconv( 'UTF-8','TIS-620', $data);
  }

  function cutOffString ($data) {
    if(strlen($data)>46){
      $fore = substr($data, 0, 46);
      $end = substr($data, 47, strlen($data));
      return $fore."\n\t".$end;
    }
    else return $data;
  }

  // Colored table

}
  
function d_form_str($d_start, $d_end) {
  $date = date_format(date_create($d_start), 'd F Y'); //case 1 day 
  $time_start = date_format(date_create($d_start), 'H:i');
  $time_end = date_format(date_create($d_end), 'H:i');

  return $date." ".$time_start." - ".$time_end;
}

  if(isset($_GET["s"])){
    $subject_id = $_GET["s"];
  }
  $sql ="SELECT * FROM room_contest INNER JOIN room ON room_contest.room_id=room.id INNER JOIN contest ON contest.code=room_contest.contest_code WHERE room_contest.contest_code='".$subject_id."'";
  $result = mysql_query($sql, $conn);
  $obj_array_room = [];
  if($result){
    while($row = mysql_fetch_assoc($result)){
      array_push($obj_array_room, $row);
    }
  } else {
  }
  if(!$obj_array_room)echo "<script> alert('Please assign room to contest');</script>";
  $header = [];
  $sql = "  SELECT * FROM register, school WHERE register.school_id=school.code AND register.subject_id='".$subject_id."'";
    if($student_result = mysql_query($sql, $conn)) {
      $obj_array = [];
      while($row = mysql_fetch_assoc($student_result)) {
        array_push($obj_array, $row);
      }
    } else {
      echo "err";
    }
    
    $sql = "  SELECT * FROM register_teacher, school WHERE register_teacher.school_id=school.code AND register_teacher.subject_id='".$subject_id."'";
    if($teacher_result = mysql_query($sql, $conn)) {
      $obj_array_t = [];
      while($row = mysql_fetch_assoc($teacher_result)) {
        array_push($obj_array_t, $row);
      }
    } else {
      echo "err";
    }
  $header_table = array('No.', 'Name', 'School', 'Province', 'Signature');
  
$pdf = new PDF();
$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
$pdf->AddFont('Angsana','','angsa.php');
$pdf->SetFont('Angsana','',14);
$pdf->SetWidths(array(10,45,60,35,40));
$page_start = 0;
$page_end =0;
$temp_arr_len = count($obj_array);
for($i=0;$i<count($obj_array_room);$i+=1){
  $temp_paging[$i][0] =intVal($obj_array_room[$i]["amount_student"]);
  $temp_paging[$i][1] = $page_start;
  $page_end+= intVal($obj_array_room[$i]["amount_student"]);
  if($temp_arr_len>intVal($obj_array_room[$i]["amount_student"]) ){
    if($temp_arr_len-intVal($obj_array_room[$i]["amount_student"])<=3){
      $temp_paging[$i][2] = $page_end+3;
      $page_start =$page_end+3;
      $temp_arr_len -=intVal($obj_array_room[$i]["amount_student"])+3;
    }else{
      $temp_paging[$i][2] = $page_end;
      $page_start =$page_end;
      $temp_arr_len -=intVal($obj_array_room[$i]["amount_student"]);
    }
  }else{
    // echo $temp_arr_len;
    $temp_paging[$i][2] = $page_start+$temp_arr_len;
  }
   $temp_paging[$i][3] = $obj_array_room[$i]["room_name"];
   $temp_paging[$i][4] = $obj_array_room[$i]["contest_name"];
   $temp_paging[$i][5] = $obj_array_room[$i]["education"];
   $temp_paging[$i][6] = $obj_array_room[$i]["type"];
   $temp_paging[$i][7] = $obj_array_room[$i]["code"];
   $temp_paging[$i][8] = $obj_array_room[$i]["date_start"];
   $temp_paging[$i][9] = $obj_array_room[$i]["date_end"];
   
   $page_start =$page_end; 
}
//  var_dump($obj_array_room);
 
// var_dump($temp_paging);
 $header_title[0] ="List of contestants in PCCST ACADEMIC FESTIVAL AND SCIENE FAIR 2018";
 
$arr_len = count($obj_array);
// echo $arr_len;
$page_len = 30;

// for($j=0;$j<count($temp_paging);$j+=1){
//   $start_index = $temp_paging[$j][1];
//   $end_index = $temp_paging[$j][2];
//   // echo $start_index."   ".$end_index."<br>";
//   if($end_index-$start_index<=30) {
//        $pdf->AddPage();
//        $pdf->Cell(0,7,"",0,1,"C");
//        $pdf->Cell(0,5,iconv( 'UTF-8','TIS-620',$header_title[0]),0,1,"C");
//        $pdf->Cell(0,5,iconv( 'UTF-8','cp874//IGNORE',"Subject: ".$temp_paging[$j][7]." ".$temp_paging[$j][4]." ".$temp_paging[$j][5]." ".$temp_paging[$j][6]),0,1,"C");
//        $date_setup = 
//        $temp_paging[$j][8]=="0000-00-00 00:00:00" && $temp_paging[$j][9]=="0000-00-00 00:00:00"?
//         "Not Specified":
//         d_form_str($temp_paging[$j][8],$temp_paging[$j][9]);
//        $pdf->Cell(0,5,iconv( 'UTF-8','TIS-620',"Place: ".$temp_paging[$j][3]." Date: ".$date_setup),0,1,"C");
//        $pdf->Cell(0,7,"",0,1,"C");
//        $pdf->Row($header_table);
//     for($i=$start_index;$i<$end_index;$i++){
//       // echo $i."<br>";
//       if($i<$arr_len)
//        $pdf->Row( array($i+1,iconv( 'UTF-8','TIS-620', $obj_array[$i]["name"]), iconv( 'UTF-8','TIS-620', $obj_array[$i]["display"]), iconv( 'UTF-8','TIS-620', $obj_array[$i]["changwat"]), "__________________"));
//     }
//   }else {
//     $temp_arr_len = $end_index-$start_index; // case 1000 / 35
//     $page_count = intVal($temp_arr_len/$page_len)+1;
//     for($m=0;$m<$page_count;$m++){
//         $pdf->AddPage();
//         $pdf->Cell(0,7,"",0,1,"C");
//         $pdf->Cell(0,5,iconv( 'UTF-8','TIS-620',$header_title[0]),0,1,"C");
//         $pdf->Cell(0,5,iconv( 'UTF-8','TIS-620',"รหัสวิชา ".$temp_paging[$j][7]." ".$temp_paging[$j][4]." ".$temp_paging[$j][5]." ".$temp_paging[$j][6]),0,1,"C");
//         $date_setup = 
//         $temp_paging[$j][8]=="0000-00-00 00:00:00" && $temp_paging[$j][9]=="0000-00-00 00:00:00"?
//           "Not Specified":
//           d_form_str($temp_paging[$j][8],$temp_paging[$j][9]);
//         $pdf->Cell(0,5,iconv( 'UTF-8','TIS-620',"Place: ".$temp_paging[$j][3]." Date: ".$date_setup),0,1,"C");
//         $pdf->Cell(0,7,"",0,1,"C");
//         $pdf->Row($header_table);
//       for($i=$start_index;$i<$start_index+30;$i++){
//         if($i<$arr_len){
//           $pdf->Row( array($i+1,iconv( 'UTF-8','TIS-620', $obj_array[$i]["name"]), iconv( 'UTF-8','TIS-620', $obj_array[$i]["display"]), iconv( 'UTF-8','TIS-620', $obj_array[$i]["changwat"]), "__________________"));
//         }
//       }
//       $start_index+=  30; 
//     }
    
//   }
// }

//
  // echo $start_index."   ".$end_index."<br>";
  // function nextPage($pdf, $temp_paging, $j){
  //   global $header_table, $header_title;

  //      $pdf->Cell(0,7,"",0,1,"C");
  //      $pdf->Cell(0,5,iconv( 'UTF-8','TIS-620',$header_title[0]),0,1,"C");
  //      $pdf->Cell(0,5,iconv( 'UTF-8','cp874//IGNORE',"Subject: ".$temp_paging[$j][7]." ".$temp_paging[$j][4]." ".$temp_paging[$j][5]." ".$temp_paging[$j][6]),0,1,"C");
  //      $date_setup = 
  //      $temp_paging[$j][8]=="0000-00-00 00:00:00" && $temp_paging[$j][9]=="0000-00-00 00:00:00"?
  //       "Not Specified":
  //       d_form_str($temp_paging[$j][8],$temp_paging[$j][9]);
  //      $pdf->Cell(0,5,iconv( 'UTF-8','TIS-620',"Place: ".$temp_paging[$j][3]." Date: ".$date_setup),0,1,"C");
  //      $pdf->Cell(0,7,"",0,1,"C");
  // }   
  // $page_count =0 ;
  // $h=5.75;
  // $char_set = 'cp874//IGNORE';
  // $pdf->AddPage();
  // nextPage($pdf, $temp_paging, $page_count);
  // $pdf->Row($h, $header_table);
  //     for($i=0;$i<count($obj_array);$i++){
      
  //       $data = array(
  //         $i+1,
  //         iconv( 'UTF-8', $char_set, $obj_array[$i]["name"]),
  //         iconv( 'UTF-8', $char_set, $obj_array[$i]["display"]),
  //         iconv( 'UTF-8', $char_set, $obj_array[$i]["changwat"]),
  //          "__________________");
  //       $nb=0;
  //       for($j=0;$j<count($data);$j++)
  //         $nb=max($nb,$pdf->NbLines($pdf->widths[$j],$data[$j]));
  //       $h=5.75*$nb;
  //         //Issue a page break first if needed
  //       if($pdf->CheckPageBreak($h)){
  //         $page_count++;
  //         nextPage($pdf, $temp_paging, $page_count);
  //         $pdf->Row($h, $header_table);
  //       }
  //       $pdf->Row($h, $data);
  //     }
  function nextPage($pdf, $temp_paging, $j){
    global $header_table, $header_title;
    
    $pdf->Cell(0,7,"",0,1,"C");
    $pdf->Cell(0,5,iconv( 'UTF-8','TIS-620',$header_title[0]),0,1,"C");
    $pdf->Cell(0,5,iconv( 'UTF-8','cp874//IGNORE',"Subject: ".$temp_paging[$j][7]." ".$temp_paging[$j][4]." ".$temp_paging[$j][5]." ".$temp_paging[$j][6]),0,1,"C");
    $date_setup = 
    $temp_paging[$j][8]=="0000-00-00 00:00:00" && $temp_paging[$j][9]=="0000-00-00 00:00:00"?
    "Not Specified":
      d_form_str($temp_paging[$j][8],$temp_paging[$j][9]);
      $pdf->Cell(0,5,iconv( 'UTF-8','TIS-620',"Place: ".$temp_paging[$j][3]." Date: ".$date_setup),0,1,"C");
      $pdf->Cell(0,7,"",0,1,"C");
    }   
$char_set = 'cp874//IGNORE';
$h=5.75;
for($j=0;$j<count($temp_paging);$j+=1){
  $start_index = $temp_paging[$j][1];
  $end_index = $temp_paging[$j][2];
  // echo $start_index."   ".$end_index."<br>";
  if($end_index-$start_index<=33) {
       $pdf->AddPage();
       $pdf->Cell(0,7,"",0,1,"C");
       $pdf->Cell(0,5,iconv( 'UTF-8','TIS-620',$header_title[0]),0,1,"C");
       $pdf->Cell(0,5,iconv( 'UTF-8','cp874//IGNORE',"Subject: ".$temp_paging[$j][7]." ".$temp_paging[$j][4]." ".$temp_paging[$j][5]." ".$temp_paging[$j][6]),0,1,"C");
       $date_setup = 
       $temp_paging[$j][8]=="0000-00-00 00:00:00" && $temp_paging[$j][9]=="0000-00-00 00:00:00"?
        "Not Specified":
        d_form_str($temp_paging[$j][8],$temp_paging[$j][9]);
       $pdf->Cell(0,5,iconv( 'UTF-8','TIS-620',"Place: ".$temp_paging[$j][3]." Date: ".$date_setup),0,1,"C");
       $pdf->Cell(0,7,"",0,1,"C");
       $pdf->Row($h, $header_table);
    for($i=$start_index;$i<$end_index;$i++){
      // echo $i."<br>";
      
     
      if($i<$arr_len){
        $data = array(
          $i+1,
          iconv( 'UTF-8', $char_set, $obj_array[$i]["name"]),
          iconv( 'UTF-8', $char_set, $obj_array[$i]["display"]),
          iconv( 'UTF-8', $char_set, $obj_array[$i]["changwat"]),
           "__________________");
        $nb=0;
        for($k=0;$k<count($data);$k++)
          $nb=max($nb,$pdf->NbLines($pdf->widths[$k],$data[$k]));
        $h=5.75*$nb;
          //Issue a page break first if needed
        if($pdf->CheckPageBreak($h)){
          nextPage($pdf, $temp_paging, $j);
          $pdf->Row($h, $header_table);
        }
        $pdf->Row($h, $data);
      }
    }
  }
  else {
    $temp_arr_len = $end_index-$start_index; // case 1000 / 35
    $page_count = intVal($temp_arr_len/$page_len)+1;
    for($m=0;$m<$page_count;$m++){
        $pdf->AddPage();
        $pdf->Cell(0,7,"",0,1,"C");
        $pdf->Cell(0,5,iconv( 'UTF-8','TIS-620',$header_title[0]),0,1,"C");
        $pdf->Cell(0,5,iconv( 'UTF-8','TIS-620',"Subject ".$temp_paging[$j][7]." ".$temp_paging[$j][4]." ".$temp_paging[$j][5]." ".$temp_paging[$j][6]),0,1,"C");
        $date_setup = 
        $temp_paging[$j][8]=="0000-00-00 00:00:00" && $temp_paging[$j][9]=="0000-00-00 00:00:00"?
          "Not Specified":
          d_form_str($temp_paging[$j][8],$temp_paging[$j][9]);
        $pdf->Cell(0,5,iconv( 'UTF-8','TIS-620',"Place: ".$temp_paging[$j][3]." Date: ".$date_setup),0,1,"C");
        $pdf->Cell(0,7,"",0,1,"C");
        $pdf->Row($h, $header_table);
      for($i=$start_index;$i<$start_index+30;$i++){
     
        if($i<$arr_len){
          $data = array(
            $i+1,
            iconv( 'UTF-8', $char_set, $obj_array[$i]["name"]),
            iconv( 'UTF-8', $char_set, $obj_array[$i]["display"]),
            iconv( 'UTF-8', $char_set, $obj_array[$i]["changwat"]),
            "__________________");
        $nb=0;
        for($k=0;$k<count($data);$k++)
          $nb=max($nb,$pdf->NbLines($pdf->widths[$k],$data[$k]));
          $h=5.75*$nb;
            //Issue a page break first if needed
          if($pdf->CheckPageBreak($h)){
            nextPage($pdf, $temp_paging, $j);
            $pdf->Row($h, $header_table);
          }
          $pdf->Row($h,$data);
        }
      }
      $start_index+=  30; 
    }
    
  }
}

  $pdf->Output();
?>
