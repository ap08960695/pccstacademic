<?php
    session_start();
    include_once('condb.php');
    if(!isset($_SESSION["user"]))
    {
        header("location:login.php");
    } elseif($_SESSION['user'] == "acf001") {
		header("Location:index_pccst.php");
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
                            <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> ข้อมูลโรงเรียน</a>
                        </li>
                        <li>
                            <a href="tables.html"><i class="fa fa-edit fa-fw"></i> ลงทะเบียนแข่งขัน</a>
                        </li>
                        <li>
                            <a href="forms.html"><i class="fa fa-dashboard fa-fw"></i> ผลการแข่งขัน</a>
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
                          <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                              <thead>
                                  <tr>
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
                                        //$sql = "SELECT id,code,name,level,type,person,platform,status FROM subject WHERE status = 1 ORDER BY level DESC;";
                                        $sql = "SELECT s.id,s.code,s.name AS 'subjectname',s.level,s.type,s.person,GROUP_CONCAT(r.name) AS 'name',GROUP_CONCAT(r.no) AS 'no',s.platform,s.status
                                        FROM subject s LEFT JOIN (SELECT * FROM register WHERE school_id = '$school_code' AND status = 1) r ON s.code = r.subject_id
                                        WHERE s.status = 1 GROUP BY s.code ORDER BY s.level DESC,s.code ASC;";
                                        $result = mysql_query($sql ,$conn);
                                        if (mysql_num_rows($result) > 0) {
                                            while($row = mysql_fetch_array($result)) {
                                                echo"<tr class=\"odd gradeX\">";
                                                echo"    <td>".$row['code']."</td>";
                                                echo"    <td>".$row['subjectname']." (".$row['person']." คน)"."</td>";
                                                echo"    <td>".$row['level']."</td>";
                                                echo"    <td class=\"center\">";
                                                $arrname = explode(",",$row['name']);
                                                $arrno = explode(",",$row['no']);
                                                if($row['person'] == 2) {
                                                    if($arrno[0] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[0]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }

                                                    if(@$arrno[1] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[1]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
                                                    //$stdcode .= $row['code'].",";
                                                    //$stdcode .= $row['code'].",";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
                                                } else {
                                                    if($arrno[0] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[0]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
                                                    //$stdcode .= $row['code'].",";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
                                                }
                                                echo"    </td>";

                                                $key = array_search ('0', $arrno);
                                                if($arrno[$key] == '0') {
                                                    echo"    <td class=\"center\"><input type=\"text\" name=\"teacher[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[$key]."\"></td>";
                                                } else {
                                                    echo"    <td class=\"center\"><input type=\"text\" name=\"teacher[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\"></td>";
                                                }

                                                //$teachcode .= $row['code'].",";
												echo "<input type=\"hidden\" name=\"teachcode[]\" value=\"".$row['code']."\">\n";
                                                echo"</tr>";
                                            }
                                        }
										//echo "<input type=\"hidden\" name=\"stdcode\" value=\"".$stdcode."\">\n";
                                        //echo "<input type=\"hidden\" name=\"teachcode\" value=\"".$teachcode."\">\n";
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
