<div id="login_wrapper">
    <p class="loginText">If you are using this tool for the first time, click here to register.</p>
    <div><button class='form-button' onclick="javascript:window.location.href='<?php echo WS_URL;?>register/';">Register</button></div>

    <br />
  <form action="<?php echo WS_URL;?>projects/" method="post">
    <p class="loginText">If you already have an account, log in here:</a> 
    <div><label>Username:</label><br /><input name="user" id="user" type="text" maxlength="32" /></div>
    <div><label>Password:</label><br /><input name="pass" id="pass" type="password" maxlength="32" /></div>
    <div><input type="submit" value="Log In" id="login_submit" class="form-button" /></div>
  </form>
  <a href="<?php echo WS_URL;?>account/reset/">Lost your password?</a>
</div>
