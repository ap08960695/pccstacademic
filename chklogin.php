<?php
      session_start();
      include_once('condb.php');
	  $sql = "SELECT meta FROM config WHERE (meta='userAdmin' AND value='".md5($_POST['user'])."') OR (meta='passAdmin' AND value='".md5($_POST['pass'])."')";
      $result = mysql_query($sql);
	  if(mysql_num_rows($result)==2){
		$_SESSION['user'] = $_POST['user'];
		header("Location: admin/");
		exit();
	  }
	  $sql = "SELECT user,code,display FROM school WHERE user = '".md5($_POST['user'])."' AND pass = '".md5($_POST['pass'])."' AND status = 1;";
      $result = mysql_query($sql);
      if (mysql_num_rows($result) > 0) {
          while($row = mysql_fetch_array($result)) {
				$_SESSION['user'] = $row['user'];
				$_SESSION['code'] = $row['code'];
				$_SESSION['display'] = $row['display'];
				header("Location: index.php");  
              exit();
          }
      } else {
          header("Location: login.php?err=1");
          exit();
      }
?>
