<?php
	session_start();
    include_once('../condb.php');
    date_default_timezone_set('Asia/Bangkok');
    $sql = "SELECT meta FROM config WHERE meta='userAdmin' AND value='".md5($_SESSION['user'])."'";
    $result = mysql_query($sql);
	  if(mysql_num_rows($result)!=1){
		header("Location: ../login.php");
		exit();
	  }
	$strExcelFileName="room.xls";
	header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
	header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
	header("Pragma:no-cache");
	
	$sql = "SELECT id,room_name,amount_student FROM room ORDER BY updatetime DESC";
	$result = mysql_query($sql);
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"xmlns:x="urn:schemas-microsoft-com:office:excel"xmlns="http://www.w3.org/TR/REC-html40">
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<div id="SiXhEaD_Excel" align=center x:publishsource="Excel">
<table x:str border=1 cellpadding=0 cellspacing=1 width=100% style="border-collapse:collapse">
<tr>
<td width="200" height="30" align="center" valign="middle" ><strong>สถานทีแข่งขัน</strong></td>
<td width="94" align="center" valign="middle" ><strong>จำนวนทีรองรับ</strong></td>
<td width="200" align="center" valign="middle" ><strong>รายการการแข่งขัน</strong></td>
<td width="150" align="center" valign="middle" ><strong>วันเวลาเริ่มแข่งขัน</strong></td>
<td width="150" align="center" valign="middle" ><strong>วันเวลาสิ้นสุดการแข่งขัน</strong></td>
</tr>
<?php
while($row=mysql_fetch_array($result)){
?>
<tr>
<td height="25" align="left" valign="middle" ><?php echo $row['room_name'];?></td>
<td align="left" valign="middle" ><?php echo $row['amount_student'];?></td>
<?php
	$sql = "SELECT contest.code,contest.contest_name,contest.education,contest.date_start,contest.date_end FROM room_contest INNER JOIN contest ON room_contest.contest_code=contest.code WHERE room_contest.room_id=".$row['id']." ORDER BY contest.date_start,contest.date_end ASC;";
	$result_contest = mysql_query($sql ,$conn);
	if ($result_contest) {
		if($row_contest = mysql_fetch_array($result_contest)) {
			echo '<td align="left" valign="middle">'.$row_contest['code'].' '.$row_contest['contest_name'].'('.$row_contest['education'].')</td>';
			$start_date = date_format(date_create($row_contest['date_start']), 'd/m/Y H:i');
			$end_date = date_format(date_create($row_contest['date_end']), 'd/m/Y H:i');
			echo '<td align="center" valign="middle">'.$start_date.'</td>';
			echo '<td align="center" valign="middle">'.$end_date.'</td>';
			echo '</tr>';
			while($row_contest = mysql_fetch_array($result_contest)){
				echo '<tr>';
				echo '<td></td>';
				echo '<td></td>';
				echo '<td align="left" valign="middle">'.$row_contest['code'].' '.$row_contest['contest_name'].'('.$row_contest['education'].')</td>';	
				$start_date = date_format(date_create($row_contest['date_start']), 'd/m/Y H:i');
				$end_date = date_format(date_create($row_contest['date_end']), 'd/m/Y H:i');
				echo '<td align="center" valign="middle">'.$start_date.'</td>';
				echo '<td align="center" valign="middle">'.$end_date.'</td>';
				echo '</tr>';
			}
		}else echo '</tr>';
	}
		
?>
<?php
}
?>
</table>
</div>
<script>
window.onbeforeunload = function(){return false;};
setTimeout(function(){window.close();}, 10000);
</script>
</body>
</html>