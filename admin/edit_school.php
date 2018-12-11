<?php
    session_start();
    include_once('../condb.php');
    date_default_timezone_set('Asia/Bangkok');
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
    <link href="../vendor/bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    
	<!-- tagsinput CSS -->
    <link href="../vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
    
	<!-- typeahead CSS -->
    <link href="../vendor/typeahead/typeahead.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="wrapper">

        <!-- Navigation -->
        <?php
			include_once("nav_admin.html");
			$sql = "SELECT * FROM school WHERE code='".$_GET['code']."'";
			$result = mysql_query($sql ,$conn);
			$row_school = mysql_fetch_array($result);					
		?>
        

        <!-- Page Content -->
        <div id="page-wrapper">
          <div class="row">
              <div class="col-lg-12">
                  <h1 class="page-header">โรงเรียน </h1>
              </div>
              <!-- /.col-lg-12 -->
          </div>
          <!-- /.row -->
          <div class="row">
              <div class="col-lg-12">
                  <div class="panel panel-default">
						<div class="panel-heading">
							แก้ไขข้อมูลโรงเรียน
						</div>
                      <!-- /.panel-heading -->
						<div class="panel-body">
						<?php 
							if($_GET['act']=="error_edit"){
									echo"<div class=\"alert alert-danger alert-dismissable\">";
									echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
									echo"ไม่สามารถแก้ไขข้อมูลได้";
									echo"</div>";
							}
						?>
						<form role="form" action="db_edit_school.php" method="post" onsubmit="return confirm('คุณต้องข้อมูลโรงเรียนนี้ ใช่หรือไม่?');">
							<div class="row">
								<input type="hidden" name="school_code" class="form-control" value="<?php echo $_GET['code']?>">
								<div class="col-md-8 col-lg-5">
									ชื่อโรงเรียน  <input type="text" name="school_display" class="form-control" value="<?php echo $row_school['display']?>"><br>
								</div>
								<div class="col-md-6 col-lg-3">
									E-mail  <input type="text" name="school_email" class="form-control" value="<?php echo $row_school['email']?>"><br>
								</div>
								<div class="col-md-6 col-lg-2">
									เบอร์ติดต่อ  <input type="text" name="school_phone" class="form-control" value="<?php echo $row_school['phone']?>"><br>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-lg-3">
									อำเภอ  <input type="text" name="school_amper" class="form-control" value="<?php echo $row_school['amper']?>"><br>
								</div>
								<div class="col-md-3 col-lg-3">
									จังหวัด   <input type="text" name="school_changwat" class="form-control" value="<?php echo $row_school['changwat']?>"><br>
								</div>
								<div class="col-md-3 col-lg-3">
								รหัสไปรษณีย์  <input type="text" name="school_zip" class="form-control" value="<?php echo $row_school['addrcode']?>"><br>
								</div>
								
							</div>
							<div class="form-group">
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="แก้ไข">
                            </div>
							</form>
						</div>
					</div>
				</div>
			</div>
		  </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	
    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/moment/moment.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../vendor/bootstrap/js/transition.js"></script>
	<script src="../vendor/bootstrap/js/collapse.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
	
	<!-- typeahead Plugin JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
	<script src="../vendor/typeahead/handlebars.js"></script>
    
	<!-- tagsinput Plugin JavaScript -->
	<script src="../vendor/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
	
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
		
	<!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
	<script>
	$(document).ready(function(){
		 $('.datepicker').datetimepicker({
			locale: 'th',
			format: 'DD/MM/YYYY HH:mm'
		 });

		var room = new Bloodhound({
		  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('room_name'),
		  queryTokenizer: Bloodhound.tokenizers.whitespace,
		  prefetch: 'db_getroom.php'
		});
		room.clearPrefetchCache();
		room.initialize();
	
		$('#tagsinput').tagsinput({
			itemValue: 'room_id',
			itemText: 'room_name',
			typeaheadjs: {
				name: 'cities',
				displayKey: 'room_name',
				source: room.ttAdapter(),
				templates: {
				empty: [
				  '<div class="row">',
					'<div class="col-lg-12" style="padding: 5px 20px;text-align: center;">',
						'ไม่มีสถานทีแข่งขันในระบบ',
					'</div>',
				  '</div>'
				].join('\n'),
				suggestion: Handlebars.compile('<div><strong>{{room_name}}</strong><div class="limit-student">ขนาด  {{limit_student}} คน</div></div>')
			  }
		  }
		});
		$(".bootstrap-tagsinput").addClass('form-control');
	});
    </script>

</body>
</html>