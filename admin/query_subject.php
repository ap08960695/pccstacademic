<?php 
  header('Content-Type: application/json');
	include_once('../condb.php');
  // $upOne = realpath(__DIR__ . '/..');  
  // echo $upOne;
  
  if(isset($_GET["s"])){
    $subject_id = $_GET["s"];
  }
  $sql ="SELECT * FROM subject WHERE code=".$subject_id;
  $result = mysql_query($sql, $conn);
  $row = mysql_fetch_assoc($result);

  $header = [];
  $header[0] ="รายชื่อผู้เข้าร่วมการแข่งขัน งาน จ.ภ.วิชาการ '60 (PCCST ACADEMIC FESTIVAL AND SCIENE FAIR 2017)";
  $header[1] ="รหัส ".$row["code"]." ".$row["name"]." ".$row["level"];
  $header[2] ="สถานที่แข่งขัน ".$row["room1"]." / ".$row["room2"]." / ".$row["room3"]." / ".$row["starttime"];
  
  $sql = "  SELECT * FROM register, school WHERE register.school_id=school.code AND register.subject_id='".$subject_id."'";
    if($student_result = mysql_query($sql, $conn)) {
      $obj_array = [];
      while($row = mysql_fetch_assoc($student_result)) {
        // var_dump($row);
        array_push($obj_array, $row);
      }
    } else {
      echo "err";
    }
    
    $sql = "  SELECT * FROM register_teacher, school WHERE register_teacher.school_id=school.code AND register_teacher.subject_id='".$subject_id."'";
    if($teacher_result = mysql_query($sql, $conn)) {
      $obj_array_t = [];
      while($row = mysql_fetch_assoc($teacher_result)) {
        array_push($obj_array_t, $row);
      }
    } else {
      echo "err";
    }
    if(isset($_GET["option"]) && isset($_GET["s"])){
      if($_GET["option"]=="data") echo json_encode(array( "data"=>$obj_array),JSON_UNESCAPED_UNICODE);
      else if($_GET["option"]=="header") echo json_encode(array( "header"=>$header),JSON_UNESCAPED_UNICODE);
      else echo json_encode(array( "error"=> "wrong_request"),JSON_UNESCAPED_UNICODE);
    }
?>

<html>
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" media="all">
<link href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" media="all">

<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>School</th>
                <th>Province</th>
                <th>Signature</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <!-- <tr><td>1</td><td>1</td><td>1</td><td>1</td><td>1</td></tr> -->
        <?php 
          // for($i=0 ;$i<count($obj_array);$i++) {
          //   echo "<tr>";
          //   echo "<td>".($i+1)."</td>";
          //   echo "<td>".$obj_array[$i]["name"]."</td>";
          //   echo "<td>".$obj_array[$i]["display"]."</td>";
          //   echo "<td>".$obj_array[$i]["changwat"]."</td>";
          //   echo "<td>________________________</td>";
          //   echo "<tr>";
          // }
        ?>
</table>
</html>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script>

$(document).ready(function() {
   $.ajax({
    'url': 'query_subject.php?s='+getUrlParameter('s')+'&option=header',
    dataType: 'json',
    type: 'GET',
    success: function (result) {
      console.log(result)
      var header = result.header;
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
          {
            extend: 'print',
            text: 'Print current page',
            title: "asdf asdf ",
            messageTop: function(data, type, output) {
                return '<img style="display:block;margin-left:auto;margin-right:auto;width:50%;"'+
                         'src="../logopccst.png"/></br><p align="center">'+header[0]+'</br>'+header[1]+'</br>'+header[2]+'</p>';
            },
            exportOptions: {
                columns: ':visible',
            }
     
            }
        ],
        ajax:{
          url: "query_subject.php?s="+getUrlParameter('s')+"&option=data",
        },
        "columns": [
          {"data": "id"},
          {"data": "name"},
          {"data": "display"},
          {"data": "changwat"},
          {"data" : function(data, type, output){
              return "_____________"
            }
          }
        ]
    } );
    }
  });
});

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

</script>