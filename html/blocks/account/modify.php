<?php
  if(isset($_POST['generalModifySubmit']) && $_POST['generalModifySubmit'] == "1")
  {
    if($_POST['name'] != "")
    {
      $sql = "UPDATE users SET name = '".$_POST['name']."' WHERE id = ".$_SESSION['USER']['ID'];
      $database->query($sql);
      $_SESSION['USER']['Name'] = $_POST['name'];
    }
    if($_POST['companyName'] != "")
    {
      $sql = "UPDATE users SET company_name = '".$_POST['companyName']."' WHERE id = ".$_SESSION['USER']['ID'];
      $database->query($sql);
      $_SESSION['USER']['CompanyName'] = $_POST['companyName'];
    }
    if($_POST['phoneNumber'] != "")
    {
      $sql = "UPDATE users SET phone_number = '".$_POST['phoneNumber']."' WHERE id = ".$_SESSION['USER']['ID'];
      $database->query($sql);
    }
    if($_POST['website'] != "")
    {
      $sql = "UPDATE users SET website = '".$_POST['website']."' WHERE id = ".$_SESSION['USER']['ID'];
      $database->query($sql);
    }
    if($_POST['mailingAddress'] != "")
    {
      $sql = "UPDATE users SET mailing_address = '".$_POST['mailingAddress']."' WHERE id = ".$_SESSION['USER']['ID'];
      $database->query($sql);
    }
    if($_POST['city'] != "")
    {
      $sql = "UPDATE users SET city = '".$_POST['city']."' WHERE id = ".$_SESSION['USER']['ID'];
      $database->query($sql);
    }
    if($_POST['state'] != "")
    {
      $sql = "UPDATE users SET state = '".$_POST['state']."' WHERE id = ".$_SESSION['USER']['ID'];
      $database->query($sql);
    }
    if($_POST['zip'] != "")
    {
      $sql = "UPDATE users SET zip = '".$_POST['zip']."' WHERE id = ".$_SESSION['USER']['ID'];
      $database->query($sql);
    }
    if(isset($_POST['verbose']))
    {
      $sql = "UPDATE users SET verbose = 'true' WHERE id = ".$_SESSION['USER']['ID'];
      $database->query($sql);
      $_SESSION['USER']['Verbose'] = true;
    } else
    {
      $sql = "UPDATE users SET verbose = 'false' WHERE id = ".$_SESSION['USER']['ID'];
      $database->query($sql);
      $_SESSION['USER']['Verbose'] = false;
    }
    
    if($_POST['logoImage'] != "")
    {
      $sql = "UPDATE users SET company_logo = '".$_POST['logoImage']."' WHERE id = ".$_SESSION['USER']['ID'];
      $database->query($sql);
    }

  }

  if(isset($_POST['passwordModifySubmit']) && $_POST['passwordModifySubmit'] == "1")
  {
    if($_POST['password'] != "" && $_POST['password'] == $_POST['passwordConfirm'])
    {
      $sql = "UPDATE users SET password = '".sha1($_POST['password'])."' WHERE id = ".$_SESSION['USER']['ID'];
      $database->query($sql);
    }
  }


  $sql = "SELECT phone_number, mailing_address, city, state, zip, website, name, email, company_name, company_logo,verbose FROM users WHERE id = " . $_SESSION['USER']['ID'];
  $result = $database->query($sql);
  $userInfo = $result->fetch_assoc();
  
  if (!empty($userInfo['phone_number']))
  {
    $ph = $userInfo['phone_number'];
    $ph = str_replace("-", "", $ph);
    $ph = str_replace("–", "", $ph);
    $ph = str_replace(" ", "", $ph);
    $ph = str_replace("(", "", $ph);
    $ph = str_replace(")", "", $ph);

    $phoneNumber = "(".$ph[0].$ph[1].$ph[2].") ".$ph[3].$ph[4].$ph[5]."-".$ph[6].$ph[7].$ph[8].$ph[9]; 
  }
?> 
  <div class="modify_wrapper">
    <h2>General Information</h2>
    <form action="<?php echo WS_URL . "account/edit/"; ?>" method="POST" id="generalModifyForm" enctype="multipart/form-data">
      <div id="modifyFormName"><label>Name:</label><input type="text" value="<?php echo $userInfo['name']; ?>" name="name" maxlength="80" class="requiredForm" /></div>
      <div id="modifyFormPhoneNumber"><label>Phone number:</label><input type="text" value="<?php echo $phoneNumber; ?>" name="phoneNumber" placeholder="(xxx) xxx-xxxx" maxlength="80" class="requiredForm" /></div>
      <div id="modifyFormEmail"><label>Email:</label><input type="text" value="<?php echo $userInfo['email']; ?>" name="email" maxlength="80" class="requiredForm" /></div>
      <div id="modifyFormMailingAddress"><label>Mailing address:</label><input type="text" value="<?php echo $userInfo['mailing_address']; ?>" name="mailingAddress" maxlength="160" class="requiredForm" /></div>
      <div id="modifyFormCity"><label>City:</label><input type="text" value="<?php echo $userInfo['city']; ?>" name="city" maxlength="160" class="requiredForm" /></div>
      <div id="modifyFormState"><label>State:</label><input type="text" value="<?php echo $userInfo['state']; ?>" name="state" maxlength="160" class="requiredForm" /></div>
      <div id="modifyFormZip"><label>Zip:</label><input type="text" value="<?php echo $userInfo['zip']; ?>" name="zip" maxlength="160" class="requiredForm" /></div>

      <div id="modifyFormCompanyName"><label>Company name:</label><input type="text"  value="<?php echo $userInfo['company_name']; ?>"name="companyName" maxlength="80" class="requiredForm" /></div>
      <div id="modifyFormWebsite"><label>Website:</label><input type="text" value="<?php echo $userInfo['website']; ?>" name="website" maxlength="80" class="requiredForm" /></div>
      <div id="registerFormCompanyLogo" style='height:130px;'>
          <label>Company logo:</label>
          <input type='hidden' name='logoImage' value='<?php echo $userInfo['company_logo'] ?>' /><a class='right' style='padding-right:400px' href='/media/uploads/<?php echo $userInfo['company_logo'] ?>' data-lightbox='image-116'><img src='/media/uploads/<?php echo $userInfo['company_logo'] ?>' class='imageLightboxLink'></a>
          <iframe id='uploadIframe' class='right' style='clear: both; min-width:100%; min-height:45px;' src='<?php echo WS_URL?>html/blocks/usersFileUpload.php' class='upload_frame'></iframe>
    </div>
      <div style='clear:both;' id="modifyFormVerbose"><label>Turn Tool Tips on:</label><input type="checkbox"  value="true" <?php if($userInfo['verbose'] != "false") { echo "checked"; } ?> name="verbose" /></div>
      <div style='clear:both;'>
          <p>&nbsp;&nbsp;(If you'd like Tool Tips to be visible at all times, check "Turn Tool Tips On". Otherwise they can be accessed as needed)</p>
      </div>
      <input type="hidden" name="generalModifySubmit" value="1">
      <div><input type="submit" value="Update" class="form-button" /></div>
      <br />
    </form>
  </div>
  <div class="modify_wrapper">
    <h2>Update Password</h2>
    <form action="<?php echo WS_URL . "account/edit/"; ?>" method="POST" id="passwordModifyForm">
      <div id="passwordFormPassword"><label>Password:</label><input type="password" name="password" maxlength="80" class="requiredForm" /></div>
      <div id="passwordFormConfirmPassword"><label>Confirm password:</label><input type="password" name="passwordConfirm" maxlength="80" class="requiredForm" /></div>
      <input type="hidden" name="passwordModifySubmit" value="1">
      <div><input type="submit" value="Update" class="form-button" /></div>
    </form>
  </div>
