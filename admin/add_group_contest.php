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
							เพิ่มกลุ่มการแข่งขัน
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
									echo"ไม่สามารถเพิ่มรายการได้ ชื่อกลุ่มถูกใช้งานแล้ว";
									echo"</div>";
							} 
						?>
						<form id="form_contest" role="form" action="db_add_groupcontest.php" method="post" onsubmit="return confirm('คุณต้องการเพิ่มกลุ่มทีนี้ ใช่หรือไม่?');">
							<div class="row">
								<div class="col-md-12 col-lg-12">
									ชื่อกลุ่มการแข่งขัน  <input type="text" name="place_name" class="form-control" value="<?php echo $_SESSION['place_name']?>"><br>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-lg-12">
									<div class="well" style="max-height: 300px;overflow: auto;">
										<ul class="list-group checked-list-box">
										<?php 
											$sql = "SELECT code,contest_name,education,type FROM contest;";
											$result = mysql_query($sql ,$conn);
											if ($result && mysql_num_rows($result) > 0) {
												while($row = mysql_fetch_array($result)) {
													echo '<li class="list-group-item" code="'.$row['code'].'">'.$row['code'].' '.$row['contest_name'].'  ('.$row['education'].') ('.$row['type'].')</li>';
												}
											}
										?>
										</ul>
									</div><br>
									<input type="hidden" id="contest_list" name="contest_list"/>
								</div>
							</div>
							<div class="form-group">
                                <input type="button" class="btn btn-lg btn-success btn-block" value="เพิ่มกลุ่มการแข่งขัน" onclick="sentform()">
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
							กลุ่มการแข่งขัน
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
										<th>กลุ่มการแข่งขัน</th>
										<th>รายการแข่งขัน</th>
										<th>ลบ</th>
									</tr>
                              </thead>
                              <tbody>
                                  <?php
										$sql = "SELECT group_name FROM contest_group GROUP BY group_name ORDER BY updatetime DESC;";
                                        $result = mysql_query($sql ,$conn);
										if ($result && mysql_num_rows($result) > 0) {
                                            while($row = mysql_fetch_array($result)) {
												echo "<tr class=\"odd gradeX\">";
												echo "    <td>".$row['group_name']."</td>";
												
												echo "    <td>";
													$sql = "SELECT contest.contest_name,contest.code,contest.education,contest.type FROM contest_group INNER JOIN contest ON contest.code=contest_group.contest_code WHERE contest_group.group_name='".$row['group_name']."' ORDER BY contest.code ASC;";
													$result_contest = mysql_query($sql ,$conn);
													while($row_contest = mysql_fetch_array($result_contest)) {
														echo $row_contest['code'].' '.$row_contest['contest_name'].' ('.$row_contest['education'].') ('.$row_contest['type'].')<br>';
													}
												echo "</td>";
												echo "    <td><form role=\"form\" action=\"db_del_group_contest.php\" onsubmit=\"return confirm('คุณต้องการจะลบ ".$row['group_name']." ใช่หรือไม่?');\" method=\"post\"><input type=\"hidden\" name=\"group_name\" value=\"".$row['group_name']."\"><input type=\"submit\" class=\"btn btn-danger\" value=\"X\"></form></td>";
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
	
	<!-- Checkbox Group JS -->
    <script src="../vendor/checkbox-group/checkbox-group.js"></script>
	
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
		
	<!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>
<script>
	var checkedItems = {}, counter = 0;
	function getcheckbox(){
		var checkbox = $(".list-group li.active");
		var list = "";
		for(var i = 0;i<checkbox.length;i++){
			list += $(checkbox[i]).attr("code")+",";
		}
		list = list.substring(0,list.length-1);
		return list;
	}
	function sentform(){
		$("#contest_list").val(getcheckbox());
		$('#form_contest').submit();
	}
</script>
</html>