<?php
    session_start();
    include_once('condb.php');
    if(!isset($_SESSION["user"]))
    {
        header("location:login.php");
    }
	
	if($_SESSION["user"] != "acf001")
    {
        header("location:login.php");
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

    <title>SB Admin 2 - Bootstrap Admin Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="addschool.php"><i class="fa fa-dashboard fa-fw"></i> เพิ่มโรงเรียนใหม่</a>
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
                  <h1 class="page-header">รายการโรงเรียน <small>(โปรดกดปุ่ม Save เมื่อต้องการบันทึกข้อมูลที่กรอก)</small></h1>
              </div>
              <!-- /.col-lg-12 -->
          </div>
          <!-- /.row -->
          <div class="row">
              <div class="col-lg-12">
                  <div class="panel panel-default">
                      <div class="panel-heading">
							รายชื่อโรงเรียนทั้งหมด
                      </div>
                      <!-- /.panel-heading -->
                      <div class="panel-body">
                          <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                              <thead>
                                  <tr>
                                      <th>code</th>
                                      <th>ชื่อโรงเรียน</th>
                                      <th>Username</th>
										  <th>Password</th>
										  <th>ลบ</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php
                                        $stdcode = "";
                                        $teachcode = "";
                                        $sql = "SELECT * FROM school WHERE status = 1;";
                                        $result = mysql_query($sql ,$conn);
                                        if (mysql_num_rows($result) > 0) {
                                            while($row = mysql_fetch_array($result)) {
												echo "<tr class=\"odd gradeX\">";
												echo "    <td>".$row['code']."</td>";
												echo "    <td>".$row['display']."</td>";
												echo "    <td>".$row['user']."</td>";
												echo "    <td>".$row['pass']."</td>";
												echo "    <td><form role=\"form\" action=\"db_del_school.php\" onsubmit=\"return confirm('คูณต้องการจะลบ ".$row['display']." ใช่หรือไม่?');\" method=\"post\"><input type=\"hidden\" name=\"code\" value=\"".$row['code']."\"><input type=\"submit\" class=\"btn btn-danger\" value=\"X\"></form></td>";
												echo "</tr>";
											}
										}
									?>
                              </tbody>
                          </table>
                          <!-- /.table-responsive -->
						  
				<div class="panel panel-primary">
					<div class="panel-heading">เพิ่มโรงเรียนใหม่</div>
					<div class="panel-body">
						<form role="form" action="db_add_school.php" method="post">
							Code : <input type="text" name="code" class="form-control" value=""><br>
							Name : <input type="text" name="name" class="form-control" value=""><br>
							Username : <input type="text" name="usern" class="form-control" value=""><br>
							Password : <input type="text" name="passwd" class="form-control" value=""><br>
							<center><input type="submit" class="btn btn-primary" value="เพิ่มโรงเรียน!"></center>
						</form>
					</div>
				</div>
				
                      </div>
                      <!-- /.panel-body -->
                  </div>
                  <!-- /.panel -->
              </div>
              <!-- /.col-lg-12 -->
\				
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