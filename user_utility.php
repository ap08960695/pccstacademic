<?php 
  function scoreDivider($score) {
    $score = intval($score);
    $score_map = [[80,"Gold medal"],[60,"Silver medal"],[50,"Bronze medal"],[0,"Attended"]];
    $setter = "";
    if($score==-1){
      return "Wait For score";
    }
    for($i=0;$i<count($score_map);$i++) {
      if(intval($score_map[$i][0])<=$score){ 
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

  function check_file_exist($path, $filename){
    return file_exists($path.$filename);
  }
  function check_dir_file_exist($pattern){
  $bool_file = false;
    foreach (glob($pattern) as $filename) {
      if($filename) $bool_file=true;
    }
    return $bool_file;
  }

  function padseven($str) {
    return str_pad($str,7,"0",STR_PAD_LEFT);
  }
?>