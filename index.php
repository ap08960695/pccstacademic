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
	} else {
    $school_info = mysql_fetch_assoc($result);
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
                  <h1 class="page-header"> School Information of Contestant</h1>
              </div>
              <!-- /.col-lg-12 -->
          </div>
          <!-- /.row -->
          <div class="row">
              <div class="col-lg-12">
                  <div class="panel panel-default">
                    <form role="form" action="savedata.php" method="post">
						
                      <div class="panel-heading">
						 <h4> School Detail </h4>
                      </div>
                      <!-- /.panel-heading -->
                      <div class="panel-body">
            <div class="row" >
                <div class="col-lg-6" >

                    <?php
                    echo "<div><span class=\"badge badge-info\">school</span>: ".$school_info["display"]."</div>";
                    echo "<div><span class=\"badge badge-info\">Email</span>: ".$school_info["email"]."</div>"  ;
                    echo "<div><span class=\"badge badge-info\">District</span>: ".$school_info["amper"]."</div>" ; 
                    echo "<div><span class=\"badge badge-info\">Province</span>: ".$school_info["changwat"]."</div>";
                    echo "<div><span class=\"badge badge-info\">Zipcode</span>: ".$school_info["addrcode"]."</div>"  ;
                    echo "<div><span class=\"badge badge-info\">No.</span>: ".$school_info["phone"]."</div>"  ;
                    echo "<div><span class=\"badge badge-info\">Country</span>: ".$school_info["country"]."</div>"  ;
                    ?>
                </div>
            </div>
				      <div class="panel-heading">
						 <h4> Contest List Detail of Contestant School </h4>
                      </div>
                
                  <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                  <tr>
                    <th>Contest Name</th>
                    <th>Level</th>
					<th>Type</th>
                    <th>Platform</th>
                    <th>Current Contestant</th>
                    <th>Start Date To End Date</th>
                    <th>Location</th>
                    </tr>
                </thead>
                <tbody>
              <?php 
                // $sql="SELECT c.*,r.*, COUNT(r.subject_id) as counter FROM `contest_group` as cg,`contest` as c , register as r WHERE r.subject_id=cg.contest_code AND cg.contest_code=c.code AND cg.group_name='".$school_info["group_contest"]."' AND r.school_id='".$school_info["code"]."' GROUP BY r.subject_id";
                $sql="SELECT rmc.*, rm.*, c.*,r.*, COUNT(r.subject_id) as counter FROM `contest_group` as cg ";
                $sql.= "LEFT JOIN `contest` as c  ON  cg.contest_code=c.code ";
                $sql.= "LEFT JOIN `register` as r ON r.subject_id=cg.contest_code ";
                $sql.= "LEFT JOIN `room_contest` as rmc on rmc.contest_code = cg.contest_code ";
                $sql.= "LEFT JOIN `room` as rm on rm.id = rmc.room_id ";
                $sql.= "WHERE cg.group_name='".$school_info["group_contest"]."' AND r.school_id='".$school_info["code"]."' GROUP BY r.subject_id";


                $result= mysql_query($sql, $conn);
                if(mysql_num_rows($result)>1) {
                  while($row = mysql_fetch_assoc($result)) {
                    // var_dump($row);
                    echo "<tr>";
                    echo "<td>".$row["contest_name"]."(".$row["subject_id"].")"."</td>" ;
                    echo "<td>".$row["education"]."</td>" ;
                    echo "<td>".$row["type"]."</td>" ;
                    // echo $school_info['group_contest']=="ในประเทศ"?"<td>".$row["person"]."</td>" :"<td>".$row["person_inter"]."</td>";
                    echo "<td>".$row["platform"]."</td>" ;
                    echo "<td>".$row["counter"]."</td>" ;
                    $date_setup = $row["date_start"]=="0000-00-00 00:00:00" && $row["date_end"] == "0000-00-00 00:00:00"?
                                "Not Specified":
                                d_form_str($row["date_start"], $row["date_end"]);
                    echo "<td>".$date_setup."</td>" ;
                    // echo "<td>".$row["room_id"]."</td>" ;
                    echo $row["room_id"]=== NULL?"<td>Location is unavailable</td>":"<td>".$row["room_name"]."</td>" ;
                    echo "</tr>";
                  }
                }
              ?>   
                                
                    </tbody>        
						  
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
