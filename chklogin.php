<?php
      session_start();
      include_once('condb.php');
      $sql = "SELECT user,code,display FROM school WHERE user = '".$_POST['user']."' AND pass = '".$_POST['pass']."' AND status = 1;";
      $result = mysql_query($sql);
	  //echo $sql;
      if (mysql_num_rows($result) > 0) {
          while($row = mysql_fetch_array($result)) {
              $_SESSION['user'] = $row['user'];
              $_SESSION['code'] = $row['code'];
              $_SESSION['display'] = $row['display'];
			  if($_SESSION['user'] == "acf001")
				header("Location: index_pccst.php");
			  else
				header("Location: index.php");  
              exit();
          }
      } else {
          header("Location: login.php?err=1");
          exit();
      }
?>
