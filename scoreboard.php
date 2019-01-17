<?php
    include_once('condb.php');
    include_once('user_utility.php');
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
                <a class="navbar-brand" href="index.php">PCCST Academic festival and science fair 2018<small></small></a>
            </div>
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper-nomenu">
          <div class="row">
              <div class="col-lg-12">
                  <h1 class="page-header">
                         <select class="form-control" onchange="reload()">
                            <?php
                                $sql = "SELECT contest_name,code,education FROM contest ORDER BY code ASC";
                                $result = mysql_query($sql ,$conn);
                                if($_GET['select']==""){
                                    echo "<option disabled selected>Choose the contest</option>";
                                    while($row = mysql_fetch_array($result)) {
                                        echo "<option value='".$row['code']."'>"."(".$row['code'].") ".$row['contest_name']." (".$row['education'].")</option>";
                                    }
                                }else{
                                    echo "<option disabled>Choose the contest</option>";
                                    while($row = mysql_fetch_array($result)) {
                                        if($row['code']==$_GET['select'])
                                          echo "<option value='".$row['code']."' selected>"."(".$row['code'].") ".$row['contest_name']." (".$row['education'].")</option>";
                                        else echo "<option value='".$row['code']."'>"."(".$row['code'].") ".$row['contest_name']." (".$row['education'].")</option>";
                                    }
                                }
                            ?> 
                        </select>
                    </h1>
              </div>
              <!-- /.col-lg-12 -->
          </div>
          <!-- /.row -->
          <div class="row">
            <?php
                    $select = $_GET['select'];
                    if($select != ""){
                        $sql = "SELECT date_start,date_end FROM contest WHERE code='$select'";
                        $result_contest = mysql_query($sql ,$conn);
                        if(mysql_num_rows($result_contest)>0){
                            $row_contest = mysql_fetch_array($result_contest);
                            $date = date_format(date_create($row_contest['date_start']), 'd M Y');
                            $start_date = date_format(date_create($row_contest['date_start']), 'H:i');
                            $end_date = date_format(date_create($row_contest['date_end']), 'H:i');
                        
                            $sql = "SELECT register.name,school.display,school.changwat,register.subject_id,register.school_id,register.id,register.score FROM register INNER JOIN school ON school.code=register.school_id WHERE register.subject_id='$select' ORDER BY register.score DESC,school.display ASC";
                            $result_student = mysql_query($sql ,$conn);
                                echo '<div class="col-lg-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading"> 
                                                At the place : '.$date.' '.$start_date.' - '.$end_date.'
                                            </div>
                                            <div class="panel-body">';
                                echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>Student name</th>
                                            <th>School name</th>
                                            <th>Certificate</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                $count = $order = 0;
                                $old_score = -1;
                                while($row_student = mysql_fetch_array($result_student)) {
                                    echo"<tr class=\"odd gradeX\">";
                                    if($old_score!=$row_student['score']){
                                        if($count!=$order){
                                            $order=$count+1;
                                        }else $order++;
                                    }
                                    $count++;   
                                    echo"    <td>".($order)."</td>";
                                    echo"    <td>".$row_student['name']."</td>";
                                    echo"    <td>".$row_student['display']."</td>";
                                    $cer_file_name = $row_student["subject_id"]."_".$row_student["school_id"]."_".padseven($row_student["id"]).".pdf";
                                    echo"<td>";
                                    echo check_file_exist($dir_path,$cer_file_name)?'<a href="pccstcer/certfile/'.$cer_file_name.'" target="_blank" class="btn btn-primary" return false; style="margin-left:10px" >Certificate</a></label>': '';
                                    echo"</td>";
                                    echo"</tr>";
                                    $old_score=$row_student['score'];
                                } 
                                echo '</tbody></table></div></div></div>';
                                                       
                            }
                        }
                        
                    
            ?>
          </div>
          <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    
    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>
 
    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
    <script>
        function checkFilled(inputVal) {
            if (inputVal.value == "") {
                inputVal.style.backgroundColor = "#FFFFFF";
            } else {
                inputVal.style.backgroundColor = "#FFFF99";
            }
        }
        function reload() {
            location.href = "scoreboard.php?select="+$('select').val();
        }
    
    </script>

</body>

</html>
