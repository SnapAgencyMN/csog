<?php 
require_once('../config.php');

$database = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_BASE);

if(isset($_GET['username']) && $_GET['username'] != "")
{
  $sql = "SELECT username FROM users WHERE username='".$_GET['username']."'";
  $result = $database->query($sql);

  if($result->num_rows >= 1)
  {
    echo "1";
  } else
  {
    echo "2";
  }
  die();
}

if(isset($_GET['email']) && $_GET['email'] != "")
{
  $sql = "SELECT email FROM users WHERE email='".$_GET['email']."'";
  $result = $database->query($sql);

  if($result->num_rows >= 1)
  {
    echo "1";
  } else
  {
    echo "2";
  }
} 
?>
