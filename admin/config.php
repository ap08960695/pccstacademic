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

	<!-- Checkbox Group CSS -->
	<link href="../vendor/checkbox-group/checkbox-group.css" rel="stylesheet">

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
					<h1 class="page-header">จัดการการแข่ง </h1>
				</div>
				<!-- /.col-lg-12 -->
			</div>
			<!-- /.row -->
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							ตั้งต่าผู้ใช้ admin
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<?php
							if ($_GET['act'] == "success_update") {
								echo "<div class=\"alert alert-success alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "ปรับปรุงสำเร็จ ";
								echo "</div>";
							} else if ($_GET['act'] == "error_update_pass") {
								echo "<div class=\"alert alert-danger alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "ไม่สามารถปรับปรุงรหัสผ่านได้";
								echo "</div>";
							} else if ($_GET['act'] == "error_empty") {
								echo "<div class=\"alert alert-danger alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "กรุณากรอกข้อมูลให้ครบถ้วน";
								echo "</div>";
							} else if ($_GET['act'] == "error_pass_same") {
								echo "<div class=\"alert alert-danger alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "ไม่สามารถปรับปรุงได้ รหัสไม่เหมือนกันแล้ว";
								echo "</div>";
							} else if ($_GET['act'] == "error_update_user") {
								echo "<div class=\"alert alert-success alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "ไม่สามารถปรับปรุงชื่อผู้ใช้งานได้ ";
								echo "</div>";
							}
							?>
							<form role="form" action="db_edit_admin.php" method="post" onsubmit="return confirm('คุณต้องการปรับปรุงadmin ใช่หรือไม่?');">
								<div class="row">
									<div class="col-md-12 col-lg-12">
										ชื่อผู้ใช้ admin <input type="text" name="username" class="form-control" value="<?php echo $_SESSION['username'] ?>"><br>
									</div>
									<div class="col-md-12 col-lg-12">
										รหัสผ่าน <input type="password" name="password" class="form-control" value=""><br>
									</div>
									<div class="col-md-12 col-lg-12">
										ยืนยันรหัสผ่าน <input type="password" name="password_confire" class="form-control" value=""><br>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 col-lg-12">
										<input type="submit" class="btn btn-lg btn-success btn-block" value="ปรับปรุง">
									</div>
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
							ตั้งค่าโรงเรียน
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<?php
							if ($_GET['act'] == "success_update_role") {
								echo "<div class=\"alert alert-success alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "ปรับปรุงสำเร็จ ";
								echo "</div>";
							} else if ($_GET['act'] == "error_empty_role") {
								echo "<div class=\"alert alert-danger alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "กรุณากรอกข้อมูลให้ครบถ้วน";
								echo "</div>";
							} else if ($_GET['act'] == "error_update_role") {
								echo "<div class=\"alert alert-danger alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "ไม่สามารถปรับปรุงได้";
								echo "</div>";
							}
							?>
							<form role="form" action="db_role_school.php" method="post" onsubmit="return confirm('คุณต้องการปรับปรุงการทำงานของ school ใช่หรือไม่?');">
								<div class="form-group">
									<label for="school_option">ตั้งค่าการใช้งานของ school</label>
									<?php
									$sql = "SELECT value FROM config WHERE meta='schoolRole'";
									$result = mysqli_query($conn, $sql);
									if ($result) {
										$row = mysqli_fetch_array($result);
									}
									?>
									<select name="school_option" id="school_option" class="form-control">
										<option value="1" <?php if ($row['value'] == "all") echo "selected"; ?>>ตั้งค่าแก้ไขและลงทะเบียนเพิ่มได้</option>
										<option value="2" <?php if ($row['value'] == "edit") echo "selected"; ?>>ตั้งค่าแก้ไข</option>
										<option value="3" <?php if ($row['value'] == "view") echo "selected"; ?>>ตั้งค่าดูได้อย่างเดียว</option>
									</select>
								</div>
								<div class="row">
									<div class="col-md-12 col-lg-12">
										<input type="submit" class="btn btn-lg btn-success btn-block" value="ปรับปรุง">
									</div>
								</div>
							</form>
						</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
				</div>
				<!-- /.col-lg-12 -->

			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							ปีการศึกษาที่กำลังดำเนินการ
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<?php
							if ($_GET['act'] == "success_update_running") {
								echo "<div class=\"alert alert-success alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "ปรับปรุงสำเร็จ ";
								echo "</div>";
							} else if ($_GET['act'] == "error_update_running") {
								echo "<div class=\"alert alert-danger alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "ไม่สามารถปรับปรุงได้";
								echo "</div>";
							}
							?>
							<form role="form" action="db_running_year.php" method="post" onsubmit="return confirm('คุณต้องการปรับปรุงปีการศึกษาที่เริ่มดำเนินการ ใช่หรือไม่?');">
								<div class="form-group">
									<label for="running_option">ตั้งค่าปีที่กำลังดำเนินงาน</label>
									<?php
									$sql = "SELECT value FROM config WHERE meta='runningYear'";
									$result = mysqli_query($conn, $sql);
									if ($result) {
										$row = mysqli_fetch_array($result);
									}
									?>
									<select name="running_option" id="running_option" class="form-control">
										<?php
										for ($year = date("Y"); $year >= date("Y") - 6; $year--) {
											echo '<option value="' . $year . '"';
											if ($row['value'] == $year)
												echo "selected";
											echo '>' . $year . '</option>';
										}
										?>
									</select>
								</div>
								<div class="row">
									<div class="col-md-12 col-lg-12">
										<input type="submit" class="btn btn-lg btn-success btn-block" value="ปรับปรุง">
									</div>
								</div>
							</form>
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

	<!-- Checkbox Group JS -->
	<script src="../vendor/checkbox-group/checkbox-group.js"></script>

	<!-- Metis Menu Plugin JavaScript -->
	<script src="../vendor/metisMenu/metisMenu.min.js"></script>

	<!-- Custom Theme JavaScript -->
	<script src="../dist/js/sb-admin-2.js"></script>

</body>
<script>
	var checkedItems = {},
		counter = 0;

	function getcheckbox() {
		var checkbox = $(".list-group li.active");
		var list = "";
		for (var i = 0; i < checkbox.length; i++) {
			list += $(checkbox[i]).attr("code") + ",";
		}
		list = list.substring(0, list.length - 1);
		return list;
	}

	function sentform() {
		$("#contest_list").val(getcheckbox());
		$('#form_contest').submit();
	}
</script>

</html>