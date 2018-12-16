<?php
    include_once('../condb.php');
    $sql = "SELECT * FROM school";
    if($re = mysql_query($sql ,$conn)){
        $count = 1;
        while($row = mysql_fetch_assoc($re)) {
            $user = "test".intval($count++);
            $sql = "UPDATE school SET user='".md5($user)."',pass='".md5($user)."' WHERE id=".$row['id'];
            mysql_query($sql ,$conn);
        }
	}
    mysql_close($conn);
?>
