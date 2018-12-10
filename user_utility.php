<?php 
  function scoreDivider($score) {
    $obj_map_score = [0=>"No Medal",50=>"Bronze",60=>"Silver", 80=>"Gold"];
    $setter = "";
    foreach($obj_map_score as $key => $value) {
      if($score>=$key) $setter = $value;
    }
    return $setter;
  }

  function d_form_str($d_start, $d_end) {
    $date = date_format(date_create($d_start), 'd F Y'); //case 1 day 
    $time_start = date_format(date_create($d_start), 'H:i');
    $time_end = date_format(date_create($d_end), 'H:i');

    return $date." ".$time_start." - ".$time_end;
  }
?>