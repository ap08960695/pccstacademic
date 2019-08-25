<?php
session_start();
include_once('../condb.php');
include_once('admin_check.php');

$strExcelFileName = "room.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

$sql = "SELECT id,room_name,amount_student FROM room ORDER BY room_name DESC";
$result = mysqli_query($conn, $sql);
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
	<div id="SiXhEaD_Excel" align=center x:publishsource="Excel">
		<table x:str border=1 cellpadding=0 cellspacing=1 width=100% style="border-collapse:collapse">
			<tr>
				<td width="200" height="30" align="center" valign="middle"><strong>สถานทีแข่งขัน</strong></td>
				<td width="94" align="center" valign="middle"><strong>จำนวนทีรองรับ</strong></td>
				<td width="200" align="center" valign="middle"><strong>รายการการแข่งขัน</strong></td>
				<td width="150" align="center" valign="middle"><strong>วันเวลาเริ่มแข่งขัน</strong></td>
				<td width="150" align="center" valign="middle"><strong>วันเวลาสิ้นสุดการแข่งขัน</strong></td>
			</tr>
			<?php
			while ($row = mysqli_fetch_array($result)) {
				?>
			<?php
				$sql = "SELECT contest_code FROM room_contest WHERE room_id=" . $row['id'] . " ORDER BY updatetime DESC;";
				if ($result_room = mysqli_query($conn, $sql)) {
					while ($row_room = mysqli_fetch_array($result_room)) {
						$sql = "SELECT code,contest_name,education,date_start,date_end FROM contest WHERE code=" . $row_room['contest_code'] . " ORDER BY updatetime DESC;";
						$result_contest = mysqli_query($conn, $sql);
						if ($row_contest = mysqli_fetch_array($result_contest)) {
							echo '<tr>
				<td height="25" align="left" valign="middle" >' . $row['room_name'] . '</td>
				<td align="left" valign="middle" >' . $row['amount_student'] . '</td>';
							echo '<td align="left" valign="middle">' . $row_contest['code'] . ' ' . $row_contest['contest_name'] . '(' . $row_contest['education'] . ')</td>';
							$date = date_format(date_create($row_contest['date_start']), 'd/m/y');
							$start_date = date_format(date_create($row_contest['date_start']), 'H:i');
							$end_date = date_format(date_create($row_contest['date_end']), 'H:i');
							echo '<td align="center" valign="middle">' . $start_date . '</td>';
							echo '<td align="center" valign="middle">' . $end_date . '</td>';
							echo '</tr>';
						}
					}
				} else echo '<tr>
	<td height="25" align="left" valign="middle" >' . $row['room_name'] . '</td>
	<td align="left" valign="middle" >' . $row['amount_student'] . '</td></tr>';

				?>
			<?php
			}
			?>
		</table>
	</div>
	<script>
		window.onbeforeunload = function() {
			return false;
		};
		setTimeout(function() {
			window.close();
		}, 10000);
	</script>
</body>

</html>