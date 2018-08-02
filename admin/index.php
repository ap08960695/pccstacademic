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
                  <h1 class="page-header">รายการแข่งขัน <small>(โปรดกดปุ่ม Save เมื่อต้องการบันทึกข้อมูลที่กรอก)</small></h1>
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
							<div class="dropdown">
							  <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">======== เลือกวิชา ========
							  <span class="caret"></span></button>
							  <ul class="dropdown-menu">
								<?php
									$sql = "SELECT code, name, level, type FROM subject WHERE status = 1;";
									$result = mysql_query($sql ,$conn);
									if (mysql_num_rows($result) > 0) {
                                        while($row = mysql_fetch_array($result)) {
											echo "<li><a href=\"index.php?subject=".$row['code']."\">[".$row['code']."] ".$row['name']." (".$row['level'].")</a></li>\n";
										}
									}
								?>
							  </ul>
							</div>
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
										$sql = "SET SESSION group_concat_max_len = 1000000;";
										mysql_query($sql ,$conn);
                                        $sql = "SELECT s.id,s.code,s.name AS 'subjectname',s.level,s.type,s.person,GROUP_CONCAT(r.name) AS 'name',GROUP_CONCAT(r.no) AS 'no',s.platform,s.status
                                        FROM subject s LEFT JOIN (SELECT * FROM register WHERE school_id = '$school_code'  AND status = 1) r ON s.code = r.subject_id
                                        WHERE s.code = '$subject_code' AND s.status = 1 GROUP BY s.code ORDER BY s.level DESC,s.code ASC;";
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
													echo "<hr>";
													if(@$arrno[2] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[2]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[3] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[3]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													echo "<hr>";
													if(@$arrno[4] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[4]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[5] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[5]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													echo "<hr>";
													if(@$arrno[6] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[6]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[7] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[7]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													echo "<hr>";
													if(@$arrno[8] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[8]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[9] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[9]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if($arrno[10] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[10]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }

                                                    if(@$arrno[11] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[11]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													echo "<hr>";
													if(@$arrno[12] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[12]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[13] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[13]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													echo "<hr>";
													if(@$arrno[14] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[14]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[15] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[15]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													echo "<hr>";
													if(@$arrno[16] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[16]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[17] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[17]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													echo "<hr>";
													if(@$arrno[18] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[18]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[19] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[19]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
                                                    echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
                                                } else {
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
													if(@$arrno[2] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[2]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[3] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[3]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[4] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[4]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[5] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[5]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[6] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[6]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[7] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[7]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[8] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[8]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[9] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[9]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if($arrno[10] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[10]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[11] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[11]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[12] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[12]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[13] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[13]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[14] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[14]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[15] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[15]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[16] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[16]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[17] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[17]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[18] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[18]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
													if(@$arrno[19] == '1') {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[19]."\">";
                                                    } else {
                                                        echo"        <input type=\"text\" name=\"student[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\">";
                                                    }
                                                    
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													echo "<input type=\"hidden\" name=\"code[]\" value=\"".$row['code']."\">\n";
													
                                                }
                                                echo"    </td>";

                                                $key = array_search ('0', $arrno);
                                                if($arrno[$key] == '0') {
                                                    echo"    <td class=\"center\"><input type=\"text\" name=\"teacher[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"".$arrname[$key]."\"></td>";
                                                } else {
                                                    echo"    <td class=\"center\"><input type=\"text\" name=\"teacher[]\" class=\"form-control\" onkeyup=\"checkFilled(this)\" value=\"\"></td>";
                                                }

												echo "<input type=\"hidden\" name=\"teachcode[]\" value=\"".$row['code']."\">\n";
                                                //$teachcode .= $row['code'].",";
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
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>