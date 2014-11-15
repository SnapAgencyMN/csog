<?php
//ini_set('max_execution_time', 300);

$newProjectID = 0;

$sql = "SELECT * FROM projects WHERE id = $projectID AND users_id =".$_SESSION['USER']['ID'];
$statement = sqlsrv_query($database, $sql);
if(sqlsrv_has_rows($statement))
{
  $cloneData = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC);

  $sql = "INSERT INTO projects (users_id, name, date, parcelIDNumber, gps, latitude, longitude, systemStreetAddress, webAddress, "
          . "other, mailingAddress, [file], contact_zip, city, state, zip, projectAddress, easement, easement_desc,contact_name,"
          . "contact_phone, contact_email,contact_address,contact_city,contact_state) "
          . "VALUES ('".$cloneData['users_id']."','".$cloneData['name']."','','"
          . "".$cloneData['parcelIDNumber']."','".$cloneData['gps']."','".$cloneData['latitude']."','".$cloneData['longitude']."','"
          .$cloneData['systemStreetAddress']."','".$cloneData['webAddress']."','".$cloneData['other']."','".$cloneData['mailingAddress']
          ."','".$cloneData['file']."', '', '', '','','','','','','','','','',''); ";
  
  $insertIDSql = "SELECT SCOPE_IDENTITY() as id;";
  
  sqlsrv_query($database, $sql);
  $statement2 = sqlsrv_query($database, $insertIDSql);
  $id = sqlsrv_fetch_array($statement2, SQLSRV_FETCH_ASSOC);
  $newProjectID = $id['id'];
}

if($newProjectID != 0)
{    
  $sql = "SELECT * FROM user_answers WHERE projectID = $projectID AND userID= {$_SESSION['USER']['ID']}";
  $statement = sqlsrv_query($database, $sql);

  if(sqlsrv_has_rows($statement))
  {
    $i = 0;
    while($cloneQuestion = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC))
    {  
      $sql = "INSERT INTO user_answers (projectID, userID, answerID, spawn_sequenceID, other_sequenceID, value) VALUES ($newProjectID, {$_SESSION['USER']['ID']}, {$cloneQuestion['answerID']},"
      . "{$cloneQuestion['spawn_sequenceID']},{$cloneQuestion['other_sequenceID']},'{$cloneQuestion['value']}')";
      sqlsrv_query($database, $sql);
    }
  }
}
