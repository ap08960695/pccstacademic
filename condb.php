<?php
$servername = "127.0.0.1";
$username = "root";
$password = "12345678";
$dbname = "pccstaca_pccst";
$dir_path = __DIR__ . "/pccstcer/certfile/";
$dir_temp = __DIR__ . "/pccstcer/temp/";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die('Could not connect: ' . mysqli_error($conn));
}

$cs1 = "SET character_set_results = utf8";
$result = mysqli_query($conn, $cs1);

$cs2 = "SET character_set_client = utf8";
$result = mysqli_query($conn, $cs2);

$cs3 = "SET character_set_connection = utf8";
$result = mysqli_query($conn, $cs3);

$sql = "SELECT value FROM config WHERE meta='runningYear'";
$result = mysqli_query($conn, $sql);
$running_year = date('Y');
while ($row = mysqli_fetch_array($result)) {
    $running_year = $row['value'];
}
if ($_GET['running_year'] != "")
    $running_year = $_GET['running_year'];

date_default_timezone_set('Asia/Bangkok');
