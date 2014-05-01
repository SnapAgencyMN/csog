<?php
require_once("../config.php");

$database = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_BASE);

$sql = "SELECT id, username, email FROM users WHERE email = '".$_POST['email'] ."'";
$result = $database->query($sql);

if($result->num_rows == 1)
{
  $data = $result->fetch_assoc();
  $verify = sha1($data['username'] . time());

  $sql = "UPDATE users SET password_verify = '$verify' WHERE id = ".$data['id'];
  $database->query($sql);


  $to = $data['email'];
  $subject = "CSOG Password Reset";
  $email = "Please confirm and reset your password by visiting: ".WS_URL."account/reset/$verify \n\nIf you did not request this reset, please ignore this email.";


  $headers   = array();
  $headers[] = "MIME-Version: 1.0";
  $headers[] = "Content-type: text/plain; charset=iso-8859-1";
  $headers[] = "From: No Reply <noreply@".substr(WS_URL,7,-1).">";
  $headers[] = "Reply-To: No Reply <noreply@".substr(WS_URL,7,-1).">";
  $headers[] = "Subject: $subject";
  $headers[] = "X-Mailer: PHP/".phpversion();


  mail($to, $subject, $email, implode("\r\n", $headers));
}
