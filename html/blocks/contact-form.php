<?php

if($_POST){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  mail('spenser.baldwin@gmail.com', $email, $message);
}

?>
