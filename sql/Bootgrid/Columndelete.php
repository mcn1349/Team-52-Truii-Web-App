<?php
  //columninsert.php
  include("../mysql.inc");
  include("connection.php");
  include("getcolumns.php");
  if(isset($_POST["operation"]))
  {
      $cName = $_POST['column_selected'];
      DeleteColumn($table, $cName);
      echo 'Column Deleted';
  }
?>
