<?php
    include_once('condb.php');

    $code = $_POST["code"];
    $usern = $_POST['usern'];
    $passwd = $_POST['passwd'];
	$cpasswd = $_POST['cpasswd'];
    $name = $_POST['name'];
	$email = $_POST['email'];
    $amper = $_POST["amper"];
	$provide = $_POST["provide"];
	$zip = $_POST["zip"];
	
	if($passwd!=$cpasswd){
		header('Location: forgetpass.php?act=error_pass');
	}else if($usern=="" || $passwd=="" || $cpasswd=="" || $name=="" || $amper=="" || $provide=="" || $zip==""){
		header('Location: forgetpass.php?act=error_empty');
	}else{	
		$sql = "select * from school where (user='".md5($usern)."' or display='$name') AND code<>'$code'";
		$result = mysql_query($sql ,$conn);
		if(mysql_num_rows($result)>0){
			header('Location: forgetpass.php?act=error_same');
		}else{
			$sql = "select * from school where code='$code' and code is not null";
			$result = mysql_query($sql ,$conn);
			if(mysql_num_rows($result)==1){
				$sql = "UPDATE `school` SET user='".md5($usern)."',pass='".md5($passwd)."',display='$name',email='$email',amper='$amper',changwat='$provide',addrcode='$zip' WHERE code='$code'";
				if($result = mysql_query($sql ,$conn)){
					mysql_close($conn);
					header("location:login.php?act=success_reset");
				}else header("location:forgetpass.php?act=error_query");
			}else header('Location: forgetpass.php?act=error_code'); 
			
		}	
	}
?>
