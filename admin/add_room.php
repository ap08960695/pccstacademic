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
					<h1 class="page-header">สถานทีจัดการแข่งขัน<button type="button" class="btn btn-primary " style="margin-left:10px" onclick="window.location='report_room_excel.php'">EXCEL</button></h1>
				</div>
				<!-- /.col-lg-12 -->
			</div>
			<!-- /.row -->
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							เพิ่มสถานทีจัดการแข่งขัน
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<?php
							if ($_GET['act'] == "success_add") {
								echo "<div class=\"alert alert-success alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "เพิ่มรายการสำเร็จ ";
								echo "</div>";
							} else if ($_GET['act'] == "error_add") {
								echo "<div class=\"alert alert-danger alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "ไม่สามารถเพิ่มรายการได้";
								echo "</div>";
							} else if ($_GET['act'] == "error_empty") {
								echo "<div class=\"alert alert-danger alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "กรุณากรอกข้อมูลให้ครบถ้วน";
								echo "</div>";
							}
							?>
							<form role="form" action="db_add_room.php" method="post" onsubmit="return confirm('คุณต้องการเพิ่มสถานทีนี้ ใช่หรือไม่?');">
								<div class="row">
									<div class="col-md-12 col-lg-12">
										ชื่อสถานที่แข่งขัน <input type="text" name="place_name" class="form-control" value="<?php echo $_SESSION['place_name'] ?>"><br>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 col-lg-12">
										จำนวนการรองรับ <input type="text" name="place_limit" class="form-control" value="<?php echo $_SESSION['place_limit'] ?>"><br>
									</div>
								</div>
								<div class="form-group">
									<input type="submit" class="btn btn-lg btn-success btn-block" value="เพิ่มสถานทีจัดการแข่งขัน">
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							สถานทีจัดการแข่งขัน
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<?php
							if ($_GET['act'] == "success_delete") {
								echo "<div class=\"alert alert-success alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "ลบรายการสำเร็จ";
								echo "</div>";
							} else if ($_GET['act'] == "error_delete") {
								echo "<div class=\"alert alert-danger alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "ลบรายการไม่สำเร็จ";
								echo "</div>";
							}
							?>
							<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>สถานทีจัดการแข่งขัน</th>
										<th>จำนวนการรองรับ</th>
										<th>รายการการแข่งขันที่ใช้สถานที</th>
										<th>ลบ</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sql = "SELECT id,room_name,amount_student FROM room ORDER BY updatetime DESC;";
									$result = mysqli_query($conn, $sql);
									if ($result && mysqli_num_rows($conn, $result) > 0) {
										while ($row = mysqli_fetch_array($result)) {
											echo "<tr class=\"odd gradeX\">";
											echo "    <td>" . $row['room_name'] . "</td>";
											echo "    <td>" . $row['amount_student'] . "</td>";
											echo "<td>";
											$sql = "SELECT contest_code FROM room_contest WHERE room_id=" . $row['id'] . " ORDER BY updatetime DESC;";
											if ($result_room = mysqli_query($conn, $sql)) {
												while ($row_room = mysqli_fetch_array($result_room)) {

													$sql = "SELECT code,contest_name,education,date_start,date_end FROM contest WHERE code=" . $row_room['contest_code'] . " ORDER BY updatetime DESC;";
													$result_contest = mysqli_query($conn, $sql);
													while ($row_contest = mysqli_fetch_array($result_contest)) {
														echo $row_contest['code'] . " " . $row_contest['contest_name'] . "(" . $row_contest['education'] . ")<br>";
													}
												}
											}
											echo "</td>";
											echo "    <td><form role=\"form\" action=\"db_del_room.php\" onsubmit=\"return confirm('คูณต้องการจะลบ " . $row['room_name'] . " ใช่หรือไม่?');\" method=\"post\"><input type=\"hidden\" name=\"code\" value=\"" . $row['id'] . "\"><input type=\"submit\" class=\"btn btn-danger\" value=\"X\"></form></td>";
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