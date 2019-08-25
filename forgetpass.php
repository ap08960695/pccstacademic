<?php
include_once('condb.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>The Registration System </title>

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
                <?php
                $sql = "SELECT running_year FROM contest GROUP BY running_year";
                $result = mysqli_query($conn, $sql);
                $sql = "SELECT value FROM config WHERE meta='runningYear'";
                $result_config = mysqli_query($conn, $sql);
                $row_config = mysqli_fetch_assoc($result_config);

                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['running_year'] != $row_config['value'])
                        echo '<a class="navbar-brand" href="login.php?running_year=' . $row['running_year'] . '">' . $row['running_year'] . '</a>';
                }
                ?>
            </div>
        </nav>

        <div class="row">
            <center>
                <h2><small>The Academic Registration System </small><br>PCCST Academic festival and science fair <?php echo $running_year; ?></h2>
                <img src="logopccst.png"></img>
            </center>
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-primary" style="    margin-top: 15%;">
                    <div class="panel-heading">
                        <h3 class="panel-title">Edit information of registration</h3>
                    </div>
                    <?php
                    if (isset($_GET['act'])) {
                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                        if ($_GET['act'] == 'error_empty')
                            echo 'Please fill any fields';
                        else if ($_GET['act'] == 'error_pass')
                            echo 'Password does not match';
                        else if ($_GET['act'] == 'error_same')
                            echo 'Username or school name already used';
                        else if ($_GET['act'] == 'error_code')
                            echo 'Have no code';
                        else if ($_GET['act'] == 'error_query')
                            echo 'Cannot edit. Please contact our staff';
                        echo '</div>';
                    }
                    ?>
                    <div class="panel-body">
                        <form role="form" action="db_edit_school.php?running_year=<?php echo $_GET['running_year']; ?>" method="post">
                            Code : <input type="password" name="code" class="form-control" value=""><br>
                            Username : <input type="text" name="usern" class="form-control" value=""><br>
                            Password : <input type="password" name="passwd" class="form-control" value=""><br>
                            Comfirm password : <input type="password" name="cpasswd" class="form-control" value=""><br>
                            <div class="form-group">
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Submit">
                            </div>
                            <div class="form-group">
                                <input type="button" onclick="window.location='login.php'" class="btn btn-lg btn-warning btn-block" value="Back">
                            </div>
                            <div class="form-group">
                                <lable style="color:red">
                                    <br>***If forgot your Code. Please contact our staff
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