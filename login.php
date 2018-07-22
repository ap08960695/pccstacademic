<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ระบบลงทะเบียนเข้าร่วมการแข่งขันทักษะทางวิชาการ </title>

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
				<h2><small>ระบบลงทะเบียนเข้าร่วมการแข่งขันทักษะทางวิชาการ </small><br>จ.ภ.วิชาการ’60</h2>
				<img src="logopccst.png"></img>
			</center>
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">กรุณาเข้าสู่ระบบ</h3>
                    </div>
                    <?php
                        if(isset($_GET['err']))
                        {
                            if($_GET['err'] == 1)
                            {
                                echo"<div class=\"alert alert-danger alert-dismissable\">";
                                echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                                echo"    Username หรือ Password ของท่านไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง";
                                echo"</div>";
                            }
                        }else if($_GET['act']=="success_register")
                            {
                                echo"<div class=\"alert alert-success alert-dismissable\">";
                                echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                                echo"การสมัครเสร็จสิ้น";
                                echo"</div>";
                        }else if($_GET['act']=="success_reset")
                            {
                                echo"<div class=\"alert alert-success alert-dismissable\">";
                                echo"    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                                echo"การแก้ไขข้อมูลเสร็จสิ้น";
                                echo"</div>";
                            }  
                    ?>
                    <div class="panel-body">
                        <form role="form" action="chklogin.php" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" id="user" name="user" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" id="pass" name="pass" type="password" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
								<div class="form-group">
                                    <input type="submit" class="btn btn-lg btn-success btn-block" value="Login!">
                                </div>
                                <div class="form-group">
									<input type="button" onclick="window.location='register.php'" class="btn btn-lg btn-warning btn-block" value="Register">
								</div>
                                <a href="forgetpass.php" style="color:red">ลืมรหัสผ่าน?</a>
                            </fieldset>
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
