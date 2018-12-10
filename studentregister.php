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
                            
                            $sql = "SELECT room.room_name,room.amount_student FROM room_contest INNER JOIN room ON room_contest.room_id=room.id WHERE room_contest.contest_code='$select' ORDER BY room.id";
                            $result_room = mysql_query($sql ,$conn);
                            
                            $sql = "SELECT register.name,school.display,school.changwat FROM register INNER JOIN school ON school.code=register.school_id WHERE register.subject_id='$select' ORDER BY register.id";
                            $result_student = mysql_query($sql ,$conn);
                            $max_student = mysql_num_rows($result_student);
                            
                            $i = 1;
                            while($row_room = mysql_fetch_array($result_room)) {
                                $max_student_room = intval($row_room['amount_student']);    
                                echo '<div class="col-lg-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading"> 
                                                At the place : '.$row_room['room_name'].' on '.$date.' '.$start_date.' - '.$end_date.'
                                            </div>
                                            <div class="panel-body">';
                                echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>Student name</th>
                                            <th>School name</th>
                                            <th>Province</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                $count = 1;
                                while($row_student = mysql_fetch_array($result_student)) {
                                    echo"<tr class=\"odd gradeX\">";
                                    echo"    <td>".($i++)."</td>";
                                    echo"    <td>".$row_student['name']."</td>";
                                    echo"    <td>".$row_student['display']."</td>";
                                    echo"    <td>".$row_student['changwat']."</td>";
                                    echo"</tr>";
                                    $count++;
                                    if($count > $max_student_room){
                                        if($max_student-$i <= 3){
                                            $max_student_room += 3;
                                        }else{
                                            echo '</tbody></table></div></div></div>';
                                            break;
                                        }                
                                    }
                                }            
                            }
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
            location.href = "studentregister.php?select="+$('select').val();
        }
    
    </script>

</body>

</html>
