<?php
session_start();
include_once('../condb.php');
include_once('admin_check.php');


$user = $_GET['user'];
$group = $_GET['group'];
$code = Code(8);
$sql = "UPDATE school SET status=1,code='$code',group_contest='$group' WHERE running_year = '$running_year' AND user='$user';";
if (mysqli_query($conn, $sql)) {
	header("location:index.php?act=success_approved");
} else {
	header("location:index.php?act=error_approved");
}
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
