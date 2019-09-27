<?php
session_start();
include_once('../condb.php');
include_once('admin_check.php');

$strExcelFileName = "SchoolAll.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

$sql = mysqli_query_log($conn, "SELECT code,display,email,phone,amper,changwat,addrcode,status FROM school AND running_year = '$running_year' ORDER BY u_date DESC;");
$num = mysqli_num_rows($sql);
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">

<!DOCTYPE html PUBLIC "-//W	3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
	<div id="SiXhEaD_Excel" align=center x:publishsource="Excel">
		<table x:str border=1 cellpadding=0 cellspacing=1 width=100% style="border-collapse:collapse">
			<tr>
				<td width="94" height="30" align="center" valign="middle"><strong>รหัส</strong></td>
				<td width="200" align="center" valign="middle"><strong>ชื่อโรงเรียน</strong></td>
				<td width="181" align="center" valign="middle"><strong>E-mail</strong></td>
				<td width="181" align="center" valign="middle"><strong>เบอร์ติดต่อ</strong></td>
				<td width="181" align="center" valign="middle"><strong>อำเภอ</strong></td>
				<td width="181" align="center" valign="middle"><strong>จังหวัด</strong></td>
				<td width="185" align="center" valign="middle"><strong>รหัสไปรษณี</strong></td>
				<td width="185" align="center" valign="middle"><strong>สถานะ</strong></td>
			</tr>
			<?php
			if ($num > 0) {
				while ($row = mysqli_fetch_array($sql)) {
					?>
			<tr>
				<td height="25" align="left" valign="middle"><?php echo $row['code']; ?></td>
				<td align="left" valign="middle"><?php echo $row['display']; ?></td>
				<td align="left" valign="middle"><?php echo $row['email']; ?></td>
				<td align="left" valign="middle"><?php echo $row['phone']; ?></td>
				<td align="left" valign="middle"><?php echo $row['amper']; ?></td>
				<td align="left" valign="middle"><?php echo $row['changwat']; ?></td>
				<td align="left" valign="middle"><?php echo $row['addrcode']; ?></td>
				<?php
						if ($row['status'] == 1) {
							echo '<td align="left" valign="middle" bgcolor="#CCFF90">ยืนยันการลงทะเบียน</td>';
						} else {
							echo '<td align="left" valign="middle" bgcolor="#E57373">ยังไม่ยืนยันการลงทะเบียน</td>';
						}
						?>
			</tr>
			<?php
				}
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