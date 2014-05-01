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
  $image = "";
  

  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["companyLogo"]["name"]);
  $extension = end($temp);
  if ((($_FILES["companyLogo"]["type"] == "image/gif")
    || ($_FILES["companyLogo"]["type"] == "image/jpeg")
    || ($_FILES["companyLogo"]["type"] == "image/jpg")
    || ($_FILES["companyLogo"]["type"] == "image/pjpeg")
    || ($_FILES["companyLogo"]["type"] == "image/x-png")
    || ($_FILES["companyLogo"]["type"] == "image/png"))
    && ($_FILES["companyLogo"]["size"] < 2000000)
    && in_array($extension, $allowedExts))
  {
    if ($_FILES["companyLogo"]["error"] > 0)
    {
    } else
    {
      $filenamesave = uniqid(time()) . "." . $extension; 
      move_uploaded_file($_FILES["companyLogo"]["tmp_name"],FS_PATH . "media/uploads/" . $filenamesave);
      $image = $filenamesave;
    }
  } 



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
      <div id="registerFormCompanyLogo"><label>Company logo:</label><input type="file" name="companyLogo" class="requiredForm" />File formats accepted: jpg, gif, png</div>
      <div id="registerFormUsername"><label>Username:</label><input type="text" name="username" maxlength="80" class="requiredForm" /></div>
      <div id="registerFormPassword"><label>Password:</label><input type="password" name="password" maxlength="80" class="requiredForm" /></div>
      <div id="registerFormConfirmPassword"><label>Confirm password:</label><input type="password" name="passwordConfirm" maxlength="80" class="requiredForm" /></div>
      <input type="hidden" name="registersubmit" value="1" />
      <div><input type="submit" value="Register" id="login_submit" class="form-button" /></div>
    </form><br />
    <p>All fields are required.</p>
  </div>
  
<?php
}
