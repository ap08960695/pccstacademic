<?php
session_start();
include_once('../condb.php');
include_once('admin_check.php');
$upOne = realpath(__DIR__ . '/..');
require($upOne . '/pccstcer/fpdf.php');
define('FPDF_FONTPATH', 'font/');

class PDF extends FPDF
{
  var $widths;
  var $aligns;

  function SetWidths($w)
  {
    //Set the array of column widths
    $this->widths = $w;
  }

  function SetAligns($a)
  {
    //Set the array of column alignments
    $this->aligns = $a;
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
    for ($i = 0; $i < count($data); $i++) {
      $w = $this->widths[$i];
      $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
      //Save the current position
      $x = $this->GetX();
      $y = $this->GetY();
      //Draw the border
      $this->Rect($x, $y, $w, $h);
      //Print the text
      $this->MultiCell($w, 5.5, $data[$i], 0, $a);
      //Put the position to the right of the cell
      $this->SetXY($x + $w, $y);
    }
    //Go to the next line
    $this->Ln($h);
  }

  function CheckPageBreak($h)
  {
    //If the height h would cause an overflow, add a new page immediately
    if ($this->GetY() + $h > $this->PageBreakTrigger) {
      $this->AddPage($this->CurOrientation);
      return true;
    } else {
      return false;
    }
  }

  function NbLines($w, $txt)
  {
    //Computes the number of lines a MultiCell of width w will take
    $cw = &$this->CurrentFont['cw'];
    if ($w == 0)
      $w = $this->w - $this->rMargin - $this->x;
    $wmax = ($w - 1.5 * $this->cMargin) * 1000 / $this->FontSize;
    $s = str_replace("\r", '', $txt);
    $nb = strlen($s);
    if ($nb > 0 and $s[$nb - 1] == "\n")
      $nb--;
    $sep = -1;
    $i = 0;
    $j = 0;
    $l = 0;
    $nl = 1;
    while ($i < $nb) {
      $c = $s[$i];
      if ($c == "\n") {
        $i++;
        $sep = -1;
        $j = $i;
        $l = 0;
        $nl++;
        continue;
      }
      if ($c == ' ')
        $sep = $i;
      $l += $cw[$c];
      if ($l > $wmax) {
        if ($sep == -1) {
          if ($i == $j)
            $i++;
        } else
          $i = $sep + 1;
        $sep = -1;
        $j = $i;
        $l = 0;
        $nl++;
      } else
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
    foreach ($lines as $line)
      $data[] = explode(';', trim($line));
    return $data;
  }

  // Simple table
  function BasicTable($header, $data)
  {
    // Header
    foreach ($header as $col)
      $this->Cell(40, 7, $col, 1);
    $this->Ln();
    // Data
    foreach ($data as $row) {
      foreach ($row as $col)
        $this->Cell(40, 6, $col, 1);
      $this->Ln();
    }
  }


  function getUTF($data)
  {
    return iconv('UTF-8', 'TIS-620', $data);
  }

  function cutOffString($data)
  {
    if (strlen($data) > 46) {
      $fore = substr($data, 0, 46);
      $end = substr($data, 47, strlen($data));
      return $fore . "\n\t" . $end;
    } else return $data;
  }

  // Colored table

}

function d_form_str($d_start, $d_end)
{
  $date = date_format(date_create($d_start), 'd F Y'); //case 1 day 
  $time_start = date_format(date_create($d_start), 'H:i');
  $time_end = date_format(date_create($d_end), 'H:i');

  return $date . " " . $time_start . " - " . $time_end;
}

if (isset($_GET["s"])) {
  $subject_id = $_GET["s"];
}
$sql = "SELECT * FROM room_contest INNER JOIN contest ON contest.running_year = '$running_year' AND contest.code=room_contest.contest_code WHERE room_contest.contest_code='" . $subject_id . "' AND room_contest.running_year = '$running_year'";
$result = mysqli_query_log($conn, $sql);;
$obj_array_room = [];
if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    array_push($obj_array_room, $row);
  }
}
if (!$obj_array_room) echo "<script> alert('Please assign room to contest');</script>";
$header = [];
$sql = "  SELECT * FROM register, school WHERE register.running_year = '$running_year' AND school.running_year = '$running_year' AND register.school_id=school.code AND register.subject_id='" . $subject_id . "' ORDER BY school.id ASC";
if ($student_result = mysqli_query_log($conn, $sql)) {
  $obj_array = [];
  while ($row = mysqli_fetch_assoc($student_result)) {
    array_push($obj_array, $row);
  }
} else {
  echo "err";
}

$sql = "  SELECT * FROM register_teacher, school WHERE register_teacher.running_year = '$running_year' AND school.running_year = '$running_year' AND  register_teacher.school_id=school.code AND register_teacher.subject_id='" . $subject_id . "' ORDER BY school.id ASC";
if ($teacher_result = mysqli_query_log($conn, $sql)) {
  $obj_array_t = [];
  while ($row = mysqli_fetch_assoc($teacher_result)) {
    array_push($obj_array_t, $row);
  }
} else {
  echo "err";
}
$header_table = array('No.', 'Name', 'School', 'Province', 'Score', 'Signature');

$pdf = new PDF('P', 'mm', 'A4');
$pdf->AddFont('Angsana', '', 'angsa.php');
$pdf->SetFont('Angsana', '', 14);
$pdf->SetWidths(array(8, 48, 55, 15, 10, 62));
$page_start = 0;
$page_end = 0;
$temp_arr_len = count($obj_array);
for ($i = 0; $i < count($obj_array_room); $i += 1) {
  $temp_paging[$i][0] = intVal($obj_array_room[$i]["amount_student"]);
  $temp_paging[$i][1] = $page_start;
  $page_end += intVal($obj_array_room[$i]["amount_student"]);
  if ($temp_arr_len > intVal($obj_array_room[$i]["amount_student"])) {
    if ($temp_arr_len - intVal($obj_array_room[$i]["amount_student"]) <= 3) {
      $temp_paging[$i][2] = $page_end + 3;
      $page_start = $page_end + 3;
      $temp_arr_len -= intVal($obj_array_room[$i]["amount_student"]) + 3;
    } else {
      $temp_paging[$i][2] = $page_end;
      $page_start = $page_end;
      $temp_arr_len -= intVal($obj_array_room[$i]["amount_student"]);
    }
  } else {
    // echo $temp_arr_len;
    $temp_paging[$i][2] = $page_start + $temp_arr_len;
  }
  $temp_paging[$i][3] = $obj_array_room[$i]["room_name"];
  $temp_paging[$i][4] = $obj_array_room[$i]["contest_name"];
  $temp_paging[$i][5] = $obj_array_room[$i]["education"];
  $temp_paging[$i][6] = $obj_array_room[$i]["type"];
  $temp_paging[$i][7] = $obj_array_room[$i]["code"];
  $temp_paging[$i][8] = $obj_array_room[$i]["date_start"];
  $temp_paging[$i][9] = $obj_array_room[$i]["date_end"];

  $page_start = $page_end;
}
//  var_dump($obj_array_room);

// var_dump($temp_paging);
$header_title[0] = "List of contestants in PCSHSST ACADEMIC FESTIVAL AND SCIENE FAIR " . $running_year;

$arr_len = count($obj_array);
// echo $arr_len;
function WritePage1($pdf, $j, $header_title, $temp_paging, $header_table, $start_index, $end_index, $arr_len, $char_set, $obj_array)
{
  $pdf->AddPage();
  $pdf->Cell(0, 7, "", 0, 1, "C");
  $pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $header_title[0]), 0, 1, "C");
  $pdf->Cell(0, 5, iconv('UTF-8', 'cp874//IGNORE', "Subject: " . $temp_paging[$j][7] . " " . $temp_paging[$j][4] . " " . $temp_paging[$j][5] . " " . $temp_paging[$j][6]), 0, 1, "C");
  $date_setup =
    $temp_paging[$j][8] == "0000-00-00 00:00:00" && $temp_paging[$j][9] == "0000-00-00 00:00:00" ?
    "Not Specified" : d_form_str($temp_paging[$j][8], $temp_paging[$j][9]);
  $pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', "Place: " . $temp_paging[$j][3] . " Date: " . $date_setup), 0, 1, "C");
  $pdf->Cell(0, 7, "", 0, 1, "C");
  $h = 5.75;
  $pdf->Row($h, $header_table);
  for ($i = $start_index; $i < $end_index; $i++) {
    if ($i < $arr_len) {
      $data = array(
        $i + 1,
        iconv('UTF-8', $char_set, $obj_array[$i]["name"]),
        iconv('UTF-8', $char_set, $obj_array[$i]["display"]),
        iconv('UTF-8', $char_set, $obj_array[$i]["changwat"]),
        "",
        ""
      );
      $nb = 0;
      for ($k = 0; $k < count($data); $k++)
        $nb = max($nb, $pdf->NbLines($pdf->widths[$k], $data[$k]));
      $h = 5.75 * $nb;
      //Issue a page break first if needed
      if ($pdf->CheckPageBreak($h)) {
        nextPage($pdf, $temp_paging, $j);
        $pdf->Row($h, $header_table);
      }
      $pdf->Row($h, $data);
    }
  }
}
function WritePage2($pdf, $j, $header_title, $temp_paging, $header_table, $start_index, $end_index, $arr_len, $char_set, $obj_array)
{
  $page_len = 30;
  $temp_arr_len = $end_index - $start_index; // case 1000 / 35
  $page_count = intVal($temp_arr_len / $page_len) + 1;
  for ($m = 0; $m < $page_count; $m++) {
    $pdf->AddPage();
    $pdf->Cell(0, 7, "", 0, 1, "C");
    $pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $header_title[0]), 0, 1, "C");
    $pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', "Subject " . $temp_paging[$j][7] . " " . $temp_paging[$j][4] . " " . $temp_paging[$j][5] . " " . $temp_paging[$j][6]), 0, 1, "C");
    $date_setup =
      $temp_paging[$j][8] == "0000-00-00 00:00:00" && $temp_paging[$j][9] == "0000-00-00 00:00:00" ?
      "Not Specified" : d_form_str($temp_paging[$j][8], $temp_paging[$j][9]);
    $pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', "Place: " . $temp_paging[$j][3] . " Date: " . $date_setup), 0, 1, "C");
    $pdf->Cell(0, 7, "", 0, 1, "C");
    $h = 5.75;
    $pdf->Row($h, $header_table);
    for ($i = $start_index; $i < $start_index + 30; $i++) {

      if ($i < $arr_len) {
        $data = array(
          $i + 1,
          iconv('UTF-8', $char_set, $obj_array[$i]["name"]),
          iconv('UTF-8', $char_set, $obj_array[$i]["display"]),
          iconv('UTF-8', $char_set, $obj_array[$i]["changwat"]),
          "",
          ""
        );
        $nb = 0;
        for ($k = 0; $k < count($data); $k++)
          $nb = max($nb, $pdf->NbLines($pdf->widths[$k], $data[$k]));
        $h = 5.75 * $nb;
        //Issue a page break first if needed
        if ($pdf->CheckPageBreak($h)) {
          nextPage($pdf, $temp_paging, $j);
          $pdf->Row($h, $header_table);
        }
        $pdf->Row($h, $data);
      }
    }
    $start_index +=  30;
  }
}
function nextPage($pdf, $temp_paging, $j)
{
  global $header_title;

  $pdf->Cell(0, 7, "", 0, 1, "C");
  $pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $header_title[0]), 0, 1, "C");
  $pdf->Cell(0, 5, iconv('UTF-8', 'cp874//IGNORE', "Subject: " . $temp_paging[$j][7] . " " . $temp_paging[$j][4] . " " . $temp_paging[$j][5] . " " . $temp_paging[$j][6]), 0, 1, "C");
  $date_setup =
    $temp_paging[$j][8] == "0000-00-00 00:00:00" && $temp_paging[$j][9] == "0000-00-00 00:00:00" ?
    "Not Specified" : d_form_str($temp_paging[$j][8], $temp_paging[$j][9]);
  $pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', "Place: " . $temp_paging[$j][3] . " Date: " . $date_setup), 0, 1, "C");
  $pdf->Cell(0, 7, "", 0, 1, "C");
}
$char_set = 'cp874//IGNORE';
for ($j = 0; $j < count($temp_paging); $j += 1) {
  $start_index = $temp_paging[$j][1];
  $end_index = $temp_paging[$j][2];
  // echo $start_index."   ".$end_index."<br>";
  if ($end_index - $start_index <= 33) {
    WritePage1($pdf, $j, $header_title, $temp_paging, $header_table, $start_index, $end_index, $arr_len, $char_set, $obj_array);
  } else {
    WritePage2($pdf, $j, $header_title, $temp_paging, $header_table, $start_index, $end_index, $arr_len, $char_set, $obj_array);
  }
}

$pdf->Output();
