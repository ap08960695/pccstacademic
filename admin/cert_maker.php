<?php

?>

<html></<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Excel Import TO Cert</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>
<body>
  <div class="container" style="height:100%; margin-top:15%;">
    <h1>Purpose for generating files excel to joining student certification </h1>
    <form 
      method="post" 
      action="db_import_excel_cert.php?act=success"
      enctype="multipart/form-data">
        <input type="hidden" class="btn btn-primary" name="MAX_FILE_SIZE" value="30000" />
        <input type="file" class="btn btn-primary" name="myFile"></br>
        <button class="btn btn-primary">Upload</button>
    </form>
  </div>
  </body>
</html>