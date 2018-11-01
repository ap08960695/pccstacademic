<?php 
  function scoreDivider($score) {
    $obj_map_score = [0=>"No Medal",50=>"Bronze",60=>"Silver", 80=>"Gold"];
    $setter = "";
    foreach($obj_map_score as $key => $value) {
      if($score>=$key) $setter = $value;
    }
    return $setter;
  }

?>