<?php
  include './sql/mysql.inc';
  if (!is_log()){
    header('location: Index.php');
  }
  if($_SERVER['REQUEST_METHOD'] == "POST") {
    if (is_log()){
      log_out();
      header('location: Index.php');
    }
  }
?>
<!DOCTYPE html>
<html>
<head>

 <title>Chart Type</title>
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="css/bootstrap-theme.min.css">
 <link rel="stylesheet" href="css/style.css">

</head>

<body style="background-image: url('images/backgroundss.png');background-position:right top;background-size:auto 100%;background-repeat: no-repeat; ">

<header id ="titlelogo2">
  <div class="container">
    <div id ="Homebutton"></div>

    <h1> Chart Type </h1>
  </div>
</header>

  <div class= "container1">


      <div align="center">
        <a href="graph.php" style="text-decoration:none">
        <br><input type="image" src="images//piechart.png" name="image" width="180" height="180"><br>
        <h1 style="color:#EF6724;"> Pie Chart </h1> </a>
      </div>



      <div align="center">
          <a href="recorddatapage.php" style="text-decoration:none">
        <br><input type="image" src="images//bargraph.png" name="image" width="180" height="180"><br>
        <h1 style="color:#EF6724;">Bar Chart</h1> </a>
      </div>


      <div align="center">
        <a href="recorddatapage.php" style="text-decoration:none">
        <br><input type="image" src="images//linegraph.png" name="image" width="180" height="180"><br>
        <h1 style="color:#EF6724;">Line Chart</h1>
      </div>

  </div>
</body>
</html>
