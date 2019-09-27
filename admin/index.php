<?php
session_start();
include_once('../condb.php');
include_once('admin_check.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>ระบบจัดการการแข่งขัง</title>

	<!-- Bootstrap Core CSS -->
	<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- MetisMenu CSS -->
	<link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="../dist/css/sb-admin-2.css" rel="stylesheet">

	<!-- Custom Fonts -->
	<link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>
	<div id="wrapper">

		<!-- Navigation -->
		<?php
		include_once("nav_admin.html");
		?>


		<!-- Page Content -->
		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">รายการชื่อโรงเรียนที่เข้าร่วม<button type="button" class="btn btn-primary " style="margin-left:10px" onclick="window.location='report_school_excel.php'">EXCEL</button> </h1>
				</div>
				<!-- /.col-lg-12 -->
			</div>
			<!-- /.row -->
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							รายชื่อโรงเรียนทั้งหมด
							<button type="button" class="btn btn-info btn-xs" onclick="window.location='index.php'">โรงเรียนทั้งหมด</button>
							<button type="button" class="btn btn-success btn-xs" onclick="window.location='index.php?view=success'">ยืนยันแล้ว</button>
							<button type="button" class="btn btn-warning btn-xs" onclick="window.location='index.php?view=danger'">ยังไม่ยืนยัน</button>
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<?php
							if ($_GET['act'] == "success_edit_school") {
								echo "<div class=\"alert alert-success alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "การแก้ไขสำเร็จ";
								echo "</div>";
							} else if ($_GET['act'] == "success_approved") {
								echo "<div class=\"alert alert-success alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "การยืนยันเสร็จสิ้น ";
								echo "</div>";
							} else if ($_GET['act'] == "success_code") {
								echo "<div class=\"alert alert-success alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "เพิ่ม Code สำเร็จ";
								echo "</div>";
							} else if ($_GET['act'] == "success_delete") {
								echo "<div class=\"alert alert-success alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "ลบข้อมูลสำเร็จ";
								echo "</div>";
							} else if ($_GET['act'] == "success_update") {
								echo "<div class=\"alert alert-success alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "ปรับปรุงข้อมูลสำเร็จ";
								echo "</div>";
							}
							if ($_GET['act'] == "error_approved") {
								echo "<div class=\"alert alert-danger alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "ไม่สามารถยืนยันได้";
								echo "</div>";
							} else if ($_GET['act'] == "error_code") {
								echo "<div class=\"alert alert-danger alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "ไม่สามารถเพิ่ม Code";
								echo "</div>";
							} else if ($_GET['act'] == "error_delete") {
								echo "<div class=\"alert alert-danger alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "ลบข้อมูลไม่สำเร็จ";
								echo "</div>";
							} else if ($_GET['act'] == "error_update") {
								echo "<div class=\"alert alert-danger alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "ปรับปรุงข้อมูลไม่สำเร็จ";
								echo "</div>";
							}
							?>
							<table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th></th>
										<th>code</th>
										<th>ชื่อโรงเรียน
											<?php
											$sql = "SELECT group_name FROM contest_group WHERE running_year='$running_year' GROUP BY group_name ORDER BY updatetime ASC;";
											$result_group = mysqli_query_log($conn, $sql);
											if ($result_group && mysqli_num_rows($result) > 0) {
												while ($row_group = mysqli_fetch_array($result_group)) {
													echo '<button type="button" class="btn btn-warning btn-xs" style="margin-left: 10px;" onclick="window.location=\'db_updateallschool.php?group=' . $row_group['group_name'] . '\'">ยืนยันทั้งหมด กลุ่ม' . $row_group['group_name'] . ' </button>';
												}
											}
											?>
										</th>
										<th>ชื่อผู้ใช้งาน</th>
										<th>รหัสผ่านใช้งาน</th>
										<th>กลุ่มรายการแข่งขัน</th>
										<th>E-mail</th>
										<th>City</th>
										<th>Province</th>
										<th>Zipcode</th>
										<th>Phone</th>
										<th>Country</th>
										<th>ลบ</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if (isset($_GET['view'])) {
										if ($_GET['view'] == 'success') {
											$sql = "SELECT * FROM school WHERE running_year = '$running_year' AND status=1 ORDER BY u_date DESC;";
										} else if ($_GET['view'] == 'danger') {
											$sql = "SELECT * FROM school WHERE running_year = '$running_year' AND status=0 ORDER BY u_date DESC;";
										} else $sql = "SELECT * FROM school WHERE running_year = '$running_year' ORDER BY status ASC,u_date DESC;";
									} else $sql = "SELECT * FROM school WHERE running_year = '$running_year' ORDER BY status ASC,u_date DESC;";
									$result = mysqli_query_log($conn, $sql);
									if (mysqli_num_rows($result) > 0) {
										$i = 1;
										while ($row = mysqli_fetch_array($result)) {
											echo "<tr class=\"odd gradeX\">";
											echo "    <td>" . ($i++) . "</td>";
											echo "    <td>" . $row['code'];
											if ($row['code'] != "") {
												echo "<button type='button' style='margin-right: 4px;' class='btn btn-primary btn-xs' onclick='window.location=\"edit_school.php?code=" . $row['code'] . "\"' >EDIT</button></td>";
											}
											echo "    <td>";
											$sql = "SELECT group_name FROM contest_group WHERE running_year = '$running_year' GROUP BY group_name ORDER BY updatetime ASC;";
											$result_group = mysqli_query_log($conn, $sql);
											if ($result_group && mysqli_num_rows($result) > 0) {
												echo $row['display'] . "<label style='margin-left: 10px;'></label>";
												while ($row_group = mysqli_fetch_array($result_group)) {
													if ($row['status'] == 0) {
														echo "<button type='button' style='margin-right: 4px;' class='btn btn-warning btn-xs' onclick='window.location=\"db_update_school.php?user=" . $row['user'] . "&group=" . $row_group['group_name'] . "\"' >ยืนยัน กลุ่ม" . $row_group['group_name'] . " </button>";
													} else if ($row['group_contest'] != $row_group['group_name']) echo "<button type='button' style='margin-right: 4px;' class='btn btn-success btn-xs' onclick='window.location=\"db_change_school_group_contest.php?user=" . $row['user'] . "&group=" . $row_group['group_name'] . "\"' >เปลี่ยนกลุ่ม" . $row_group['group_name'] . " </button>";
												}
											} else {
												if ($row['status'] == 0) {
													echo $row['display'] . "<label style='margin-left: 10px;'></label>";
													echo "<button type='button' style='margin-right: 4px;' class='btn btn-warning btn-xs' onclick='window.location=\"db_update_school.php?user=" . $row['user'] . "\"' >ยืนยัน </button>";
												} else echo $row['display'];
											}
											echo "</td>";
											echo "    <td>" . $row['user'] . "</td>";
											echo "    <td>" . $row['pass'] . "</td>";
											echo "    <td>" . $row['group_contest'] . "</td>";
											echo "    <td>" . $row['email'] . "</td>";
											echo "    <td>" . $row['amper'] . "</td>";
											echo "    <td>" . $row['changwat'] . "</td>";
											echo "    <td>" . $row['addrcode'] . "</td>";
											echo "    <td>" . $row['phone'] . "</td>";
											echo "    <td>" . $row['country'] . "</td>";
											echo "    <td><form role=\"form\" action=\"db_del_school.php\" onsubmit=\"return confirm('คูณต้องการจะลบ " . $row['display'] . " ใช่หรือไม่?');\" method=\"post\"><input type=\"hidden\" name=\"code\" value=\"" . $row['code'] . "\"><input type=\"hidden\" name=\"user\" value=\"" . $row['user'] . "\"><input type=\"submit\" class=\"btn btn-danger\" value=\"X\"></form></td>";
											echo "</tr>";
										}
									}
									?>
								</tbody>
							</table>
							<!-- /.table-responsive -->



						</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
				</div>
				<!-- /.col-lg-12 -->

			</div>
			<!-- /.row -->
		</div>
		<!-- /#page-wrapper -->

	</div>
	<!-- /#wrapper -->

	<script>
		function checkFilled(inputVal) {
			if (inputVal.value == "") {
				inputVal.style.backgroundColor = "#FFFFFF";
			} else {
				inputVal.style.backgroundColor = "#FFFF99";
			}
		}
	</script>

	<!-- jQuery -->
	<script src="../vendor/jquery/jquery.min.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

	<!-- Metis Menu Plugin JavaScript -->
	<script src="../vendor/metisMenu/metisMenu.min.js"></script>

	<!-- Custom Theme JavaScript -->
	<script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>