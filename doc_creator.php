<?php

function initial_data_school()
{
  include(__DIR__ . "/pccstcer/fpdf.php");
  session_start();
  include_once('condb.php');
  $sql = "SELECT code FROM  school WHERE running_year = '$running_year'";
  $result = mysqli_query($conn, $sql);;
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

      $sql = "SELECT * FROM register WHERE running_year = '$running_year' AND school_id =" . $row["code"];
      // echo $sql."<br>";
      $result_score = mysqli_query($conn, $sql);;
      // if(mysqli_num_rows($result_score)>0){
      while ($row_score = mysqli_fetch_assoc($result_score)) {
        var_dump($row);
      }
      // } else {
      //   return ;
      // }
    }
  } else {
    return;
  }
}
initial_data_school();
