<?php
    session_start();
    include_once('condb.php');
	include_once('user_check.php');
    $school_code = $school_info["code"];
    $schoolname = $school_info["display"];
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>The Registration System</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    
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
                <a class="navbar-brand" href="index.php">PCCST Academic festival and science fair 2018 - <small><?php echo $schoolname; ?></small></a>
            </div>
            <!-- /.navbar-header -->
			<?php include_once("nav.html");?>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
          <div class="row">
              <div class="col-lg-12">
                  <h1 class="page-header">Setting </h1>
              </div>
              <!-- /.col-lg-12 -->
          </div>
          <!-- /.row -->
          
          <div class="row">
              <div class="col-lg-12">
                  <div class="panel panel-default">
						<div class="panel-heading">
							Edit Profile
						</div>
                      <!-- /.panel-heading -->
						<div class="panel-body">
                          <?php
							
							if($_GET['act']=="update_error"){
									echo"<div class=\"alert alert-danger alert-dismissable\">";
									echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
									echo"Cannot update";
									echo"</div>";
							}else if($_GET['act']=="update_success"){
									echo"<div class=\"alert alert-success alert-dismissable\">";
									echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
									echo"Successfully update";
									echo"</div>";
							}else if($_GET['act']=="error_password"){
									echo"<div class=\"alert alert-danger alert-dismissable\">";
									echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
									echo"Password not same";
									echo"</div>";
							}else if($_GET['act']=="error_same"){
									echo"<div class=\"alert alert-danger alert-dismissable\">";
									echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
									echo"Username or school name is same";
									echo"</div>";
							} 
						?>
						<form role="form" action="db_setting.php" method="post" onsubmit="return confirm('Do you want to update profile?');">
							<div class="row">
								<input type="hidden" name="code" value="<?php echo $row['code']?>">
								<div class="col-md-12 col-lg-12">
									Username  <input type="text" name="username" class="form-control" value=""><br>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-lg-6">
									Password  <input type="password" name="password" class="form-control" value=""><br>
								</div>
								<div class="col-md-6 col-lg-6">
									Comfirm password  <input type="password" name="repassword" class="form-control" value=""><br>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-lg-12">
									School Name <input type="text" name="display" class="form-control" value="<?php echo $row['display']?>"><br>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-lg-12">
									E-mail <input type="text" name="email" class="form-control" value="<?php echo $row['email']?>"><br>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-lg-6">
									District <input type="text" name="district" class="form-control" value="<?php echo $row['amper']?>"><br>
								</div>
								<div class="col-md-6 col-lg-6">
									Province <input type="text" name="province" class="form-control" value="<?php echo $row['changwat']?>"><br>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-lg-6">
									Zipcode <input type="text" name="zip" class="form-control" value="<?php echo $row['addrcode']?>"><br>
								</div>
								<div class="col-md-6 col-lg-6">
									Phone <input type="text" name="phone" class="form-control" value="<?php echo $row['phone']?>"><br>
								</div>
							</div>
							<br>
							<div class="form-group">
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Update">
                            </div>
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
