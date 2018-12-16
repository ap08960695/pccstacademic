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

</head>

<body>

    <div id="wrapper">
        <?php
			include_once("nav_admin.html");
		?>
        <div id="page-wrapper">
          <div class="row">
              <div class="col-lg-12">
                  <h1 class="page-header">สรุปรายชื่อต่อรายการแข่ง  <a href="get_cert_all.php" class="btn btn-success">ประมวนผลเกียรติบัตร!!</a></h1> 
              </div>
              <!-- /.col-lg-12 -->
          </div>
          <div class="row">
              <div class="col-lg-12">
                  <div class="panel panel-default">
                      <div class="panel-heading">
							รายชื่อโรงเรียนทั้งหมด
                      </div>
                      <!-- /.panel-heading -->
                      <div class="panel-body">
                        <?php 
                            
                            if($_GET['act']=="empty_file"){
                                echo"<div class=\"alert alert-danger alert-dismissable\">";
                                echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                                echo"ไม่พบไฟล์";
                                echo"</div>";
                            }else if($_GET['act']=="error_get_data"){
                                echo"<div class=\"alert alert-danger alert-dismissable\">";
                                echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                                echo"ไม่สามารถดึงข้อมูลได้";
                                echo"</div>";
                            }else if($_GET['act']=="empty_contest"){
                                echo"<div class=\"alert alert-danger alert-dismissable\">";
                                echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                                echo"ไม่มี contest";
                                echo"</div>";
                            }else if($_GET['act']=="student_error_insert"){
									echo"<div class=\"alert alert-danger alert-dismissable\">";
									echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
									echo"ไม่สามารถเพิ่มข้อมูลนักเรียนได้";
									echo"</div>";
							}else if($_GET['act']=="success_cer"){
                                echo"<div class=\"alert alert-success alert-dismissable\">";
                                echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                                echo"สร้างเกียรติบัตรสำเร็จ";
                                echo"</div>";
                            }else if($_GET['act']=="success"){
                                echo"<div class=\"alert alert-success alert-dismissable\">";
                                echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                                echo"เปลี่ยนแปลงข้อมูลสำเร็จ";
                                echo"</div>";
                            }else if($_GET['act']=="student_error_delete"){
                                echo"<div class=\"alert alert-danger alert-dismissable\">";
                                echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                                echo"ไม่สามารถลบข้อมูลเก่าของนักเรียนได้";
                                echo"</div>";
                            }else if($_GET['act']=="student_error_excel"){
                                echo"<div class=\"alert alert-danger alert-dismissable\">";
                                echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                                echo"เกิดความขัดข้องของนักเรียน";
                                echo"</div>";
                            }else if($_GET['act']=="teacher_error_delete"){
                                echo"<div class=\"alert alert-danger alert-dismissable\">";
                                echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                                echo"ไม่สามารถลบข้อมูลเก่าของครูได้";
                                echo"</div>";
                            }else if($_GET['act']=="teacher_error_excel"){
                                echo"<div class=\"alert alert-danger alert-dismissable\">";
                                echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                                echo"เกิดความขัดข้องของครู";
                                echo"</div>";
                            }else if($_GET['act']=="teacher_error_insert"){
                                echo"<div class=\"alert alert-danger alert-dismissable\">";
                                echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                                echo"ไม่สามารถเพิ่มข้อมูลครูได้";
                                echo"</div>";
                            }
						?>
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
                                        $sql = "SELECT * FROM contest";
                                        $result = mysql_query($sql ,$conn);
                                        if (mysql_num_rows($result) > 0) {
                                            while($row = mysql_fetch_array($result)) {
												echo "<tr class=\"odd gradeX\">";
												echo "    <td>".$row['code']."</td>";
												$sql_s = "SELECT * FROM register r JOIN school s ON r.school_id = s.code WHERE subject_id = '".$row['code']."' AND s.status = 1 AND r.status = 1;";
												$result_s = mysql_query($sql_s ,$conn);
												echo "    <td>".$row['name']." (".mysql_num_rows($result_s)." คน)<br>";
                                                echo "<form method=\"post\" action=\"db_school_excel_import.php?s=".$row['code']."\"  enctype=\"multipart/form-data\">";
                                                echo '<div class="form-group">
                                                    <div class="input-group input-file" name="myFile">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default btn-choose" type="button">Choose</button>
                                                        </span>
                                                        <input type="text" class="form-control" placeholder="Choose a file..." />
                                                        <span class="input-group-btn">
                                                            <button type="submit" class="btn btn-success pull-right">Upload</button>
                                                        </span>
                                                    </div>
                                                </div>';
                                                echo "</form>";
                                                echo "</td>";
												echo "    <td>".$row['type']."</td>";
												echo "    <td>".$row['education']."</td>";
                                                echo "    <td>";
                                                echo "<a href=\"school_excel_export.php?s=".$row['code']."\" class=\"btn btn-primary\">export excel</a>";
                                                echo "<a href=\"school_pdf_export.php?s=".$row['code']."\" class=\"btn btn-primary\">export pdf</a>";
                                                echo "<a href=\"get_cert_subject.php?s=".$row['code']."\" class=\"btn btn-warning\">Gen Certification</a>";
                                                
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
    <script>
    function bs_input_file() {
        $(".input-file").before(
            function() {
                if ( ! $(this).prev().hasClass('input-ghost') ) {
                    var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
                    element.attr("name",$(this).attr("name"));
                    element.change(function(){
                        element.next(element).find('input').val((element.val()).split('\\').pop());
                    });
                    $(this).find("button.btn-choose").click(function(){
                        element.click();
                    });
                    $(this).find("button.btn-reset").click(function(){
                        element.val(null);
                        $(this).parents(".input-file").find('input').val('');
                    });
                    $(this).find('input').css("cursor","pointer");
                    $(this).find('input').mousedown(function() {
                        $(this).parents('.input-file').prev().click();
                        return false;
                    });
                    return element;
                }
            }
        );
    }
    $(function() {
        bs_input_file();
    });
    </script>
</body>

</html>