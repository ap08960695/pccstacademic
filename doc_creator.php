<?php
  
  function initial_data_school() {
    include(__DIR__."/pccstcer/fpdf.php");
    session_start();
    include_once('condb.php');
    date_default_timezone_set('Asia/Bangkok');
    $sql = "SELECT code FROM  school";
      $result = mysql_query($sql, $conn);
      if(mysql_num_rows($result)>0){
        while($row = mysql_fetch_assoc($result)){
       
          $sql = "SELECT * FROM register WHERE school_id =".$row["code"] ;
          // echo $sql."<br>";
          $result_score = mysql_query($sql, $conn);
          // if(mysql_num_rows($result_score)>0){
            while($row_score = mysql_fetch_assoc($result_score)){
            var_dump($row);
            }
          // } else {
          //   return ;
          // }
        }
      } else {
        return ;
      }
   

  }
  initial_data_school();
  
?>