<?php

$sql = "SELECT * FROM school WHERE running_year = '$running_year' AND user = '" . $_SESSION['user'] . "' AND code = '" . $_SESSION['code'] . "' AND status = 1;";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) != 1) {
	header("Location: login.php");
	exit();
} else {
	$school_info = mysqli_fetch_assoc($result);
}
