<?php
  include 'sql/mysql.inc';
  include 'inc/tools.inc';
  include 'inc/styles_and_scripts.inc';

  CheckMobile();

  if (!is_log()){
    gotoPage('Index');
  }
  CheckRequestLogout();
  navBarCreate('rgb(252, 103, 25)', 'Home');
?>
<!DOCTYPE html>
<html>
<head>

 <title>Truii Home</title>
 <br/>

</head>
<body>




  <div id ="Homebutton">
    <div class= "container" style="margin-top: 70px">
      <div class="row" style="margin: 0">
        <div class="col">

          <div align="center">
            <a href='previousgraphpage.php' style="text-decoration:none;">
              <input type="image" src="images//graphmarker.png" name="image" style="width: 225px; height: 150px"><br>
              <h1 style="color:#EF6724;" style='margin-left:5%;'> <b style="font-size: 150%;">Chart Marker</b> </h1>
            </a>
          </div>

        </div>
      </div>
      <div class="row" style="margin: 0">
        <div class="col">

          <div align="center">
            <a href='recorddatapageAddDelete.php' style="text-decoration:none;">
              <br><input type="image" src="images//recorddata.png" name="image" style="width: 225px; height: 150px"><br>
              <h1 style="color:#0ABFDD;" style='margin-left:5%;'> <b style="font-size: 150%;">Record Data</b> </h1>
            </a>
          </div>

        </div>
      </div>
    </div>
  </div>
</body>
</html>
