<?php
    session_start();
    include_once('../condb.php');
    $sql = "SELECT meta FROM config WHERE meta='userAdmin' AND value='".md5($_SESSION['user'])."'";
    $result = mysql_query($sql);
	  if(mysql_num_rows($result)!=1){
		header("Location: ../login.php");
		exit();
	  }
	$sql = "SELECT * FROM school WHERE status=0;";
    $result = mysql_query($sql ,$conn);
	$group = $_GET['group'];
	while($row = mysql_fetch_array($result)){
		$user = $row['user'];
		$code = Code(8);
		$sql = "UPDATE school SET status=1,code='$code',group_contest='$group' WHERE user='$user';";
		if(!mysql_query($sql ,$conn)){
			header("location:school.php?act=error_approved");
			exit();
		}	
	}
	header("location:school.php?act=success_approved");
	mysql_close($conn);
	
	function Code($len) { 
		$chars = "ABCDEFGHIJKMNOPGRSTUVWXYZ";
		$nums = "0123456789"; 		
		$i = 0; 
		$pass = '' ; 
		srand((double)microtime()*100000000000); 
		while ($i <= $len) {
			if(rand(0,1)==1){
				$num = rand(0,9); 
				$tmp = substr($nums, $num, 1); 
			}else{
				$num = rand(0,25); 
				$tmp = substr($chars, $num, 1);
			}
			$pass = $pass . $tmp; 
			$i++; 
		}
		return $pass;  
	} 
?>
