<?php 
  function scoreDivider($score) {
    $score_map = [[80,"Gold"],[60,"Silver"],[50,"Bronze"],[0,"Participate"]];
    $setter = "";
    for($i=0;$i<count($score);$i++) {
      if($score_map[$i][0]<=$score){ 
        $setter = $score_map[$i][1];
        break;
      }
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