<?php
    session_start();
    include_once('../condb.php');
    date_default_timezone_set('Asia/Bangkok');
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
    <link href="../vendor/bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

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
                  <h1 class="page-header">จัดการการแข่ง </h1>
              </div>
              <!-- /.col-lg-12 -->
          </div>
          <!-- /.row -->
          <div class="row">
              <div class="col-lg-12">
                  <div class="panel panel-default">
						<div class="panel-heading">
							เพิ่มรายการแข่งขัน
						</div>
                      <!-- /.panel-heading -->
						<div class="panel-body">
						<?php 
							if($_GET['act']=="success_add"){
									echo"<div class=\"alert alert-success alert-dismissable\">";
									echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
									echo"เพิ่มรายการสำเร็จ ";
									echo"</div>";
							}else if($_GET['act']=="error_add"){
									echo"<div class=\"alert alert-danger alert-dismissable\">";
									echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
									echo"ไม่สามารถเพิ่มรายการได้";
									echo"</div>";
							}else if($_GET['act']=="error_empty"){
									echo"<div class=\"alert alert-danger alert-dismissable\">";
									echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
									echo"กรุณากรอกข้อมูลให้ครบถ้วน";
									echo"</div>";
							}else if($_GET['act']=="error_add_same"){
									echo"<div class=\"alert alert-danger alert-dismissable\">";
									echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
									echo"ไม่สามารถเพิ่มรายการได้ รหัสถูกใช้แล้ว";
									echo"</div>";
							}else if($_GET['act']=="success_edit"){
									echo"<div class=\"alert alert-success alert-dismissable\">";
									echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
									echo"แก้ไขรายการสำเร็จ ";
									echo"</div>";
							}
						?>
						<form role="form" action="db_add_contest.php" method="post" onsubmit="return confirm('คุณต้องการเพิ่มรายการแข่งขันนี้ ใช่หรือไม่?');">
							<div class="row">
								<div class="col-md-4 col-lg-2">
									รหัสการแข่งขัน  <input type="text" name="contest_code" class="form-control" value="<?php echo $_SESSION['contest_code']?>"><br>
								</div>
								<div class="col-md-8 col-lg-5">
									ชื่อรายการแข่งขัน  <input type="text" name="contest_name" class="form-control" value="<?php echo $_SESSION['contest_name']?>"><br>
								</div>
								<div class="col-md-6 col-lg-3">
									ระดับการศึกษา  <input type="text" name="contest_education" class="form-control" value="<?php echo $_SESSION['contest_education']?>"><br>
								</div>
								<div class="col-md-6 col-lg-2">
									ประเภทการแข่งขัน  <input type="text" name="contest_type" class="form-control" value="<?php echo $_SESSION['contest_type']?>"><br>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-lg-3">
									จำนวนการเข้าร่วมต่อโรงเรียน(ไทย)  <input type="text" name="contest_person" class="form-control" value="<?php echo $_SESSION['contest_person']?>"><br>
								</div>
								<div class="col-md-3 col-lg-3">
									จำนวนการเข้าร่วมต่อโรงเรียน(ต่างประเทศ)   <input type="text" name="contest_person_inter" class="form-control" value="<?php echo $_SESSION['contest_person_inter']?>"><br>
								</div>
								<div class="col-md-3 col-lg-3">
									จำนวนการเข้าร่วมต่อโรงเรียน(เจ้าภาพ)  <input type="text" name="contest_person_host" class="form-control" value="<?php echo $_SESSION['contest_person_host']?>"><br>
								</div>
								<div class="col-md-3 col-lg-3">
									จำนวนอาจารย์ควบคุมของโรงเรียน  <input type="text" name="contest_person_teacher" class="form-control" value="<?php echo $_SESSION['contest_person_teacher']?>"><br>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-lg-6">
									รูปแบบการแข่งขัน <input type="text" name="contest_platform" class="form-control" value="<?php echo $_SESSION['contest_platform']?>"><br>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-lg-6">
									วันเวลาแข่งขัน : เริ่มแข่งขัน 
									<div class='input-group date datepicker'>
										<input type='text' name='date_start' class='form-control' value="<?php echo $_SESSION['date_start']?>"/>
										<span class='input-group-addon'>
										<span class='glyphicon glyphicon-calendar'></span>
										</span>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									วันเวลาแข่งขัน : สิ้นสุดแข่งขัน
									<div class='input-group date datepicker'>
										<input type='text' name='date_end' class='form-control' value="<?php echo $_SESSION['date_end']?>"/>
										<span class='input-group-addon'>
										<span class='glyphicon glyphicon-calendar'></span>
										</span>
									</div>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-lg-12">
									ห้องที่ใช้แข่งขัน <input class="form-control" type="text" name='room' value="" id="tagsinput" />
								</div>
							</div>
							<br>
							<div class="form-group">
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="เพิ่มรายการ">
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
							รายการการแข่งขัน
						</div>
                      <!-- /.panel-heading -->
                      <div class="panel-body">
						<?php
							if($_GET['act']=="success_delete"){
									echo"<div class=\"alert alert-success alert-dismissable\">";
									echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
									echo"ลบรายการสำเร็จ";
									echo"</div>";
							}else if($_GET['act']=="error_delete"){
									echo"<div class=\"alert alert-danger alert-dismissable\">";
									echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
									echo"ลบรายการไม่สำเร็จ";
									echo"</div>";
							}
						?>
                          <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                              <thead>
									<tr>
										<th>รหัสรายการ</th>
										<th>รายการ</th>
										<th>ระดับการศึกษา</th>
										<th>ประเภทการแข่งขัน</th>
										<th>จำนวนการเข้าร่วมต่อโรงเรียน(ไทย)</th>
										<th>จำนวนการเข้าร่วมต่อโรงเรียน(ต่างประเทศ) </th>
										<th>จำนวนการเข้าร่วมต่อโรงเรียน(เจ้าภาพ)</th>
										<th>จำนวนครูควบคุมต่อโรงเรียน</th>
										<th>รูปแบบการแข่งขัน</th>
										<th>วันเวลาแข่งขัน</th>
										<th>สถานทีแข่งขัน</th>
										<th>แก้ไข</th>
										<th>ลบ</th>
									</tr>
                              </thead>
                              <tbody>
                                  <?php
										$sql = "SELECT contest.code,contest.contest_name,contest.education,contest.type,contest.teacher_person,contest.person,contest.person_host,contest.person_inter,contest.platform,contest.date_start,contest.date_end FROM contest ORDER BY contest.updatetime DESC;";
                                        $result = mysql_query($sql ,$conn);
										if ($result && mysql_num_rows($result) > 0) {
                                            while($row = mysql_fetch_array($result)) {
												echo "<tr class=\"odd gradeX\">";
												echo "    <td>".$row['code']."</td>";
												echo "    <td>".$row['contest_name']."</td>";
												echo "    <td>".$row['education']."</td>";
												echo "    <td>".$row['type']."</td>";
												echo "    <td>".$row['person']."</td>";
												echo "    <td>".$row['person_inter']."</td>";
												echo "    <td>".$row['person_host']."</td>";
												echo "    <td>".$row['teacher_person']."</td>";
												
												echo "    <td>".$row['platform']."</td>";
												if($row['date_start']=="0000-00-00 00:00:00"){
													$start_date = "-";
												}else $start_date = date_format(date_create($row['date_start']), 'd/m/Y H:i');
												if($row['date_end']=="0000-00-00 00:00:00"){
													$end_date = "-";
												}else $end_date = date_format(date_create($row['date_end']), 'd/m/Y H:i');
												echo "    <td>";
												echo "เริ่ม	".$start_date."<br>";
												echo "ถึง	".$end_date."<br>";
												echo "</td>";
												
												echo "<td>";
												$sql = "SELECT room.room_name,room.amount_student FROM room_contest INNER JOIN room ON room.id=room_contest.room_id WHERE room_contest.contest_code='".$row['code']."'"; 
												$result_room = mysql_query($sql ,$conn);
												if ($result_room) {
													while($row_room = mysql_fetch_array($result_room)) {
														echo $row_room['room_name']." จำนวนรับได้ ".$row_room['amount_student']." คน<br>";
													}
												}
												echo "</td>";
												echo "    <td><form role=\"form\" action=\"edit_contest.php\" method=\"post\"><input type=\"hidden\" name=\"contest_code\" value=\"".$row['code']."\"><input type=\"submit\" class=\"btn btn-warning\" value=\"Edit\"></form></td>";
												
												echo "    <td><form role=\"form\" action=\"db_del_contest.php\" onsubmit=\"return confirm('คูณต้องการจะลบ ".$row['contest_name']." ใช่หรือไม่?');\" method=\"post\"><input type=\"hidden\" name=\"code\" value=\"".$row['code']."\"><input type=\"submit\" class=\"btn btn-danger\" value=\"X\"></form></td>";
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
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	
    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/moment/moment.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../vendor/bootstrap/js/transition.js"></script>
	<script src="../vendor/bootstrap/js/collapse.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
	
	<!-- typeahead Plugin JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
	<script src="../vendor/typeahead/handlebars.js"></script>
    
	<!-- tagsinput Plugin JavaScript -->
	<script src="../vendor/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
	
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
		
	<!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
	<script>
	$(document).ready(function(){
		 $('.datepicker').datetimepicker({
			locale: 'th',
			format: 'DD/MM/YYYY HH:mm'
		 });

		var room = new Bloodhound({
		  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('room_name'),
		  queryTokenizer: Bloodhound.tokenizers.whitespace,
		  prefetch: 'db_getroom.php'
		});
		room.clearPrefetchCache();
		room.initialize();
	
		$('#tagsinput').tagsinput({
			itemValue: 'room_id',
			itemText: 'room_name',
			typeaheadjs: {
				name: 'cities',
				displayKey: 'room_name',
				source: room.ttAdapter(),
				templates: {
				empty: [
				  '<div class="row">',
					'<div class="col-lg-12" style="padding: 5px 20px;text-align: center;">',
						'ไม่มีสถานทีแข่งขันในระบบ',
					'</div>',
				  '</div>'
				].join('\n'),
				suggestion: Handlebars.compile('<div><strong>{{room_name}}</strong><div class="limit-student">ขนาด  {{limit_student}} คน</div></div>')
			  }
		  }
		});
		$(".bootstrap-tagsinput").addClass('form-control');
	});
    </script>

</body>
</html>