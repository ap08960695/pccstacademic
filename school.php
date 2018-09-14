<?php
    include_once('condb.php');
	date_default_timezone_set('Asia/Bangkok');
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
                <a class="navbar-brand" href="index.html">PCCST Academic festival and science fair 2018<small></small></a>
            </div>
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper-nomenu">
          <div class="row">
              <div class="col-lg-12">
                  <h1 class="page-header">The school list</h1>
              </div>
              <!-- /.col-lg-12 -->
          </div>
          <!-- /.row -->
          <div class="row">
            <?php
                $sql = "SELECT display,amper,changwat,addrcode,status,code FROM school ORDER BY id";
                $result = mysql_query($sql ,$conn);
                while($row = mysql_fetch_array($result)) {
                    echo '<div class="col-lg-12">';
                        echo '<div class="panel panel-default">';
                            echo '<div class="panel-heading">';
                                echo $row['display'];
                                if($row['status']=='1'){
                                    echo " (Approved)";
                                }else echo "(Waiting for approval)";
                            echo '</div>';                
                            echo '<div class="panel-body">';
                                echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">';
                                    echo '<thead>
                                            <tr>
                                                <th>Order</th>
                                                <th>Student Name</th>
                                                <th>Contest</th>
                                            </tr>
                                        </thead>';
                                    echo '<tbody>';
                                    $sql = "SELECT register.name,contest.contest_name,contest.code,contest.education,contest.type FROM register INNER JOIN contest ON contest.code=register.subject_id WHERE register.school_id='".$row['code']."' ORDER BY register.id";
                                    $result_std = mysql_query($sql ,$conn);
                                    $i=1;
                                    if($result_std && mysql_num_rows($result_std)>0){
                                        while($row_std = mysql_fetch_array($result_std)) {
                                            echo"<tr class=\"odd gradeX\">";
                                            echo"    <td>".($i++)."</td>";
                                            echo"    <td>".$row_std['name']."</td>";
                                            echo"    <td>".$row_std['code']." ".$row_std['contest_name']."(".$row_std['education']." ".$row_std['type'].")</td>";
                                            echo"</tr>";
                                        }                        
                                    }
                                    echo '</tbody>';
                                echo '</table>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                }            
                ?>
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