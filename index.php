<?php
session_start();
include_once('condb.php');
include_once('user_check.php');
include_once('user_utility.php');
$school_code = $school_info["code"];
$schoolname = $school_info["display"];

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
            <?php include_once("nav.html"); ?>
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
                        <form role="form">
                            <div class="panel-body">
                                <?php
                                echo '<div class="row" >';
                                echo '<label class="col-sm-2 col-form-label">School:</label>';
                                echo '<p class="col-sm-10 col-form-label">' . $school_info["display"] . '</label>';
                                echo '</div>';

                                echo '<div class="row" >';
                                echo '<label class="col-sm-2 col-form-label">Email:</label>';
                                echo '<p class="col-sm-10 col-form-label">' . $school_info["email"] . '</p>';
                                echo '</div>';
                                echo '<div class="row" >';
                                echo '<label class="col-sm-2 col-form-label">District:</label>';
                                echo '<p class="col-sm-10 col-form-label">' . $school_info["amper"] . '</p>';
                                echo '</div>';

                                echo '<div class="row" >';
                                echo '<label class="col-sm-2 col-form-label">Province:</label>';
                                echo '<p class="col-sm-10">' . $school_info["changwat"] . '</p>';
                                echo '</div>';

                                echo '<div class="row" >';
                                echo '<label class="col-sm-2 col-form-label">Zipcode:</label>';
                                echo '<p class="col-sm-10 col-form-label">' . $school_info["addrcode"] . '</p>';
                                echo '</div>';

                                echo '<div class="row">';
                                echo '<label class="col-sm-2 col-form-label">Tel:</label>';
                                echo '<p class="col-sm-10 col-form-label">' . $school_info["phone"] . '</p>';
                                echo '</div>';

                                if ($school_info["country"] == "thailand")
                                    $school_info["country"] = "Thailand";
                                else if ($school_info["country"] == "inter")
                                    $school_info["country"] = "International";
                                else if ($school_info["country"] == "pccst")
                                    $school_info["country"] = "Host";

                                echo '<div class="row">';
                                echo '<label class="col-sm-2 col-form-label">Country:</label>';
                                echo '<p class="col-sm-10 col-form-label">' . $school_info["country"] . '</p>';
                                echo '</div>';

                                ?>
                                <table class="table table-responsive table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Contest Name</th>
                                            <th>Level</th>
                                            <th>Type</th>
                                            <th>Platform</th>
                                            <th>Current Student</th>
                                            <th>Start Date To End Date</th>
                                            <th>Location</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT *,(SELECT COUNT(*) FROM register WHERE school_id='" . $school_info["code"] . "' AND subject_id=contest.code) AS count FROM contest";
                                        $result = mysqli_query($conn, $sql);;
                                        if (mysqli_num_rows($conn, $result) > 1) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                if (intval($row['count']) > 0) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row["contest_name"] . "(" . $row["code"] . ")" . "</td>";
                                                    echo "<td>" . $row["education"] . "</td>";
                                                    echo "<td>" . $row["type"] . "</td>";
                                                    echo "<td>" . $row["platform"] . "</td>";

                                                    echo "<td>" . $row['count'] . "</td>";
                                                    $date = date_format(date_create($row['date_start']), 'd/m/Y');
                                                    $start_date = date_format(date_create($row['date_start']), 'H:i');
                                                    $end_date = date_format(date_create($row['date_end']), 'H:i');

                                                    echo "<td>" . $date . " at " . $start_date . " to " . $end_date . "</td>";

                                                    $sql = "SELECT room.room_name FROM room_contest INNER JOIN room ON room.id=room_contest.room_id WHERE contest_code='" . $row["code"] . "'";
                                                    $result_room = mysqli_query($conn, $sql);;
                                                    echo "<td>";
                                                    if (mysqli_num_rows($result_room) == 0) {
                                                        echo "Location unspecified";
                                                    } else {
                                                        while ($row_room = mysqli_fetch_assoc($result_room)) {
                                                            echo $row_room['room_name'] . "<br>";
                                                        }
                                                    }
                                                }
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