<?php
session_start();
include_once('../condb.php');
include_once('admin_check.php');
?>

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
          <h1 class="page-header">เกียรติบัตร SCI-FAIR</h1>
        </div>
        <!-- /.col-lg-12 -->
      </div>
      <?php
      if ($_GET['act'] == "success_add") {
        echo "<div class=\"alert alert-success alert-dismissable\">";
        echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
        echo "เพิ่มรายการสำเร็จ ";
        echo "</div>";
      } else if ($_GET['act'] == "error_add") {
        echo "<div class=\"alert alert-danger alert-dismissable\">";
        echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
        echo "ไม่สามารถเพิ่มรายการได้";
        echo "</div>";
      } else if ($_GET['act'] == "error_empty") {
        echo "<div class=\"alert alert-danger alert-dismissable\">";
        echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
        echo "กรุณากรอกข้อมูลให้ครบถ้วน";
        echo "</div>";
      } else if ($_GET['act'] == "success_update") {
        echo "<div class=\"alert alert-success alert-dismissable\">";
        echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
        echo "ปรับปรุงรายการสำเร็จ";
        echo "</div>";
      } else if ($_GET['act'] == "error_update") {
        echo "<div class=\"alert alert-danger alert-dismissable\">";
        echo "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
        echo "ปรับปรุงรายการไม่สำเร็จ";
        echo "</div>";
      }
      ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              สร้างเกียรติบัตรสำหรับนักเรียน
            </div>
            <div class="panel-body">
              <form method="post" action="get_cert_scifair_file.php" enctype="multipart/form-data">
                <div class="form-group">
                  <div class="input-group input-file" name="myFile">
                    <span class="input-group-btn">
                      <button class="btn btn-default btn-choose" type="button">Choose</button>
                    </span>
                    <input type="text" class="form-control" placeholder="Choose a file..." />
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-success pull-right">Upload</button>
                    </span>
                  </div>
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
              สร้างเกียรติบัตรสำหรับครู
            </div>
            <div class="panel-body">
              <form method="post" action="get_cert_scifair_teacher_file.php" enctype="multipart/form-data">
                <div class="form-group">
                  <div class="input-group input-file" name="myFile">
                    <span class="input-group-btn">
                      <button class="btn btn-default btn-choose" type="button">Choose</button>
                    </span>
                    <input type="text" class="form-control" placeholder="Choose a file..." />
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-success pull-right">Upload</button>
                    </span>
                  </div>
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
              เพิ่มรายชื่อผู้เข้าร่วมแข่งขัน(Student)
              <?php
              echo "<a href=\"get_cert_scifair.php?type=student\" onclick=\"return confirm('คุณต้องการสร้างใบเกียรติบัตร ใช่หรือไม่?');\" class=\"btn btn-warning\" >Gen Certification</a>";
              ?>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
              <form role="form" action="db_add_register_scifair.php?type=student" method="post" onsubmit="return confirm('คุณต้องการเพิ่มผู้เข้าร่วมใหม่ ใช่หรือไม่?');">
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    ชื่อผู้เข้าร่วม <input type="text" name="register_name" class="form-control" value=""><br>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    โรงเรียน <input class="form-control" type="text" name='register_school' value="" /><br>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    รางวัล <input type="text" name="register_reward" class="form-control" value=""><br>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    วิชา <input type="text" name="register_subject" class="form-control" value=""><br>
                  </div>
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-lg btn-success btn-block" value="เพิ่มผู้เข้าร่วมการแข่งขัน">
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
              Record of Scifair contest(Student)
            </div>
            <div class="panel-body">
              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                  <tr>
                    <th></th>
                    <th>Name</th>
                    <th>School name</th>
                    <th>Subject</th>
                    <th>Reward</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT * FROM register_scifair WHERE running_year = '$running_year' AND type='student' ORDER BY school_name DESC";
                  $result = mysqli_query_log($conn, $sql);
                  if (mysqli_num_rows($result) > 0) {
                    $i = 1;
                    while ($row = mysqli_fetch_array($result)) {
                      echo "<tr class=\"odd gradeX\"><form role=\"form\" action=\"db_edit_register_scifair.php?type=student\" onsubmit=\"return confirm('คุณต้องการจะปรับปรุง " . $row['name'] . " ใช่หรือไม่?');\" method=\"post\">";
                      echo "    <td>" . ($i++) . "</td>";
                      echo "    <td><input class='form-control' type='text' name='register_name' value='" . $row['name'] . "'/></td>";
                      echo "    <td><input class='form-control' type='text' name='register_school' value='" . $row['school_name'] . "'/></td>";
                      echo "    <td><input class='form-control' type='text' name='register_subject' value='" . $row['subject'] . "'/></td>";
                      echo "    <td><input class='form-control' type='text' name='register_reward' value='" . $row['reward'] . "'/></td>";
                      echo "    <td style='width: 10px;'><input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\"><input type=\"submit\" class=\"btn btn-success\" value=\"Update\"></form></td>";
                      echo "    <td style='width: 10px;'><form role=\"form\" action=\"db_del_register_scifair.php?type=student\" onsubmit=\"return confirm('คุณต้องการจะลบ " . $row['name'] . " ใช่หรือไม่?');\" method=\"post\"><input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\"><input type=\"submit\" class=\"btn btn-danger\" value=\"X\"></form></td>";
                      echo "</tr>";
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              เพิ่มรายชื่อผู้เข้าร่วมแข่งขัน(Teacher)
              <?php
              echo "<a href=\"get_cert_scifair.php?type=teacher\" onclick=\"return confirm('คุณต้องการสร้างใบเกียรติบัตร ใช่หรือไม่?');\" class=\"btn btn-warning\" >Gen Teacher Certification</a>";
              ?>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
              <form role="form" action="db_add_register_scifair.php?type=teacher" method="post" onsubmit="return confirm('คุณต้องการเพิ่มผู้เข้าร่วมใหม่ ใช่หรือไม่?');">
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    ชื่อผู้เข้าร่วม <input type="text" name="register_name" class="form-control" value=""><br>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    โรงเรียน <input class="form-control" type="text" name='register_school' value="" /><br>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    รางวัล <input type="text" name="register_reward" class="form-control" value=""><br>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    วิชา <input type="text" name="register_subject" class="form-control" value=""><br>
                  </div>
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-lg btn-success btn-block" value="เพิ่มผู้เข้าร่วมการแข่งขัน">
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
              Record of Scifair contest(Teacher)
            </div>
            <div class="panel-body">
              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                  <tr>
                    <th></th>
                    <th>Name</th>
                    <th>School name</th>
                    <th>Subject</th>
                    <th>Reward</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT * FROM register_scifair WHERE running_year = '$running_year' AND type='teacher' ORDER BY school_name DESC";
                  $result = mysqli_query_log($conn, $sql);
                  if (mysqli_num_rows($result) > 0) {
                    $i = 1;
                    while ($row = mysqli_fetch_array($result)) {
                      echo "<tr class=\"odd gradeX\"><form role=\"form\" action=\"db_edit_register_scifair.php?type=teacher\" onsubmit=\"return confirm('คุณต้องการจะปรับปรุง " . $row['name'] . " ใช่หรือไม่?');\" method=\"post\">";
                      echo "    <td>" . ($i++) . "</td>";
                      echo "    <td><input class='form-control' type='text' name='register_name' value='" . $row['name'] . "'/></td>";
                      echo "    <td><input class='form-control' type='text' name='register_school' value='" . $row['school_name'] . "'/></td>";
                      echo "    <td><input class='form-control' type='text' name='register_subject' value='" . $row['subject'] . "'/></td>";
                      echo "    <td><input class='form-control' type='text' name='register_reward' value='" . $row['reward'] . "'/></td>";

                      echo "    <td style='width: 10px;'><input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\"><input type=\"submit\" class=\"btn btn-success\" value=\"Update\"></form></td>";
                      echo "    <td style='width: 10px;'><form role=\"form\" action=\"db_del_register_scifair.php?type=teacher\" onsubmit=\"return confirm('คุณต้องการจะลบ " . $row['name'] . " ใช่หรือไม่?');\" method=\"post\"><input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\"><input type=\"submit\" class=\"btn btn-danger\" value=\"X\"></form></td>";
                      echo "</tr>";
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</body>

</html>
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
        if (!$(this).prev().hasClass('input-ghost')) {
          var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
          element.attr("name", $(this).attr("name"));
          element.change(function() {
            element.next(element).find('input').val((element.val()).split('\\').pop());
          });
          $(this).find("button.btn-choose").click(function() {
            element.click();
          });
          $(this).find("button.btn-reset").click(function() {
            element.val(null);
            $(this).parents(".input-file").find('input').val('');
          });
          $(this).find('input').css("cursor", "pointer");
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