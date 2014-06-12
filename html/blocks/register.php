<?php 
if(isset($_SESSION['USER']['LoggedIn']) && $_SESSION['USER']['LoggedIn'] = true)
{
}



if(isset($_POST['registersubmit']) && $_POST['registersubmit'] == "1")
{
  $name = $_POST['name'];
  $company_name = $_POST['companyName'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = sha1($_POST['password']);
  $verify = sha1($username . time());
  $mailingAddress = $_POST['mailingAddress'];
  $city = $_POST['city'];
  $state = $_POST['state'];
  $zip = $_POST['zip'];
  $website = $_POST['website'];
  $phoneNumber = $_POST['phoneNumber'];
  $image = $_POST['logoImage'];

  // Check if the user already exist
  $username = $database->real_escape_string($username);
  $verifySQL = "SELECT * FROM users WHERE username = \"$username\"";

  $result = $database->query($verifySQL);
  if(!empty($result) && $result->num_rows >= 1)
    {
        echo "
            <h2>This username already exists.</h2>
            <p>Please go back and provide a different username.</p>    
        ";
    }
    else
    {
        $sql = "INSERT INTO users (name,company_name,email,website,mailing_address,city,state,zip,phone_number,username,password,verify,company_logo) values ('$name','$company_name','$email','$website','$mailingAddress','$city','$state','$zip','$phoneNumber','$username','$password','$verify','$image')";
        $database->query($sql);
?>
  <h2>Check Your Email To Activate Your Account</h2>
  <p>You must activate your account before you can begin using it.</p>

<?php
    
$to = $_POST['email'];
$subject = "CSOG EMail Confirmation";
$email = "Please verify your email before logging in by visiting: ".WS_URL."account/verify/$verify";


$headers   = array();
$headers[] = "MIME-Version: 1.0";
$headers[] = "Content-type: text/plain; charset=iso-8859-1";
$headers[] = "From: No Reply <noreply@".substr(WS_URL,7,-1).">";
$headers[] = "Reply-To: No Reply <noreply@".substr(WS_URL,7,-1).">";
$headers[] = "Subject: $subject";
$headers[] = "X-Mailer: PHP/".phpversion();


mail($to, $subject, $email, implode("\r\n", $headers));
    }
} else
{
?>
  <div id="register_wrapper">
    <h2>Register</h2>
    <form action="<?php echo WS_URL . "register/"; ?>" method="POST" id="registerForm" enctype="multipart/form-data">
      <div id="registerFormName"><label>Name:</label><input type="text" name="name" maxlength="80" class="requiredForm" /></div>
      <div id="registerFormPhoneNumber"><label>Phone number:</label><input type="text" name="phoneNumber" maxlength="80" class="requiredForm" /></div>
      <div id="registerFormEmail"><label>Email:</label><input type="text" name="email" maxlength="80" class="requiredForm" /></div>
      <div id="registerFormConfirmEmail"><label>Confirm email:</label><input type="text" name="emailConfirm" maxlength="80" class="requiredForm" /></div>
      <div id="registerFormMailingAddress"><label>Mailing address:</label><input type="text" name="mailingAddress" maxlength="160" class="requiredForm" /></div>
      <div id="registerFormCity"><label>City:</label><input type="text" name="city" maxlength="160" class="requiredForm" /></div>
      <div id="registerFormState"><label>State:</label><input type="text" name="state" maxlength="160" class="requiredForm" /></div>
      <div id="registerFormZip"><label>Zip:</label><input type="text" name="zip" maxlength="160" class="requiredForm" /></div>
      <div id="registerFormCompanyName"><label>Company name:</label><input type="text" name="companyName" maxlength="80" class="requiredForm" /></div>
      <div id="registerFormWebsite"><label>Website:</label><input type="text" name="website" maxlength="80" class="requiredForm" /></div>
      <div id="registerFormCompanyLogo" style='height:130px;'>
          <label>Company logo:</label>
          <a class='right' style='padding-right: 400px;' href='' data-lightbox='image-116'>
                <img src='' class='imageLightboxLink'>
            </a><br />
          <iframe id='uploadIframe' class='right' style='clear: both; width:60%; min-width:60%; height:100px; min-height:100px; padding-right:60px;' src='<?php echo WS_URL?>html/blocks/usersFileUpload.php' class='upload_frame'></iframe>
    </div>
      <div id="registerFormUsername" style='clear:both;'><label>Username:</label><input type="text" name="username" maxlength="80" class="requiredForm" /></div>
      <div id="registerFormPassword"><label>Password:</label><input type="password" name="password" maxlength="80" class="requiredForm" /></div>
      <div id="registerFormConfirmPassword"><label>Confirm password:</label><input type="password" name="passwordConfirm" maxlength="80" class="requiredForm" /></div>
      <input type="hidden" name="registersubmit" value="1" />
      <div><input type="submit" value="Register" id="login_submit" class="form-button" /></div>
    </form><br />
    <p>All fields are required.</p>
  </div>
  
<?php
}
