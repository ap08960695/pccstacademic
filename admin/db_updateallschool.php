<?php
session_start();
include_once('../condb.php');
include_once('admin_check.php');

$sql = "SELECT * FROM school WHERE status=0 AND running_year = '$running_year'";
$result = mysqli_query($conn, $sql);
$group = $_GET['group'];
while ($row = mysqli_fetch_array($result)) {
	$user = $row['user'];
	$code = Code(8);
	$sql = "UPDATE school SET status=1,code='$code',group_contest='$group' WHERE running_year = '$running_year' AND user='$user';";
	if (!mysqli_query($conn, $sql)) {
		header("location:school.php?act=error_approved");
		exit();
	}
}
header("location:school.php?act=success_approved");
mysqli_close($conn);

function Code($len)
{
	$chars = "ABCDEFGHIJKMNOPGRSTUVWXYZ";
	$nums = "0123456789";
	$i = 0;
	$pass = '';
	srand((float) microtime() * 100000000000);
	while ($i <= $len) {
		if (rand(0, 1) == 1) {
			$num = rand(0, 9);
			$tmp = substr($nums, $num, 1);
		} else {
			$num = rand(0, 25);
			$tmp = substr($chars, $num, 1);
		}
		$pass = $pass . $tmp;
		$i++;
	}
	return $pass;
}
