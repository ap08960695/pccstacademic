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
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
	
    <div class="container">
        <div class="row">
			<center>
				<h2><small>The Academic Registration System </small><br>PCCST Academic festival and sience fair 2018 </h2>
				<img src="logopccst.png"></img>
			</center>
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-primary" style="    margin-top: 15%;">
                    <div class="panel-heading">
                        <h3 class="panel-title">Regist to contest</h3>
                    </div>
                    <?php
						if(isset($_GET['act'])){
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
							if($_GET['act']=='error_empty')
								echo 'กรุณาข้อมูลให้ครบถ้วน';
							else if($_GET['act']=='error_pass')
								echo 'กรุณากรอกรหัสผ่านให้ตรงกัน';
							else if($_GET['act']=='error_same')
								echo 'ชื่อผู้ใช้งานหรือชื่อโรงเรียนถูกใช้แล้ว';
							else if($_GET['act']=='error_query')
								echo 'ไม่สามารถสมัครได้ กรุณาติดต่อเจ้าหน้าที';
							echo '</div>';
						}
					?>
						<div class="panel-body">
							<form role="form" action="db_add_school.php" method="post">
								Username : <input type="text" name="usern" class="form-control" value=""><br>
								Password : <input type="password" name="passwd" class="form-control" value=""><br>
								Comfirm password : <input type="password" name="cpasswd" class="form-control" value=""><br>
								E-mail : <input type="text" name="mail" class="form-control" value=""><br>
						
								School name : <input type="text" name="name" class="form-control" value=""><br>
								District : <input type="text" name="amper" class="form-control" value=""><br>
								Province : <input type="text" name="provide" class="form-control" value=""><br>
								Zipcode : <input type="text" name="zip" class="form-control" value=""><br>
								
								<div class="form-group">
                                    <input type="submit" class="btn btn-lg btn-success btn-block" value="Submit">
                                </div>
								<div class="form-group">
									<input type="button" onclick="window.location='login.php'" class="btn btn-lg btn-warning btn-block" value="Back">
								</div>
								<div class="form-group">
									<lable style="color:red">
									***Please fill every field.
									<br>***After submit , System will approve and open to update data
									</lable>
								</div>
							</form>
						</div>
				</div>
            </div>
        </div>
    </div>

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

