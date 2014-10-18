<?php
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
          ."','".$cloneData['file']."', '', '', '','','','','','','','','','',''); "
          . "SELECT SCOPE_IDENTITY();";
  $statement = sqlsrv_query($database, $sql);
  echo "Fetched: ";
  $r = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC);
  print_r($r);

}

echo ("NEW PROJECT ID IS $newProjectID");
//die();
if(!$newProjectID == 0)
{
  $sql = "SELECT * FROM answers WHERE project_id = $projectID";
  sqlsrv_query($database, $sql);

  if(sqlsrv_has_rows($statement))
  {
    $i = 0;
    while($cloneQuestion = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC))
    {
      $sql = "INSERT INTO answers (questions_id,template,answer,project_id,file) VALUES ('".$cloneQuestion['questions_id']."','".$cloneQuestion['template']."','".$cloneQuestion['answer']."','".$newProjectID."','".$cloneQuestion['file']."')";
      sqlsrv_query($database, $sql);
    }
  }
}
