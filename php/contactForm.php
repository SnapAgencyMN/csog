<?php 
require_once("../config.php");

$to = "jules.inda@gmail.com";
$subject = "Project Page Contact Form From ".$_POST['name'];
$email = $_POST['message'];

print_r($_POST);

$headers   = array();
$headers[] = "MIME-Version: 1.0";
$headers[] = "Content-type: text/plain; charset=iso-8859-1";
$headers[] = "From: No Reply <noreply@".substr(WS_URL,7,-1).">";
$headers[] = "Reply-To: ".$_POST['name']." <".$_POST['email'].">";
$headers[] = "Subject: Project Page Contact Form From ".$_POST['name'];
$headers[] = "X-Mailer: PHP/".phpversion();


//mail($to, $subject, $email, implode("\r\n", $headers));
