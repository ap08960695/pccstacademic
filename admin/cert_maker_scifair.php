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
          <div class="row">
              <div class="col-lg-12">
                  <div class="panel panel-default">
                      <div class="panel-heading">
                        สร้างเกียรติบัตรสำหรับนักเรียน 
                      </div>
                      <div class="panel-body">
                        <form method="post" action="get_cert_scifair.php"  enctype="multipart/form-data">
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
                        <form method="post" action="get_cert_scifair_teacher.php"  enctype="multipart/form-data">
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