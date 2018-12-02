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
        <?php
			include_once("nav_admin.html");
		?>
        <!-- Page Content -->
        <div id="page-wrapper">
          <div class="row">
              <div class="col-lg-12">
                  <h1 class="page-header">สรุปการแข่งรายโรงเรียน</h1>
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
                                      <th></th>
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
												$sql_s = "SELECT * FROM register WHERE school_id = '".$row['code']."' AND no = 1 AND status = 1;";
                                                $result_s = mysql_query($sql_s ,$conn);
                                                $result_s_rows = mysql_num_rows($result_s);
												echo "<tr class=\"odd gradeX\">";
												echo "    <td>".$row['code']."</td>";
												echo "    <td>".$row['display']." (".$result_s_rows." คน)</td>";
												echo "    <td><a href=\"reportschool.php?s=".$row['code']."\" class=\"btn btn-primary\">รายละเอียด</a>";
                                                echo "    <a href=\"reportschool.php?s=".$row['code']."\" class=\"btn btn-primary\">รายละเอียด</a></td>";
                                                echo "</tr>";
												
												/*
												$sql_s = "SELECT * FROM register r JOIN subject s ON r.subject_id = s.code WHERE school_id = '".$row['code']."' AND type != 'ทีม (2 คน)'  AND no = 1 AND r.status = 1;";
												$result_s = mysql_query($sql_s ,$conn);
												$sql_c = "SELECT * FROM register r JOIN subject s ON r.subject_id = s.code WHERE school_id = '".$row['code']."' AND type = 'ทีม (2 คน)'  AND no = 1 AND r.status = 1;";
												$result_c = mysql_query($sql_c ,$conn);
												echo "<tr class=\"odd gradeX\">";
												echo "    <td>".$row['code']."</td>";
												echo "    <td>".$row['display']." (".(mysql_num_rows($result_s) + (mysql_num_rows($result_c)/2))." คน)</td>";
												echo "    <td><a href=\"reportschool.php?s=".$row['code']."\" class=\"btn btn-primary\">รายละเอียด</a></td>";
												echo "</tr>";
												*/
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