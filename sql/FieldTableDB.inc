<?php
//Creates Table
function EnterFieldTable($TableID, $fieldname, $DataType){
  return "INSERT INTO FieldTable(FieldName, TableID, DataType) VALUES(\"$fieldname\", $TableID, \"$DataType\");";
}

function EnterArrayFieldTable($TableID, $ArrayOfFields, $DataType){
  $sql = "";
  for ($i = 0; $i < count($ArrayOfFields); $i += 1){
    $sql .= "INSERT INTO FieldTable(FieldName, TableID, DataType) VALUES(\"$ArrayOfFields[$i]\", $TableID, \"$DataType[$i]\");";
  }
  return $sql;
}

//Presents the list of tables
function GetFieldTableList($TableID){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT * FROM FieldTable WHERE TableID = $TableID ORDER BY FieldID;");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo=null;
  return $result;
}

//Ask an request to obtain any details
function RequestFieldTableDetail($FieldID, $request){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT * FROM FieldTable WHERE FieldID = $FieldID;");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  foreach($result as $data){
    $pdo = null;
    return $data[$request];
  }
}

//Ask an request to obtain any details as a list
function RequestFieldTableDetailAsList($FieldID, $requestfield){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT $requestfield FROM FieldTable WHERE FieldID = $FieldID;");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo = null;
  return $result;
}

//Returns the string of a query that removes the fieldname data from a specific row (this is called from varioustableDB)
function DeleteField($TableID, $FieldName){
  return "DELETE FROM FieldTable WHERE TableID = $TableID AND FieldName =\"$FieldName\";";
}
//Returns the string of a query deletes all the data that relates to the table that is being deleted
function DeleteFieldTable($TableID){
  return "DELETE FROM FieldTable WHERE TableID = $TableID;";
}

//returns the FieldID
function GetFieldID($TableID, $FieldName){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT FieldID FROM FieldTable WHERE TableID=$TableID & FieldName=$FieldName;");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  foreach($result as $data){
    $pdo=null;
    return $result['FieldID'];
  }

}

//Returns the string of a query that changes data of a specific FieldnName and dataType
function ChangeField($FieldID, $NewFieldName, $NewFieldType){
  return "UPDATE FieldTable SET FieldName= \"$NewFieldName\", DataType=\"$NewFieldType\" WHERE FieldID=$FieldID;";
}
?>
