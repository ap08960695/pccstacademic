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

    $school_code = $_GET["s"];
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
					<?php
						include_once('condb.php');
						$sql = "SELECT code,display FROM school WHERE code = '".$_GET['s']."' AND status = 1;";
						$result = mysql_query($sql);
						if (mysql_num_rows($result) > 0) {
						    while($row = mysql_fetch_array($result)) {
								$schoolselect = $row['display'];
							}
						}
					?>
                  <h1 class="page-header">สรุปการแข่งรายโรงเรียน <small> <?php echo $schoolselect; ?></small></h1>
              </div>
              <!-- /.col-lg-12 -->
          </div>
          <!-- /.row -->
          <div class="row">
              <div class="col-lg-12">
                  <div class="panel panel-default">
                    <form role="form" action="savedata_pccst.php" method="post">
                      <div class="panel-heading">
                          ลงทะเบียนรายการแข่งขันงาน จ.ภ.วิชาการ
                      </div>
                      <!-- /.panel-heading -->
                      <div class="panel-body">
                          <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                              <thead>
                                  <tr>
									  <th>ที่</th>
                                      <th>รหัสการแข่งขัน</th>
                                      <th>รายการแข่งขัน</th>
                                      <th>ระดับชั้น</th>
                                      <th>ชื่อผู้เข้าแข่งขัน (คำนำหน้า ชื่อ-นามสกุล)</th>
                                      <th>ชื่อครูผู้ควบคุม (รายการละ 1 คนเท่านั้น)</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php
                                        $stdcode = "";
                                        $teachcode = "";
										$k = 0;
										$sql = "SET SESSION group_concat_max_len = 1000000;";
										mysql_query($sql ,$conn);
                                        //$sql = "SELECT id,code,name,level,type,person,platform,status FROM subject WHERE status = 1 ORDER BY level DESC;";
                                        $sql = "SELECT s.id,s.code,s.name AS 'subjectname',s.level,s.type,s.person,GROUP_CONCAT(r.name) AS 'name',GROUP_CONCAT(r.no) AS 'no',s.platform,s.status
                                        FROM subject s LEFT JOIN (SELECT * FROM register WHERE school_id = '$school_code' AND status = 1) r ON s.code = r.subject_id
                                        WHERE s.status = 1 GROUP BY s.code ORDER BY s.level DESC,s.code ASC;";
                                        $result = mysql_query($sql ,$conn);
                                        if (mysql_num_rows($result) > 0) {
                                            while($row = mysql_fetch_array($result)) {
												if($row['person'] == 2) {
													$arrname = explode(",",$row['name']);
													$arrno = explode(",",$row['no']);
													$max = count($arrname) - 1;
													if($arrname[0] != "") { //if($arrname[0] != "") {
														for($i=0;$i<$max;$i+=2) {
															echo "<tr class=\"odd gradeX\">";
															echo "    <td>".($k+1)."</td>";
															echo "    <td>".$row['code']."</td>";
															echo "    <td>".$row['subjectname']." (".$row['person']." คน)"."</td>";
															echo "    <td>".$row['level']."</td>";
															echo "    <td class=\"center\">1) ".$arrname[$i]."<br>2) ".$arrname[$i+1]."</td>";
															$key = array_search ('0', $arrno);
															echo "    <td class=\"center\">".(($key !== false)?$arrname[$key]:" ")."</td>";
															echo "</tr>";
															$k++;
														}
													}
												} else {
													$arrname = explode(",",$row['name']);
													$arrno = explode(",",$row['no']);
													$key = array_search ('0', $arrno);
													if(count($arrname) > 1) {
														foreach($arrname as $value) {
															if($arrname[$key] != $value) {
																echo "<tr class=\"odd gradeX\">";
																echo "    <td>".($k+1)."</td>";
																echo "    <td>".$row['code']."</td>";
																echo "    <td>".$row['subjectname']." (".$row['person']." คน)"."</td>";
																echo "    <td>".$row['level']."</td>";
																echo "    <td class=\"center\">".$value."</td>";
																$key = array_search ('0', $arrno);
																echo "    <td class=\"center\">".(($key !== false)?$arrname[$key]:" ")."</td>";
																echo "</tr>";
																$k++;
															}
														}
													} else {
														echo "<tr class=\"odd gradeX\">";
														echo "    <td>".($k+1)."</td>";
														echo "    <td>".$row['code']."</td>";
														echo "    <td>".$row['subjectname']." (".$row['person']." คน)"."</td>";
														echo "    <td>".$row['level']."</td>";
														echo "    <td class=\"center\">".$row['name']."</td>";
														echo "    <td class=\"center\"></td>";
														echo "</tr>";
														$k++;
													}
												}
											}
										}
                                  ?>
                              </tbody>
                          </table>
                          <!-- /.table-responsive -->
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