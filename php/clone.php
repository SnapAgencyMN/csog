<?php
$newProjectID = 0;

$sql = "SELECT * FROM projects WHERE id = $projectID && users_id =".$_SESSION['USER']['ID'];
$result = $database->query($sql);
if($result->num_rows >= 1)
{
  $cloneData = $result->fetch_assoc();

  $sql = "INSERT INTO projects (users_id, name, date, parcelIDNumber, gps, latitude, longitude, systemStreetAddress, webAddress, other, mailingAddress, file) VALUES ('".$cloneData['users_id']."','".$cloneData['name']."','','".$cloneData['parcelIDNumber']."','".$cloneData['gps']."','".$cloneData['latitude']."','".$cloneData['longitude']."','".$cloneData['systemStreetAddress']."','".$cloneData['webAddress']."','".$cloneData['other']."','".$cloneData['mailingAddress']."','".$cloneData['file']."')";

  $database->query($sql);
  $newProjectID = $database->insert_id;

}

if(!$newProjectID == 0)
{
  $sql = "SELECT * FROM answers WHERE project_id = $projectID";
  $result = $database->query($sql);

  if($result->num_rows >= 1)
  {
    $i = 0;
    while($cloneQuestion = $result->fetch_assoc())
    {
      $sql = "INSERT INTO answers (questions_id,template,answer,project_id,file) VALUES ('".$cloneQuestion['questions_id']."','".$cloneQuestion['template']."','".$cloneQuestion['answer']."','".$newProjectID."','".$cloneQuestion['file']."')";
      $database->query($sql);
    }
  }
}
