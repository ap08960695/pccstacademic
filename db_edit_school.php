<?php
    include_once('condb.php');

    $code = $_POST["code"];
    $usern = $_POST['usern'];
    $passwd = $_POST['passwd'];
	$cpasswd = $_POST['cpasswd'];
	
	if($passwd!=$cpasswd){
		header('Location: forgetpass.php?act=error_pass');
	}else if($usern=="" || $passwd=="" || $cpasswd==""){
		header('Location: forgetpass.php?act=error_empty');
	}else{	
		$sql = "select * from school where user='".md5($usern)."' AND code<>'$code'";
		$result = mysql_query($sql ,$conn);
		if(mysql_num_rows($result)>0){
			header('Location: forgetpass.php?act=error_same');
		}else{
			$sql = "select * from school where code='$code' and code is not null";
			$result = mysql_query($sql ,$conn);
			if(mysql_num_rows($result)==1){
				$sql = "UPDATE `school` SET user='".md5($usern)."',pass='".md5($passwd)."' WHERE code='$code'";
				if($result = mysql_query($sql ,$conn)){
					mysql_close($conn);
					header("location:login.php?act=success_reset");
				}else header("location:forgetpass.php?act=error_query");
			}else header('Location: forgetpass.php?act=error_code'); 
			
		}	
	}
?>
