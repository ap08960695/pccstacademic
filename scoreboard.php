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
                <a class="navbar-brand" href="index.php">PCCST Academic festival and science fair <?php echo $running_year; ?><small></small></a>
            </div>
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper-nomenu">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <select class="form-control" onchange="reload()">
                            <?php
                            $sql = "SELECT contest_name,code,education FROM contest WHERE running_year = '$running_year' ORDER BY code ASC";
                            $result = mysqli_query_log($conn, $sql);
                            if ($_GET['select'] == "") {
                                echo "<option disabled selected>Choose the contest</option>";
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<option value='" . $row['code'] . "'>" . "(" . $row['code'] . ") " . $row['contest_name'] . " (" . $row['education'] . ")</option>";
                                }
                            } else {
                                echo "<option disabled>Choose the contest</option>";
                                while ($row = mysqli_fetch_array($result)) {
                                    if ($row['code'] == $_GET['select'])
                                        echo "<option value='" . $row['code'] . "' selected>" . "(" . $row['code'] . ") " . $row['contest_name'] . " (" . $row['education'] . ")</option>";
                                    else echo "<option value='" . $row['code'] . "'>" . "(" . $row['code'] . ") " . $row['contest_name'] . " (" . $row['education'] . ")</option>";
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
                if ($select != "") {
                    $sql = "SELECT date_start,date_end FROM contest WHERE running_year = '$running_year' AND code='$select'";
                    $result_contest = mysqli_query_log($conn, $sql);
                    if (mysqli_num_rows($result_contest) > 0) {
                        $row_contest = mysqli_fetch_array($result_contest);

                        $date = date_format(date_create($row_contest['date_start']), 'd M Y');
                        $start_date = date_format(date_create($row_contest['date_start']), 'H:i');
                        $end_date = date_format(date_create($row_contest['date_end']), 'H:i');

                        $sql = "SELECT register.name,school.display,school.changwat,register.subject_id,register.school_id,register.id,register.score FROM register INNER JOIN school ON school.code=register.school_id AND register.running_year = '$running_year' WHERE register.subject_id='$select' AND register.running_year = '$running_year' ORDER BY register.score DESC,school.display ASC";
                        $result_student = mysqli_query_log($conn, $sql);
                        $max_student = mysqli_num_rows($result_student);

                        $sql = "SELECT room_contest.room_name,room_contest.amount_student FROM room_contest WHERE room_contest.contest_code='$select' AND room_contest.running_year = '$running_year'";
                        $result_room = mysqli_query_log($conn, $sql);
                        $row_room = mysqli_fetch_array($result_room);

                        echo '<div class="col-lg-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading"> ';
                        if ($row_contest['date_start'] == "0000-00-00 00:00:00" || $row_contest['date_end'] == "0000-00-00 00:00:00" || $row_room['room_name'] == "")
                            echo "At the place : unspecified";
                        else
                            echo 'At the place : ' . $row_room['room_name'] . ' on ' . $date . ' ' . $start_date . ' - ' . $end_date;
                        echo ', total ' . $max_student;
                        echo '               </div>
                                            <div class="panel-body">';
                        echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>Student name</th>
                                            <th>School name</th>
                                            <th>Awards</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                        $count = $order = 0;
                        $old_score = -1;
                        $order_flag = false;
                        while ($row_student = mysqli_fetch_array($result_student)) {
                            if ($row_student['score'] == "-2" && $order = 0)
                                $order_flag = true;
                            echo "<tr class=\"odd gradeX\">";
                            if ($order_flag) {
                                $order++;
                            } else if ($old_score != $row_student['score']) {
                                if ($count != $order) {
                                    $order = $count + 1;
                                } else $order++;
                            }
                            $count++;
                            echo "    <td>" . ($order) . "</td>";
                            echo "    <td>" . $row_student['name'] . "</td>";
                            echo "    <td>" . $row_student['display'] . "</td>";
                            $cer_file_name = $row_student["subject_id"] . "_" . $row_student["school_id"] . "_" . padseven($row_student["id"]) . ".pdf";
                            echo "<td>";
                            if (check_file_exist($dir_path, $cer_file_name)) {
                                echo '<a href="pccstcer/certfile/' . $cer_file_name . '" target="_blank"';
                                $score = $row_student['score'];
                                if ($score >= 80) {
                                    echo "class='btn btn-warning' return false; style='margin-left:10px' >Gold medal";
                                } else if ($score >= 70) {
                                    echo "class='btn btn-info' return false; style='margin-left:10px'>Silver medal";
                                } else if ($score >= 60) {
                                    echo "class='btn btn-danger' return false; style='margin-left:10px'>Bronze medal";
                                } else {
                                    echo "class='btn btn-default' return false; style='margin-left:10px'>Attended";
                                }
                                echo '</a>';
                            } else if ($row_student['score'] == "-1") {
                                echo 'Absent';
                            } else if ($row_student['score'] == "-2") {
                                echo 'Waiting';
                            }

                            echo "</td>";
                            echo "</tr>";
                            $old_score = $row_student['score'];
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
            location.href = "scoreboard.php?select=" + $('select').val() + "&running_year=<?php echo $running_year ?>";
        }
    </script>

</body>

</html>