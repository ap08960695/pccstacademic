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
                  <h1 class="page-header">The Contest List <small> (Please press save button after fill information)</small></h1>
              </div>
              <!-- /.col-lg-12 -->
          </div>
          <!-- /.row -->
          <div class="row">
              <div class="col-lg-12">
                  <div class="panel panel-default">
                    <!-- <form role="form" action="savedata.php" method="post"> -->
						
                      <div class="panel-heading">
						  Regist to Chulabhorn's Academic Contest <button> print zip</button>
                      </div>
                      <!-- /.panel-heading -->
                      <div class="panel-body">
                        
                      <?php
                      $sql = "SELECT * from contest";
                      $result = mysql_query($sql, $conn);
                      if(mysql_num_rows($result)>0) {
                        while($row = mysql_fetch_assoc($result)) {
                          $sql = "SELECT * FROM register WHERE school_id='".$school_code."' AND subject_id=".$row["code"];
                          $register_result = mysql_query($sql, $conn);
                          if(mysql_num_rows($register_result) >0){
                            echo '<div class="card" style="width: 100rem;">'.
                            '<div class="card-body">'.
                            '<h5 class="card-title">'.$row["contest_name"]."(".$row["code"].")"." ";
                            if($row["date_start"]=="0000-00-00 00:00:00" || $row["date_end"]=="0000-00-00 00:00:00"){
                                echo "| contest Not Start </h5>";
                            }else {
                                $row["date_start"]." to ".$row["date_end"].'</h5>';
                            }
                            echo  "<button>Print</button>";
                            $temp_index = 0;
                            while($register_row = mysql_fetch_assoc($register_result)) {
                              echo "<div>".$register_row["name"]."";
                              // echo $temp_index===0?"<p>".$register_row["score"]."</p>":"";
                              if($temp_index===mysql_num_rows($register_result)-1) {
                                if($register_row["score"]!=NULL) {
                                  echo "".$register_row["score"]." ".scoreDivider($register_row["score"]);
                                } else {
                                  echo " | No Score ";
                                }
                              }
                              echo "</div>";
                              $temp_index+=1;
                            }
                            echo '</div></div>--------------------------------------------------------------';
                          }
                        }
                      }
                      ?> 
             			<!-- </form> -->
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
