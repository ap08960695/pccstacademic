<?php
$sql = "SELECT meta FROM config WHERE (meta='userAdmin' AND value='" . md5($_SESSION['user']) . "') OR (meta='passAdmin' AND value='" . md5($_SESSION['pass']) . "')";
$result = mysqli_query_log($conn, $sql);
if (mysqli_num_rows($result) != 2) {
	mysqli_close($conn);
	header("Location: ../login.php");
	exit();
}
