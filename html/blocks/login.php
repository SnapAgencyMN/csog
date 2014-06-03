<div id="login_wrapper">
  <form action="<?php echo WS_URL;?>projects/" method="post">
    <div><label>Username:</label><br /><input name="user" id="user" type="text" maxlength="32" /></div>
    <div><label>Password:</label><br /><input name="pass" id="pass" type="password" maxlength="32" /></div>
    <div><input type="submit" value="Log In" id="login_submit" class="form-button" /></div>
  </form>
  <a href="<?php echo WS_URL;?>register/">Register</a><br />
  <a href="<?php echo WS_URL;?>account/reset/">Lost your password?</a>
</div>
