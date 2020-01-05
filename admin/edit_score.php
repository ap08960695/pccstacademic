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

	<!-- tagsinput CSS -->
	<link href="../vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">

	<!-- typeahead CSS -->
	<link href="../vendor/typeahead/typeahead.css" rel="stylesheet">

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
					<h1 class="page-header">จัดการผลคะแนน
						<?php
						if (!isset($_GET['s'])) {
							header("location:report_subject.php");
						}

						$sql = "SELECT * FROM contest WHERE code = '" . $_GET['s'] . "'  AND running_year = '$running_year' ";
						$result = mysqli_query_log($conn, $sql);
						$row_contest = mysqli_fetch_array($result);
						echo " <b>" . $row_contest['contest_name'] . "(" . $row_contest['education'] . "," . $row_contest['type'] . ")</b>"
						?>
					</h1>
				</div>
				<!-- /.col-lg-12 -->
			</div>
			<!-- /.row -->
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							เพิ่มรายชื่อผู้เข้าร่วมแข่งขัน
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
							<form role="form" action="db_add_register_contest.php" method="post" onsubmit="return confirm('คุณต้องการเพิ่มผู้เข้าร่วมใหม่ ใช่หรือไม่?');">
								<input type="hidden" name="register_contest" class="form-control" value="<?php echo $_GET['s']; ?>">
								<div class="row">
									<div class="col-md-12 col-lg-12">
										ชื่อผู้เข้าร่วม <input type="text" name="register_name" class="form-control" value=""><br>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 col-lg-12">
										โรงเรียน <input class="form-control" type="text" name='register_school' value="" id="tagsinput" /><br>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 col-lg-12">
										คะแนน <input type="text" name="register_score" class="form-control" value=""><br>
									</div>
								</div>
								<div class="form-group">
									<input type="submit" class="btn btn-lg btn-success btn-block" value="เพิ่มผู้เข้าร่วมการแข่งขัน">
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
							ผลคะแนน
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<?php
							if ($_GET['act'] == "success_update") {
								echo "<div class=\"alert alert-success alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "ปรับปรุงรายการสำเร็จ";
								echo "</div>";
							} else if ($_GET['act'] == "error_update") {
								echo "<div class=\"alert alert-danger alert-dismissable\">";
								echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
								echo "ปรับปรุงรายการไม่สำเร็จ";
								echo "</div>";
							}
							?>
							<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>School code</th>
										<th>Name</th>
										<th>School Name</th>
										<th>Score</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$subject_id = $_GET['s'];
									$sql = "SELECT * FROM register r JOIN school s ON r.school_id = s.code AND s.running_year = '$running_year' WHERE subject_id = '" . $subject_id . "' AND s.status = 1 AND r.status = 1 AND r.running_year = '$running_year' ORDER BY r.score DESC,s.display ASC";
									$result = mysqli_query_log($conn, $sql);
									if ($result && mysqli_num_rows($result) > 0) {
										echo "<form role=\"form\" action=\"db_edit_register_contest.php\" onsubmit=\"return confirm('คุณต้องการจะปรับปรุง ใช่หรือไม่?');\" method=\"post\">";
										while ($row = mysqli_fetch_array($result)) {
											echo "<tr class=\"odd gradeX\">";

											echo "    <td style='width: 100px;'>" . $row['school_id'] . "</td>";
											echo "    <td><input class='form-control' type='text' name='register_name[" . $row[0] . "]' value='" . $row['name'] . "'/></td>";
											echo "    <td>" . $row['display'] . "</td>";
											if ($row['score'] == -1 || $row['score'] == -2) {
												$row['score'] = "";
											}
											echo "    <td style='width: 200px;'><input class='form-control' type='text' name='register_score[" . $row[0] . "]' value='" . $row['score'] . "'/></td>";
											echo "    <td style='width: 10px;'>";
											echo "<a href=\"db_del_register_contest.php?register_contest=" . $subject_id . "&id=" . $row[0] . "\" onclick=\"return confirm('คุณต้องการจะลบ " . $row['name'] . " ใช่หรือไม่?');\" class=\"btn btn-danger\" >X</a>";
											echo "</td>";
											echo "</tr>";
										}
										echo "    <tr><td colspan='5' style='text-align: center;'><input type=\"hidden\" name=\"register_contest\" value=\"" . $subject_id . "\"><input type=\"submit\" class=\"btn btn-success\" style='width:200px' value=\"Update\"></form></td></tr>";
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
	<script src="../vendor/typeahead/handlebars.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

	<!-- Metis Menu Plugin JavaScript -->
	<script src="../vendor/metisMenu/metisMenu.min.js"></script>

	<!-- Custom Theme JavaScript -->
	<script src="../dist/js/sb-admin-2.js"></script>
	<script src="../vendor/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
	<script>
		$(document).ready(function() {
			var school = new Bloodhound({
				datumTokenizer: Bloodhound.tokenizers.obj.whitespace('display'),
				queryTokenizer: Bloodhound.tokenizers.whitespace,
				prefetch: 'db_getschool.php'
			});
			school.clearPrefetchCache();
			school.initialize();
			$('#tagsinput').tagsinput({
				itemValue: 'code',
				itemText: 'display',
				typeaheadjs: {
					name: 'schools',
					displayKey: 'display',
					source: school.ttAdapter(),
					templates: {
						empty: [
							'<div class="row">',
							'<div class="col-lg-12" style="padding: 5px 20px;text-align: center;">',
							'ไม่พบชื่อโรงเรียนในระบบ',
							'</div>',
							'</div>'
						].join('\n'),
						suggestion: Handlebars.compile('<div><strong>{{display}}</strong><div class="limit-student">{{code}}</div></div>')
					}
				}
			});
			$(".bootstrap-tagsinput").addClass('form-control');
		});
	</script>
</body>

</html>