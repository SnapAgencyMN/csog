<?php

if($verifyCode != "")
{
  $sql = "SELECT id FROM users WHERE password_verify = '$verifyCode'";
  $result = $database->query($sql);
  if($result->num_rows == 1)
  {
    ?>

<h2>Reset Password</h2>
<form id="resetPasswordVerifyForm" method="post">
  <p>Please enter your new password.</p>
  <label>Password:</label><input type="password" id="resetPasswordPassword" name="password" />
  <label>Confirm Password:</label><input type="password" id="resetPasswordPasswordConfirm" name="passwordConfirm" />
  <input type="hidden" value="<?php echo $verifyCode; ?>" name="verifyCode">
  <input type="submit" value="Reset" id="resetPAsswordSubmit" class="form-button" />
</form>

    <?php   
  }
  } else
  {
    ?>
<h2>Reset Password</h2>
<form id="resetPasswordForm" method="post">
  <p>Please enter your email address to reset your password.</p>
  <input type="email" id="resetPasswordEmail" name="email" /><br /><input type="submit" value="Reset" id="resetPAsswordSubmit" class="form-button" />
</form>


    <?php
  }
