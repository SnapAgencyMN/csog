<?php
require_once('../config.php');


$sql_value = "";

$database = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_BASE);

$sql = "SELECT * FROM answers_".$_POST['section']." WHERE project_id=".$_POST['project_id']; 
$result = $database->query($sql);

if($result->num_rows >= 1)
{
  //This project all ready has data, lets update it

  $pre = "";
  foreach($_POST as $key => $value)
  {
    if ($key == "section" || $key == "project_id")
    {
      $_POST[$key] = $database->real_escape_string($_POST[$key]);
      continue;
    }

    $key  = $database->real_escape_string($key);
    $value = $database->real_escape_string($value);

    $sql_value .= "$pre `$key`='$value'";
    $pre = ",";

  }
  $sql_value = str_replace("_",".",$sql_value);

  $sql_value = "UPDATE answers_".$_POST['section']." SET ".$sql_value." WHERE project_id=".$_POST['project_id'];
} else
{
  //This project has no data, lets create a new entry

  $pre = "";
  $fields = "";
  $values = "";
  foreach($_POST as $key => $value)
  {
    if ($key == "section")
    {
      $_POST[$key] = $database->real_escape_string($_POST[$key]);
      continue;
    }
    $fields .= "$pre `$key`";
    $values .= "$pre '$value'";
    $pre = ",";
  }
  $fields = str_replace("_",".",$fields);
  $fields = str_replace("project.id","project_id",$fields);
  $sql_value = "INSERT INTO answers_".$_POST['section']." ($fields) VALUES($values);";
}

$result = $database->query($sql_value);
