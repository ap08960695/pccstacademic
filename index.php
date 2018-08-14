<?php
    session_start();
    include_once('condb.php');
	date_default_timezone_set('Asia/Bangkok');
	$sql = "SELECT * FROM school WHERE user='".$_SESSION['user']."' AND code='".$_SESSION['code']."'";
    $result = mysql_query($sql);
	if(mysql_num_rows($result)!=1){
		header("Location: login.php");
		exit();
	}
    $school_code = $_SESSION["code"];
    $schoolname = $_SESSION["display"];
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ระบบลงทะเบียนแข่งขัน</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">[จ.ภ.วิชาการ] <small><?php echo $schoolname; ?></small></a>
            </div>
            <!-- /.navbar-header -->
			<?php include_once("nav.html");?>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
          <div class="row">
              <div class="col-lg-12">
                  <h1 class="page-header">รายการแข่งขัน <small>(โปรดกดปุ่ม Save เมื่อต้องการบันทึกข้อมูลที่กรอก)</small></h1>
              </div>
              <!-- /.col-lg-12 -->
          </div>
          <!-- /.row -->
          <div class="row">
              <div class="col-lg-12">
                  <div class="panel panel-default">
                    <form role="form" action="savedata.php" method="post">
                      <div class="panel-heading">
                          ลงทะเบียนรายการแข่งขันงาน จ.ภ.วิชาการ
                      </div>
                      <!-- /.panel-heading -->
                      <div class="panel-body">
                          <?php 
							if($_GET['error']=="update_student"){
									echo"<div class=\"alert alert-danger alert-dismissable\">";
									echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
									echo"ไม่สามารถเพิ่มนักเรียนได้";
									echo"</div>";
							}else if($_GET['act']=="update_teacher"){
									echo"<div class=\"alert alert-danger alert-dismissable\">";
									echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
									echo"ไม่สามารถเพิ่มอาจารย์ได้";
									echo"</div>";
							}else if($_GET['success']=="true"){
									echo"<div class=\"alert alert-success alert-dismissable\">";
									echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
									echo"เพิ่มสำเร็จ";
									echo"</div>";
							} 
						?>
						  <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                              <thead>
                                  <tr>
                                      <th>รหัสการแข่งขัน</th>
                                      <th>รายการแข่งขัน</th>
                                      <th>ระดับชั้น</th>
                                      <th>ชื่อผู้เข้าแข่งขัน (คำนำหน้า ชื่อ-นามสกุล)</th>
                                      <th>ชื่อครูผู้ควบคุม (คำนำหน้า ชื่อ-นามสกุล)</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php
                                        $sql = "SELECT contest.code,contest.contest_name,contest.person,contest.teacher_person,contest.education FROM school LEFT JOIN contest_group ON school.group_contest=contest_group.group_name INNER JOIN contest ON contest.code=contest_group.contest_code WHERE school.code='".$school_code."' ORDER BY contest.code DESC";
										$result = mysql_query($sql ,$conn);
                                        if (mysql_num_rows($result) > 0) {
                                            while($row = mysql_fetch_array($result)) {
                                                echo"<tr class=\"odd gradeX\">";
                                                echo"    <td>".$row['code']."</td>";
                                                echo"    <td>".$row['contest_name']." (".$row['person']." คน)"."</td>";
                                                echo"    <td>".$row['education']."</td>";
                                                echo"    <td class=\"center\">";
                                                
												$sql = "SELECT name FROM register WHERE school_id='".$school_code."' AND subject_id='".$row['code']."' AND status=1";
												$result_register = mysql_query($sql ,$conn);
												for($i=0;$i<$row['person'];$i++) {
													if($row_register = mysql_fetch_array($result_register)){
														echo"        <input type=\"text\" name=\"student['".$row['code']."'][]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$row_register['name']."\">";
													}else{
														echo"        <input type=\"text\" name=\"student['".$row['code']."'][]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
													}
												}
												echo"    </td>";
                                                echo"    <td class=\"center\">";
                                                
												$sql = "SELECT name FROM register_teacher WHERE school_id='".$school_code."' AND subject_id='".$row['code']."' AND status=1";
												$result_register = mysql_query($sql ,$conn);
												for($i=0;$i<$row['teacher_person'];$i++) {
													if($row_register = mysql_fetch_array($result_register)){
														echo"        <input type=\"text\" name=\"teacher['".$row['code']."'][]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$row_register['name']."\">";
													}else{
														echo"        <input type=\"text\" name=\"teacher['".$row['code']."'][]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
													}
												}
												echo"    </td>";
                                                echo"</tr>";
                                            }
                                        }
                                  ?>
                              </tbody>
                          </table>
                          <!-- /.table-responsive -->
                          <center><input type="submit" class="btn btn-lg btn-success" value="Save บันทึกข้อมูล !"></center>
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
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

</body>

</html>
