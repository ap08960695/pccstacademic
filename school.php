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
                  <h1 class="page-header">The school list</h1>
              </div>
              <!-- /.col-lg-12 -->
          </div>
          <!-- /.row -->
          <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        School List
                    </div>                
                    <div class="panel-body">
                        <select class="form-control" onchange="reload()">
                            <?php
                                $sql = "SELECT display,id FROM school ORDER BY id";
                                $result = mysql_query($sql ,$conn);
                                if($_GET['select']==""){
                                    echo "<option disabled selected>Choose school</option>";
                                    while($row = mysql_fetch_array($result)) {
                                        echo "<option value='".$row['id']."'>".$row['display']."</option>";
                                    }
                                }else{
                                    echo "<option disabled>Choose school</option>";
                                    while($row = mysql_fetch_array($result)) {
                                        if($row['id']==$_GET['select'])
                                          echo "<option value='".$row['id']."' selected>".$row['display']."</option>";
                                        else echo "<option value='".$row['id']."'>".$row['display']."</option>";
                                    }
                                }
                            ?> 
                        </select>
                    </div>
                </div>
                <?php
                if($_GET['select']!=""){
                    $sql = "SELECT display,id,status,code FROM school WHERE id='".$_GET['select']."'";
                    $result = mysql_query($sql ,$conn);
                    $row = mysql_fetch_array($result);
                    echo '<div class="col-lg-12">';
                        echo '<div class="panel panel-default">';
                            echo '<div class="panel-heading">';
                                echo $row['display'];
                                    if($row['status']=='1'){
                                        echo " (Approved)";
                                    }else echo " (Waiting for approval)";
                                echo '</div>';                
                                echo '<div class="panel-body">';
                                    echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">';
                                        echo '<thead>
                                                <tr>
                                                    <th>Order</th>
                                                    <th>Student Name</th>
                                                    <th>Contest</th>
                                                    <th>Teacher</th>
                                                </tr>
                                            </thead>';
                                        echo '<tbody>';
                                        if($row['code']!=""){
                                            $sql = "SELECT register.name,contest.contest_name,contest.code,contest.education,contest.type,register.school_id,register.subject_id,register.id FROM register INNER JOIN contest ON contest.code=register.subject_id WHERE register.school_id='".$row['code']."' ORDER BY register.id";
                                            $result_std = mysql_query($sql ,$conn);
                                            $i=1;
                                            if($result_std && mysql_num_rows($result_std)>0){
                                                while($row_std = mysql_fetch_array($result_std)) {
                                                    echo"<tr class=\"odd gradeX\">";
                                                    echo"    <td>".($i++)."</td>";
                                                    echo"    <td>";
                                                    echo  $row_std['name'];
                                                    $cer_file_name = $row_std["subject_id"]."_".$row_std["school_id"]."_".padseven($row_std["id"]).".pdf";
                                                    echo check_file_exist($dir_path,$cer_file_name)?
                                                    '<a href="pccstcer/certfile/'.$cer_file_name.'" target="_blank" class="btn btn-primary" return false; style="margin-left:10px" >Certificate</a></label>': '';
                                                    
                                                    echo "</td>";
                                                    echo"    <td>".$row_std['code']." ".$row_std['contest_name']."(".$row_std['education']." ".$row_std['type'].")</td>";
                                                    echo"    <td>";
                                                    $sql = "SELECT id,name FROM register_teacher WHERE school_id='".$row['code']."' AND subject_id='".$row_std['code']."'";
                                                    $result_teacher = mysql_query($sql ,$conn);
                                                    if($result_teacher && mysql_num_rows($result_teacher)>0){
                                                        while($row_teacher = mysql_fetch_array($result_teacher)) {
                                                            echo $row_teacher['name'];
                                                            
                                                            $cer_file_name = "teacher_".$row_std["subject_id"]."_".$row_std["school_id"]."_".padseven($row_teacher["id"]).".pdf";
                                                            echo check_file_exist($dir_path,$cer_file_name)?'<a href="pccstcer/certfile/'.$cer_file_name.'" target="_blank" class="btn btn-primary" return false; style="margin-left:10px" >Certificate</a></label>': '';
                                                            echo "<br>";
                                                        }
                                                    }
                                                    echo"</td>";
                                                    echo"</tr>";
                                                }                        
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
        function reload() {
            location.href = "school.php?select="+$('select').val();
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
