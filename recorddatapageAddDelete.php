<?php
  include 'sql/mysql.inc';
  include 'inc/NavBar.inc';
  include("sql/Bootgrid/connection.php");


  if (!is_log()){
    header('location: Index.php');
  }
  CheckRequestLogout();
//  echo "<header>"rgb(10,191,211);

//  echo "</header>";

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
      if (isset($_POST['title'])){
          $columnNumber = $_POST["columnNumber"];
          $table_name = ($_POST["title"]);
          $aFields = array();
          $dTypes = array();
          for ($i = 1; $i < ($columnNumber + 1); $i+=1){
              if (!empty($_POST["ColumnTitle{$i}"])){
                  array_push($aFields, $_POST["ColumnTitle{$i}"]);
                  array_push($dTypes, $_POST["ColumnType{$i}"]);
              }
          }
          CreateTable($table_name, $aFields, $dTypes);
          include("sql/Bootgrid/gettable.php");
          $latest = $tsize;
          $tID = $tIDsarr['rows'][$latest]['TableID'];
          $_SESSION['tableid'] = $tID;
          echo "<script>window.location.href = 'datapage.php'; </script>";
      }
  }
    navBarCreate('rgb(31,194,222)','Record Data');
?>

<!DOCTYPE html>
<html>
<head>
 <title>Truii Record Page</title>
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="css/bootstrap-theme.min.css">
 <link rel="stylesheet" href="css/style.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script src='js/Functions/Link.js'></script>
 <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
 <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
 <script>
    var columnNumber = 1;
   function addField(){
     columnNumber += 1;
     var i = columnNumber;
     var number = '#Column' + i;
     var div = "<div class=\"container\" id=\"Column" + i + "\" style=\"display:none;opacity:0;margin-right: 10%;margin-left: -10px;margin-top:10px;padding-top: 10px; padding-bottom: 10px;\">";
     div += "<fieldset clase=\"form-box\" id=\"Box" + i + "\" style=\"position: relative; border-radius: 25px;background-color:rgb(10,191,211);opacity:0.8\">";
     div += "<button style=\"position: absolute;right: 10px; top:-15px;text-align: right;\" type=\"button\" onClick=\"deleteField("+ i +");\" class=\"btn btn-primary\" id=\"DeleteColumn"+ i +"\">X</button>";
     div += "<label for=\"exampletextinput\" style=\"color: #FFFFFF;margin-left: 4%; margin-right: 4%;padding-top: 10px;\">Column Title </label>";
     div += "<input type=\"text\" name=\"ColumnTitle" + i + "\" class=\"form-control\" id=\"textinput" + i + "\" style=\"width: 92%; margin-left: 4%; margin-right: 4%;\" aria-describedby=\"tablename\" placeholder=\"Enter Title\" required></br>";
     div += "<div class=\"form-group\" style=\"margin-bottom: 2%;\"><label for=\"exampleSelect1\" style=\"margin-left: 4%; margin-right: 4%;color: #FFFFFF;\">Unit of Measurement</label>";
     div += "<select name=\"ColumnType" + i + "\" class=\"form-control\" id=\"selectinput" + i + "\" style=\"width: 92%; margin-left: 4%; margin-right: 4%;\">";
     div += "<option value=\"VARCHAR(255)\">Text</option><option value=\"INT\"># Numbers</option><option value=\"FLOAT\">% Percentage</option><option value\"DATETIME\">&#128467 DateTime</option></select></div></fieldset>";
     div += "</div>";
     $('#divColumn').append(div);
    $(number).animate({height: 'toggle', display: 'block'}, 500);
    $(number).animate({opacity: 1}, 500);
   }
   function deleteField(column){
     $('#Column' + column).animate({opacity: 0}, 500);
     $('#Column' + column).animate({display:'none', height: 'toggle'}, 500);
     document.getElementById("textinput" + column).required = false;
     document.getElementById("textinput" + column).value = '';
   }

   function Submission(){
      var str = "<input name='columnNumber' style='display:none;' value=" + columnNumber + " type='number'>";
      $('#divButtons').append(str);
      document.getElementById('create_table').click();
   }

 </script>

</head>
<body>

  <form method=POST>
    <div id ="recordform">
      <div class="container1" id="divCreate">
        <div class="form-group" style="margin-right: 10%;">
          <label for="exampletextinput">Title </label>
          <input type="text" name="title" class="form-control" id="xampletextinput" aria-describedby="tablename" placeholder="Enter Title" required>
        </div>
      </div>

      <div class="form-group" id="divColumn" style='margin-top:10px; '>
        <div class="container" id="Column1" style="margin-right: 10%;margin-left: -10px;margin-top:10px;padding-top: 10px; padding-bottom: 20px;">
          <fieldset clase="form-box" id="Box1" style="position: relative; border-radius: 25px;background-color:rgb(10,191,211);opacity:0.8">
            <label for="exampletextinput" style="color: #FFFFFF;margin-left: 4%; margin-right: 4%;padding-top: 10px;">Column Title </label>
            <input type="text" name="ColumnTitle1" class="form-control" id="textinput1" style="width: 92%; margin-left: 4%; margin-right: 4%;" aria-describedby="tablename" placeholder="Enter Title" required></br>
            <div class="form-group" style="margin-bottom: 2%;"><label for="exampleSelect1" style="color: #FFFFFF;margin-left: 4%; margin-right: 4%;">Unit of Measurement</label>
              <select name="ColumnType1" class="form-control" id="selectinput1" style="width: 92%; margin-left: 4%; margin-right: 4%;">
                <option value="VARCHAR(255)">Text</option>
                <option value="INT"># Numbers</option>
                <option value="FLOAT">% Percentage</option>
                <option value"DATETIME">&#128467 DateTime</option>
              </select>
            </div>
          </fieldset>
        </div>
      </div>
      <button type="button" class="btn btn-primary1" onClick="addField();" style="margin-top: 1%; margin-left: 2%;">Add Column</button>
      <div class="form-group" id="divButtons" style = "margin-top: 10px;margin-left: 4%;">
        <button type="button" class="btn btn-primary1" onClick='Submission();' >Submit</button>
        <button type="submit" class="btn btn-primary1" id='create_table' style="display:none;">Submit</button>
      </div>
    </div>
  </form>
</body>
</html>
