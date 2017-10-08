<?php
include 'sql/mysql.inc';
include 'inc/tools.inc';
include 'inc/ChartValidator.inc';
include 'sql/Bootgrid/connection.php';
include 'sql/Bootgrid/getcolumns.php';

  if (!is_log()){
    header('location: Index.php');
  }
  CheckRequestLogout();
  navBarCreate('rgb(31,194,222)','Data XY');

  $BreakPoints = 3;

  $outputx = '<tr>';
  $bps = 3;
  for($i = 1; $i < $size; $i+=1){
      $cName = $arr['rows'][$i]['FieldName'];
      $outputx .= '<td><button type="button" class="btn btn-default original-btn" id="x-axis-button'.$i.'" style="width: 100%" disabled><input type="checkbox" value="'.$cName.'" name="'.'x-'.$cName.'" id="'.'x-'.$cName.'" disabled><span style="font-size: 125%;">'.$cName.'</span></input></button></td>';
      if ($i == $size-1){
        $outputx .= '</tr>';
      }
      else if ($i == $bps){
        $outputx .= '</tr><tr>';
        $bps += $BreakPoints;
      }
  }
  $outputy = '<tr>';
  $bps = 3;
  for($i = 1; $i < $size; $i+=1){
      $cName = $arr['rows'][$i]['FieldName'];
      $outputy .= '<td><button type="button" class="btn btn-default original-btn" id="y-axis-button'.$i.'" style="width: 100%" disabled><input type="checkbox" value="'.$cName.'" name="'.'y-'.$cName.'" id="'.'y-'.$cName.'" disabled><span style="font-size: 125%;">'.$cName.'</span></input></button></td>';
      if ($i == $size-1){
        $outputy .= '</tr>';
      }
      else if ($i == $bps){
        $outputy .= '</tr><tr>';
        $bps += $BreakPoints;
      }
  }
?>


<!DOCTYPE html>
<html>
<head>
  <title>DataPage XY</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.3.1/jquery.bootgrid.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.3.1/jquery.bootgrid.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <script src='js/Functions/Link.js'></script>
  <link rel="stylesheet" href="css/datapage.css"/>
  <script src='js/Functions/datapagexy.js'></script>
  <script src='js/Functions/ChartValidator.js'></script>
</head>
<body>

  <div class="box" style=" min-height: 100% !important; height: auto; width: 100vw; margin-top: 50px; ">
    <div class="table-responsive" >


      <table class="table" style="overflow-x:auto; table-layout: fixed;">
        <thead>
          <tr><th><span style="margin-left:5px"> Please select a chart </span></th></tr>
        </thead>
        <tbody id="ChartsList">
        </tbody>

        <thead >
          <tr>
            <th style="width: 100px"><span style="margin-left:5px"> X-Axis </span></th>
          </tr>
        </thead>
        <tbody id="X">
          <?php echo $outputx ?>
        </tbody>

        <thead >
          <tr>
            <th style="width: 100px"><span style="margin-left:5px"> Y-Axis </span></th>
          </tr>
        </thead>
        <tbody id="Y">
          <?php echo $outputy ?>
        </tbody>

      </table>
    </div>

    <div class="input-group" align="center">
      <button class="btn btn-default" type="button" id="buttonadd" onclick="XY_Buttons();" disabled> Create Chart </button>
    </div>
  </div>

</body>
</html>

<script>

//Initialise some values
var size = Number("<?php echo $size;?>");
var chart = '';
var x_select = [size];
var options = {
    FieldName: [size],
    DataType:[size]
};
var colourY;
//set all x_select values as an empty string
for (var i = 0; i < size; i += 1){
  x_select[i] = '';
}
//Transfer all php values to options as an javascript value
"<?php for ($i = 1; $i < $size; $i += 1){?>";
  options.FieldName[Number("<?php echo $i;?>")] = "<?php echo $arr['rows'][$i]['FieldName']?>";
  options.DataType[Number("<?php echo $i;?>")] = "<?php echo $arr['rows'][$i]['DataType']?>";
"<?php } ?>";

var chart_list = ["Scatter plot", "Line Dash", "Bubble", "Bar", "Scatter Line", "Line", "Overlaid Area", "Horizontal Bar", "Pie"];
var BreakPoints = 3;
var bps = 2;
var charts = '<tr>';
for (var i = 0; i < chart_list.length; i+=1) {
  charts += '<td><button type="button" onClick="charts_reset('+i+');" class="btn btn-default original-btn-chart" id="chart'+i+'" style="width: 100%"><input type="radio" value="#" name="chartType"><span style="font-size: 125%;">'+chart_list[i]+'</span></input></button></td>';
  if (i == chart_list.length-1){
    charts += '</tr>';
  }
  else if (i == bps){
    charts += '</tr><tr>';
    bps += BreakPoints;
  }
}
$('#ChartsList').append(charts);

function charts_reset(num){
  for (var i = 0; i < chart_list.length; i+=1){
    if (i != num){
      $('.original-btn-chart').removeClass('active');
    }
  }
  $(".original-btn").removeAttr('disabled');
  for (var i = 1; i < size; i += 1){
    if (!ChartValidate(chart_list[num], 'x', options.DataType[i])){
      $('#x-axis-button' + i).attr('disabled','disabled');
    }
    if (!ChartValidate(chart_list[num], 'y', options.DataType[i])){
      $('#y-axis-button' + i).attr('disabled','disabled');
    }
  }
}
function XY_Buttons(){
  var num_of_columns;
  var XYsize = Number("<?php echo $size; ?>");
  var div = '';
  for (num_of_columns = 1; num_of_columns < XYsize; num_of_columns+=1){
    div += '<th><span class="input-group-btn">';
    div += '';
    div += '<div data-toggle="buttons" style="display:none; important!"><label class="btn btn-default"><input type="checkbox" value="#" disabled><span>Choose As Y</span></input></label></div>';

    //div += '<button class="btn btn-default" type="button" id="X_button_'+num_of_columns+'" disabled> Choose as X </button></br>';
    //div += '<button class="btn btn-default" type="button" id="Y_button_'+num_of_columns+'" disabled> Choose as Y </button>';
    div += '</span></th>';
  }
  $('#XY').append(div);
}

</script>
