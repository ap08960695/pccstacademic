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
                  <h1 class="page-header">สรุปรายชื่อต่อรายการแข่ง  <a href="pccstcer/processcer.php" class="btn btn-success">ประมวนผลเกียรติบัตร!!</a></h1> 
              </div>
              <!-- /.col-lg-12 -->
          </div>
          <!-- /.row -->
			<?php
				if(isset($_GET['q'])){
					echo "<div class=\"alert alert-info\" role=\"alert\">สร้างเกียรติบัตรสำเร็จ รายการเกียรติบัตรทั้งหมดอยู่ที่ <a href=\"http://pccstacademic.net/cer/index.php\">http://pccstacademic.net/cer/index.php</a></div>";
				}
			?>
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
                                      <th>ชื่อรายการแข่งขัน</th>
										  <th>รายการแข่งขัน</th>
										  <th>ระดับชั้น</th>
                                      <th></th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php
                                        $stdcode = "";
                                        $teachcode = "";
                                        $sql = "SELECT * FROM subject WHERE status = 1;";
                                        $result = mysql_query($sql ,$conn);
                                        if (mysql_num_rows($result) > 0) {
                                            while($row = mysql_fetch_array($result)) {
												echo "<tr class=\"odd gradeX\">";
												echo "    <td>".$row['code']."</td>";
												if($row['type'] == 'ทีม (2 คน)'){
													$sql_s = "SELECT * FROM register r JOIN school s ON r.school_id = s.code WHERE subject_id = '".$row['code']."' AND s.status = 1 AND r.status = 1;";
													$result_s = mysql_query($sql_s ,$conn);
													echo "    <td>".$row['name']." (".(mysql_num_rows($result_s)/2)." ทีม)</td>";
												}else{
													$sql_s = "SELECT * FROM register r JOIN school s ON r.school_id = s.code WHERE subject_id = '".$row['code']."' AND s.status = 1 AND r.status = 1;";
													$result_s = mysql_query($sql_s ,$conn);
													echo "    <td>".$row['name']." (".mysql_num_rows($result_s)." คน)</td>";
												}
												echo "    <td>".$row['type']."</td>";
												echo "    <td>".$row['level']."</td>";
                                                echo "    <td>";
                                                echo "<a href=\"school_excel_export.php?s=".$row['code']."\" class=\"btn btn-primary\">export excel</a> <a href=\"reportsubject_edit.php?s=".$row['code']."\" class=\"btn btn-warning\"><span class=\"glyphicon glyphicon-edit\"></span></a>";
                                                echo "<form method=\"post\" action=\"db_school_excel_import.php?s=".$row['code']."\"  enctype=\"multipart/form-data\"><input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"30000\" />
                                                        <input type=\"file\" name=\"myFile\">
                                                        <button>Upload</button>
                                                        </form>";
                                                echo "    <a href=\"school_pdf_export.php?s=".$row['code']."\" class=\"btn btn-primary\">export pdf</a> <a href=\"get_cert_subject.php?s=".$row['code']."\" class=\"btn btn-warning\">Gen Certification</a></td>";
												
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