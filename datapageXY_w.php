<?php
include 'sql/mysql.inc';
include 'inc/tools.inc';
include 'inc/ChartValidator.inc';
include 'sql/Bootgrid/connection.php';
include 'sql/Bootgrid/getcolumns.php';

  if (!is_log()){
    header('location: Index');
  }
  CheckRequestLogout();
  navBarCreate('rgb(31,194,222)','Data XY');

  $BreakPoints = 3;

  $outputx = '<tr>';
  $bps = 3;

  $outputy = '<tr>';
  $bps = 3;
  for($i = 1; $i < $size; $i+=1){
      $cName = $arr['rows'][$i]['FieldName'];
      $outputy .= '<td><button onClick="y_selection('.$i.');" class="btn btn-default original-btn-y" value="'.$cName.'" name="'.'x-'.$cName.'" id="y-axis-button'.$i.'" style="width: 100%" disabled><span style="font-size: 125%;" disabled>'.$cName.'</span></button></td>';
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


      <table class="table"  style="overflow-x:auto; table-layout: fixed;">
        <thead id="title-chart">
          <tr><th><span style="margin-left:5px" id='title'> Please select a chart </span></th></tr>
        </thead>
        <tbody id="table-button">
        </tbody>
      </table>
    </div>
    <div class="input-group" style="width: 100%;" align="center">
      <button class="btn btn-default" type="button" id="buttonback" style="float: left" onclick="back();" disabled> Back </button>
      <button class="btn btn-default" type="button" id="buttonadd" style="float: right" onclick="next();" disabled> Next </button>
    </div>
  </div>
  <div>
    <form method="POST" id="XY">
      
      <input type="submit" id="xy_submit" style="display: none;">
    </form>
  </div>
</body>
</html>

<script>

//Initialise some values
var size = Number("<?php echo $size;?>");
var chart;
var page = 1;
var options = {
    FieldName: [size],
    DataType:[size]
};
var x_disabled = [size];

//Transfer all php values to options as an javascript value
"<?php for ($i = 1; $i < $size; $i += 1){?>";
  options.FieldName[Number("<?php echo $i;?>")] = "<?php echo $arr['rows'][$i]['FieldName']?>";
  options.DataType[Number("<?php echo $i;?>")] = "<?php echo $arr['rows'][$i]['DataType']?>";
"<?php } ?>";

var chart_list = ["Scatter plot", "Line Dash", "Bubble", "Bar", "Scatter Line", "Line", "Overlaid Area", "Horizontal Bar", "Pie"];
function Create_Chart(){
  var BreakPoints = 3;
  var bps = 2;
  var charts = '<tr>';
  for (var i = 0; i < chart_list.length; i+=1) {
    charts += '<td><button onClick="charts_reset('+i+');" class="btn btn-default original-btn-chart" id="chart'+i+'" style="width: 100%"><span style="font-size: 125%;">'+chart_list[i]+'</span></button></td>';
    if (i == chart_list.length-1){
      charts += '</tr>';
    }
    else if (i == bps){
      charts += '</tr><tr>';
      bps += BreakPoints;
    }
  }
  for (var i = 0; i < size; i += 1){
    x_disabled[i] = true;
  }
  $('#title-chart').html('<tr><th><span style="margin-left:5px" id="title"> Please select a chart </span></th></tr>');
  $('#table-button').html(charts);
}

function charts_reset(num){
  chart = chart_list[num];
  $('.original-btn-chart').removeAttr('disabled');
  $('.original-btn-chart').css('background-color', '#FFFFFF');
  $('#chart' + num).css('background-color', '#EE6724');
  $('#chart' + num).attr('disabled', 'disabled');
  $('#buttonadd').removeAttr('disabled');
}

function Create_Axis(axis){
  var breakpoints = 3;
  var bps = 3;
  var point = 0;
  var outputx = '<tr>';
  for (var i = 1; i < size; i += 1){
    var cName = options.FieldName[i];
    if (ChartValidate(chart, axis, options.DataType[i])){
      if (x_disabled[i]){
        point += 1;
        outputx  += '<td><button onclick="'+axis+'_selection(' + i + ');" class="btn btn-default original-btn-'+axis+'" value="'+ cName +'" name="'+axis+'-'+ cName +'" id="'+axis+'-axis-button' + i +'" style="width: 100%"><span style="font-size: 125%;" disabled>'+ cName + '</span></button></td>';
      }
    }
    if(point == size - 1){
      $outputx += '</tr>';
    }else if (point == bps){
      outputx += '</tr><tr>';
      breakpoints += bps;
    }
  }
  $('#title-chart').html('<tr><th><span style="margin-left:5px" id="title"> '+axis.toUpperCase()+'-Axis </span></th></tr>');
  $('#table-button').html(outputx);
}

function checkbutton(){
  if (page == 1){
    $('#buttonback').attr('disabled', 'disabled');
    $('#buttonadd').attr('disabled', 'disabled');
    $('#title-chart').fadeOut('slow');
    $('#table-button').fadeOut('slow');
    setTimeout(function(){
      Create_Chart();
      $('#title-chart').fadeIn('slow');
      $('#table-button').fadeIn('slow');
    }, 500);
  }else if (page == 2){
    $('#buttonback').removeAttr('disabled');
    $('#buttonadd').html('Next');
    $('#title-chart').fadeOut('slow');
    $('#table-button').fadeOut('slow');
    $('#buttonadd').attr('disabled', 'disabled');
    setTimeout(function(){
      Create_Axis('x');
      $('#title-chart').fadeIn('slow');
      $('#table-button').fadeIn('slow');
    }, 500);
  }else{
    $('#buttonadd').attr('disabled', 'disabled');
    $('#buttonadd').html('Create Chart');
    $('#title-chart').fadeOut('slow');
    $('#table-button').fadeOut('slow');
    setTimeout(function(){
      Create_Axis('y');
      $('#title-chart').fadeIn('slow');
      $('#table-button').fadeIn('slow');
    }, 500);
  }
}

var x_selected = 0;
var x_highlight = [size];
for (var i = 0; i < size; i += 1){
  x_highlight[i] = false;
}
function x_selection(num){
  if (x_disabled[num]){
    $('#x-axis-button' + num).css('background-color', 'rgb(31,194,222)');
    x_disabled[num] = false;
    x_highlight[num] = true;
    x_selected += 1;
  }else{
    $('#x-axis-button' + num).css('background-color', '#FFFFFF');
    x_disabled[num] = true;
    x_highlight[num] = false;
    x_selected -= 1;
  }
  if (x_selected >= 1){
    $('#buttonadd').removeAttr('disabled');
  }
}
var y_selected = false;
var previous_y = -1;
function y_selection(num){
  $('.original-btn-y').css('background-color', '#FFFFFF');
  if (previous_y == -1){
    $('#y-axis-button' + num).attr('disabled', 'disabled');
    $('#y-axis-button' + num).css('background-color', 'rgb(31,194,222)');
    previous_y = num;
    x_disabled[num] = true;
    y_selected = true;
  }else{
    $('#y-axis-button' + previous_y).attr('disabled', 'disabled');
    $('#y-axis-button' + num).removeAttr('disabled');
    x_disabled[num] = true;
    x_disabled[previous_y] = false;
    previous_y = num;
    y_selected = false;
  }
  if (y_selected){
    $('#buttonadd').removeAttr('disabled');
  }else{
    $('#buttonadd').attr('disabled', 'disabled');
  }
}

function back(){
  if (page == 3){
    x_disabled[previous_y] = false;
    previous_y = -1;
    for (var i = 0; i < size; i += 1){
      x_highlight[i] = false;
      if (ChartValidate(chart, 'x', options.DataType[i])){
        x_disabled[i] = true;
      }
    }
  }
  page -= 1;
  checkbutton();
}

function next(){
  if (page == 3){
    var div = "<input type='text' name='size' value='"+size+"' style='display:none !important;'/>";
    div += "<input type='text' name='chart' value='"+chart+"' style='display:none !important;'/>";
    for (var i = 1; i < size; i += 1){
      if (x_highlight[i]){
        div += "<input type='text' name='x_axis" + i + "' value='"+options.FieldName[i]+"' style='display:none !important;'/>";
      }
      if (i == previous_y){
        div += "<input type='text' name='y_axis" + i + "' value='"+options.FieldName[i]+"' style='display:none !important;'/>";
      }
    }
    $('#XY').append(div);
    $('#xy_submit').click();
  }else{
    page += 1;
    checkbutton();
  }
}
Create_Chart();
</script>