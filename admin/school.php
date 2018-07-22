<?php
    session_start();
    include_once('../condb.php');
    
	$sql = "SELECT meta FROM config WHERE meta='userAdmin' AND value='".md5($_SESSION['user'])."'";
    $result = mysql_query($sql);
	  if(mysql_num_rows($result)!=1){
		header("Location: ../login.php");
		exit();
	  }
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
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">[จ.ภ.วิชาการ] <small>Admin</small></a>
            </div>
            <!-- /.navbar-header -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="school.php"><i class="fa fa-dashboard fa-fw"></i> โรงเรียนที่เข้าร่วมแข่งขัน</a>
                        </li>
                        <li>
                            <a href="index_pccst.php"><i class="fa fa-edit fa-fw"></i> ลงทะเบียนแข่งขัน</a>
                        </li>
                        <li>
                            <a href="report_school.php"><i class="fa fa-dashboard fa-fw"></i> สรุปการแข่งรายโรงเรียน</a>
                        </li>
							<li>
                            <a href="report_subject.php"><i class="fa fa-dashboard fa-fw"></i> สรุปรายชื่อต่อรายการแข่ง</a>
                        </li>
                        <li>
                            <a href="logout.php"><i class="fa fa-dashboard fa-fw"></i> ออกจากระบบ</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

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
							<button type="button" class="btn btn-info btn-xs" onclick="window.location='school.php'">โรงเรียนทั้งหมด</button>
							<button type="button" class="btn btn-success btn-xs" onclick="window.location='school.php?view=success'">ยืนยันแล้ว</button>
							<button type="button" class="btn btn-danger btn-xs" onclick="window.location='school.php?view=danger'">ยังไม่ยืนยัน</button>
                      </div>
                      <!-- /.panel-heading -->
                      <div class="panel-body">
						<?php
							$name_school = "";
							if(isset($_GET['user'])){
								$user_school = $_GET['user']; 
								$sql = "SELECT display,code,status FROM school WHERE user='$user_school'";
                                $result = mysql_query($sql ,$conn);
                                $row_school = mysql_num_rows($result);
							}
							if($_GET['act']=="success_approved"){
									echo"<div class=\"alert alert-success alert-dismissable\">";
									echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
									echo"การยืนยันเสร็จสิ้น ";
									echo"</div>";
							}else if($_GET['act']=="success_code"){
									echo"<div class=\"alert alert-success alert-dismissable\">";
									echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
									echo"เพิ่ม Code สำเร็จ";
									echo"</div>";
							}else if($_GET['act']=="success_delete"){
									echo"<div class=\"alert alert-success alert-dismissable\">";
									echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
									echo"ลบข้อมูลสำเร็จ";
									echo"</div>";
							}else if($_GET['act']=="error_approved"){
									echo"<div class=\"alert alert-danger alert-dismissable\">";
									echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
									echo"ไม่สามารถยืนยันได้";
									echo"</div>";
							}else if($_GET['act']=="error_code"){
									echo"<div class=\"alert alert-danger alert-dismissable\">";
									echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
									echo"ไม่สามารถเพิ่ม Code";
									echo"</div>";
							}else if($_GET['act']=="error_delete"){
									echo"<div class=\"alert alert-danger alert-dismissable\">";
									echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
									echo"ลบข้อมูลไม่สำเร็จ";
									echo"</div>";
							}
						?>
                          <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                              <thead>
                                  <tr>
                                      <th>code</th>
                                      <th>ชื่อโรงเรียน<button type="button" class="btn btn-danger btn-xs" style='margin-left: 10px;' onclick="window.location='db_updateallschool.php'">ยืนยันทั้งหมด</button></th>
                                      <th>E-mail</th>
										  <th>ลบ</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php
                                        if(isset($_GET['view'])){
											if($_GET['view']=='success'){
												$sql = "SELECT * FROM school WHERE status=1 ORDER BY u_date DESC;";
											}else if($_GET['view']=='danger'){
												$sql = "SELECT * FROM school WHERE status=0 ORDER BY u_date DESC;";
											}else $sql = "SELECT * FROM school ORDER BY status ASC,u_date DESC;";
										}else $sql = "SELECT * FROM school ORDER BY status ASC,u_date DESC;";
                                        $result = mysql_query($sql ,$conn);
                                        if (mysql_num_rows($result) > 0) {
                                            while($row = mysql_fetch_array($result)) {
												echo "<tr class=\"odd gradeX\">";
												echo "    <td>".$row['code']."</td>";
												echo "    <td>";
												if($row['status']==0){
													echo $row['display']."<label style='margin-left: 10px;'></label>";
													echo "<button type='button' style='margin-right: 4px;' class='btn btn-danger btn-xs' onclick='window.location=\"db_update_school.php?user=".$row['user']."\"' >ยืนยัน</button>";
												}else echo $row['display'];
												echo "</td>";
												echo "    <td>".$row['email']."</td>";
												echo "    <td><form role=\"form\" action=\"db_del_school.php\" onsubmit=\"return confirm('คูณต้องการจะลบ ".$row['display']." ใช่หรือไม่?');\" method=\"post\"><input type=\"hidden\" name=\"code\" value=\"".$row['code']."\"><input type=\"hidden\" name=\"user\" value=\"".$row['user']."\"><input type=\"submit\" class=\"btn btn-danger\" value=\"X\"></form></td>";
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