<?php
    session_start();
    include_once('condb.php');
    date_default_timezone_set('Asia/Bangkok');
    include_once('user_utility.php');
	$sql = "SELECT * FROM school WHERE user='".$_SESSION['user']."' AND code='".$_SESSION['code']."'";
    $result = mysql_query($sql);
	if(mysql_num_rows($result)!=1){
		header("Location: login.php");
		exit();
	}
    $school_code = $_SESSION["code"];
    $schoolname = $_SESSION["display"];
    $dir_path = __DIR__."\\pccstcer\\certfile\\";
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

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrapcard.css" rel="stylesheet">

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
                  <h1 class="page-header">
                    The Contest List 
             <?php
                echo check_dir_file_exist($dir_path."*_".$school_code."_*.pdf")?
                '<a href="zip_getter.php?school='.$school_code.'" target="_blank" class="btn btn-primary" return false; style="margin-left:10px" >Print all certificates</a>':'';
                
             ?>
                  </h1>
              </div>
              <!-- /.col-lg-12 -->
          </div>
            <?php
                
                    
                $sql = "SELECT * from contest";
                $result = mysql_query($sql, $conn);
                while($row = mysql_fetch_assoc($result)) {
                    $sql = "SELECT * FROM register WHERE school_id='".$school_code."' AND subject_id=".$row["code"];
                    $register_result = mysql_query($sql, $conn);        
                    if(mysql_num_rows($register_result)>0){
                        if($row["date_start"]=="0000-00-00 00:00:00" || $row["date_end"]=="0000-00-00 00:00:00"){
                            $date_str = "Date unspecified";
                        }else {
                            $date = date_format(date_create($row['date_start']), 'd M Y');
                            $start_date = date_format(date_create($row['date_start']), 'H:i');
                            $end_date = date_format(date_create($row['date_end']), 'H:i');
                            $date_str = ", ".$date." at ".$start_date." to ".$end_date;
                        }
                        echo '<div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        '.$row["contest_name"].'('.$row["code"].') '.$date_str;
                        echo check_dir_file_exist($dir_path.$row["code"]."_".$school_code."_*.pdf")?
                        ' <a href="zip_getter.php?school='.$school_code.'&&subject='.$row["code"].'" target="_blank" class="btn btn-primary" return false; style="margin-left:10px" >Print Certificates</a>':'';
                        echo '    </div>
                                    <div class="panel-body">';
                            
                        while($register_row = mysql_fetch_assoc($register_result)){
                            $cer_file_name = $row["code"]."_".$register_row["school_id"]."_".padseven($register_row["id"]).".pdf";
                            echo '<div class="row">';
                            echo '<p class="col-sm-4 col-form-label">'.$register_row['name'].'</p>';
                            echo '<p class="col-sm-3 col-form-label">'.scoreDivider($register_row["score"]).'</label>';
                            echo '<p class="col-sm-3 col-form-label">';
                            echo check_file_exist($dir_path,$cer_file_name)?
                            '<a href="pccstcer/certfile/'.$cer_file_name.'" target="_blank" class="btn btn-primary" return false; style="margin-left:10px" >Certificate</a></label>': '';
                            echo '</div>';  
                        }
                        echo "</div></div></div></div>";
                    }            
                    
                }
            ?> 
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
