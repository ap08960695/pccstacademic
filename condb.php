<?php
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "pccstaca_pccst";

// Create connection
//$conn = new mysqli($servername, $username, $password, $dbname);
$conn = mysql_connect($servername, $username, $password);
if (!$conn) {
    die('Could not connect: ' . mysql_error());
}
$selectdb = mysql_select_db($dbname, $conn);
if (!$selectdb) {  
    die ('blog not selected : ' . mysql_error());  
}  

// Check connection
/*
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
*/

$cs1 = "SET character_set_results = utf8";
$result = mysql_query($cs1);

$cs2 = "SET character_set_client = utf8";
$result = mysql_query($cs2);

$cs3 = "SET character_set_connection = utf8";
$result = mysql_query($cs3);

?>
