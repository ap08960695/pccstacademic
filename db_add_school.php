<?php
    include_once('condb.php');

    $usern = $_POST['usern'];
    $passwd = $_POST['passwd'];
	$cpasswd = $_POST['cpasswd'];
    $name = $_POST['name'];
	$email = $_POST['mail'];
    $amper = $_POST["amper"];
	$provide = $_POST["provide"];
	$zip = $_POST["zip"];
	$country = $_POST["country"];
	$phone = $_POST["phone"];
	
	if($passwd!=$cpasswd){
		header('Location: register.php?act=error_pass');
	}else if($usern=="" || $passwd=="" || $cpasswd=="" || $name=="" || $amper=="" || $provide=="" || $zip=="" || $country=="" || $phone==""){
		header('Location: register.php?act=error_empty');
	}else{	
		$sql = "select * from school where user='".md5($usern)."' or display='$name'";
		$result = mysql_query($sql ,$conn);
		if(mysql_num_rows($result)>0){
			header('Location: register.php?act=error_same');
		}else{
			$sql = "INSERT INTO `school` (`user`, `pass`, `display`,`email`,`amper`,`changwat`, `addrcode`, `status`,`country`,`phone`) VALUES ('".md5($usern)."', '".md5($passwd)."', '$name','$email','$amper','$provide','$zip', 0,'$country','$phone');";
			if($result = mysql_query($sql ,$conn)){
				mysql_close($conn);
				header("location:login.php?act=success_register");
			}else header("location:register.php?act=error_query");
		}	
	}
?>
