<?php

$sql = "SELECT * FROM users WHERE verify = '$verifyCode'";
$DBresult = $database->query($sql);

if ($DBresult->num_rows >= 1 && $verifyCode != "")
{
  $userInfo = $DBresult->fetch_assoc();
  $sql = "UPDATE users SET level = 1, verify = '' WHERE id = ". $userInfo['id'];
  $database->query($sql);
  ?>

  <h2>Email Verification</h2>
  <p>Your email has been verified. You may now <a href="<?php echo WS_URL;?>">login</a></p>
  
  <?php

} else
{

?>

  <h2>Email Verification</h2>
  <p>Error validating email. Please check the link provided in the confirmation email.</p>

<?php
}
