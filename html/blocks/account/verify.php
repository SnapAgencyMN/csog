<?php

$sql = "SELECT * FROM users WHERE verify = '$verifyCode'";
$DBresult = sqlsrv_query($database, $sql);

if (sqlsrv_has_rows($DBresult) && $verifyCode != "")
{
  $userInfo = sqlsrv_fetch_array($DBresult, SQLSRV_FETCH_ASSOC);
  $sql = "UPDATE users SET level = 1, verify = '' WHERE id = ". $userInfo['id'];
  sqlsrv_query($database, $sql);
  ?>

  <h2>Email Verification</h2>
  <p>Your email has been verified. You may now <a href="<?php echo WS_URL."login/";?>"><u>login</u></a></p>
  
  <?php

} else
{

?>

  <h2>Email Verification</h2>
  <p>Error validating email. Please check the link provided in the confirmation email.</p>

<?php
}
