<?php
require_once("../config.php");

$database = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_BASE);

$sql = "SELECT id FROM users WHERE password_verify = '".$_POST['verifyCode'] ."'";
$result = $database->query($sql);

if($result->num_rows == 1)
{
  $data = $result->fetch_assoc();
  $sql = "UPDATE users SET password_verify = '', password = '".sha1($_POST['password'])."' WHERE id = ".$data['id'];

  $database->query($sql);

}
