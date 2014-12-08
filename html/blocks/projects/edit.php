<?php 

if(isset($projectID))
{
  $sql = "SELECT * FROM projects WHERE ID = $projectID AND users_id = ". $_SESSION['USER']['ID'];
  $statement = sqlsrv_query($database, $sql);
  if (sqlsrv_has_rows($statement))
  {
    $title = "Edit Project Description";
    $PData = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC);
  } else
  {
    $title = "Create a New Project";
  }

}

$sql = "SELECT name, email, phone_number, mailing_address FROM users WHERE id = " . $_SESSION['USER']['ID'];
$statement = sqlsrv_query($database, $sql);
$userInfo = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC);

if (!empty($PData['contact_phone']))
{
    $ph = $PData['contact_phone'];
    $ph = str_replace("-", "", $ph);
    $ph = str_replace("–", "", $ph);
    $ph = str_replace(" ", "", $ph);
    $ph = str_replace("(", "", $ph);
    $ph = str_replace(")", "", $ph);
    
    $phoneNumber = "(".$ph[0].$ph[1].$ph[2].") ".$ph[3].$ph[4].$ph[5]."-".$ph[6].$ph[7].$ph[8].$ph[9]; 
}
?>
<form action="<?php echo WS_URL . "projects/"; ?>" method="POST" enctype="multipart/form-data" id="new-project-form">
<label for="projectName">Project name: * </label><input type="text" class='requiredForm' name="projectName" id="newProjectName" <?php if(isset($PData) && $PData['name'] != "") { echo "value='".$PData['name']."'"; }?>></br>
<?php if (@$PData['file'] != "") { ?><a href="<?php echo WS_URL . "media/uploads/" . $PData['file']; ?>" data-lightbox="image-logo"><img src="<?php echo WS_URL . "media/uploads/" . $PData['file']; ?>" class="imageLightboxLink registerProject"></a></br> <?php } ?>
<label for="projectLogo">Project logo: </label><input type="file" name="projectLogo">File formats accepted: jpg, jpeg, gif, png</br>
<?php if (@$PData['coverFile'] != "") { ?><a href="<?php echo WS_URL . "media/uploads/" . $PData['coverFile']; ?>" data-lightbox="image-logo"><img src="<?php echo WS_URL . "media/uploads/" . $PData['coverFile']; ?>" class="imageLightboxLink registerProject"></a></br> <?php } ?>
<label for="coverImage" class="left">
    <span class="left" style="margin-right:10px;"> Cover Image: </span>
    <div class="question_set_row_hint left">
        <img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="This default image will appear on the cover page of the manual, or you can provide an image of your own">
    </div>
</label>
<input type="file" class="left" name="coverImage">File formats accepted: jpg, jpeg, gif, png</br>
<br /><br />
<h3>System location</h3>
<label for="systemStreetAddress">Street address:</label> <input type="text" name="systemStreetAddress" <?php if(isset($PData) && $PData['systemStreetAddress'] != "") { echo "value='".$PData['systemStreetAddress']."'"; }?>></br>
<label for="projectCity">City: *</label> <input type="text" class='requiredForm' id='newProjectCity' name="projectCity" <?php if(isset($PData) && $PData['city'] != "") { echo "value='".$PData['city']."'"; }?>></br>
<label for="projectState">State: *</label> <input type="text" class='requiredForm' id='newProjectState' name="projectState" <?php if(isset($PData) && $PData['state'] != "") { echo "value='".$PData['state']."'"; }?>></br>
<label for="projectZip">Zip:</label> <input type="text" name="projectZip" <?php if(isset($PData) && $PData['zip'] != "") { echo "value='".$PData['zip']."'"; }?>></br>
<?php /*<label for="other">Other:</label> <input type="text" name="other" <?php if(isset($PData) && $PData['other'] != "") { echo "value='".$PData['other']."'"; }?>></br>
<label for="mailingAddress">Mailing address:</label> <input type="text" name="mailingAddress" <?php if(isset($PData) && $PData['mailingAddress'] != "") { echo "value='".$PData['mailingAddress']."'"; }?>></br> */ ?>
<label for="webAddress">Web address:</label> <input type="text" name="webAddress" <?php if(isset($PData) && $PData['webAddress'] != "") { echo "value='".$PData['webAddress']."'"; }?>></br>
<label for="parcelIDNumber">Parcel ID number:</label> <input type="text" name="parcelIDNumber" <?php if(isset($PData) && $PData['parcelIDNumber'] != "") { echo "value='".$PData['parcelIDNumber']."'"; }?>></br>
<?php /* 
<label for="gps">GPS:</label> <input type="text" name="gps" <?php if(isset($PData) && $PData['gps'] != "") { echo "value='".$PData['gps']."'"; }?>></br>
*/ ?>
<br />
<h3>GPS:</h3>
<label for=latitude">Latitude:</label> <input type="text" name="latitude" <?php if(isset($PData) && $PData['latitude'] != "") { echo "value='".$PData['latitude']."'"; }?>></br>
<label for="longitude">Longitude:</label> <input type="text" name="longitude" <?php if(isset($PData) && $PData['longitude'] != "") { echo "value='".$PData['longitude']."'"; }?>></br>
Is there a recorded easement for access to perform service or periodic inspections on the system?
<label for="easement_yes" name="easement_yes" >Yes</label><input onclick="javascript:$('#easement_description').css('display', 'block')" type="radio" id="easement_yes" name="easement" value="Yes" <?php if(isset($PData) && $PData['easement'] == "Yes") { echo "checked "; } ?>/>
<div id="easement_description"><label>Easement description:</label>
        <input type="text" <?php if(isset($PData) && $PData['easement_desc'] != "") { echo "value='".$PData['easement_desc']."'"; }?> name="easement_description"  maxlength="80" class="requiredForm" />
</div><br />
<label for="easement_no" name="easement_no">No</label><input onclick="javascript:$('#easement_description').css('display', 'none')" type="radio" id="easement_no" name="easement" value="No" <?php if(isset($PData) && $PData['easement'] == "No") { echo "checked "; } ?>/>
<br /><br />
<h2>Project Contact Information</h2>
  <div id="modifyFormName"><label>Primary contact person: *</label><input class='requiredForm' id='newProjectContactName' type="text" <?php if(isset($PData) && $PData['contact_name'] != "") { echo "value='".$PData['contact_name']."'"; } ?> name="name" maxlength="80" class="requiredForm" /></div>
    <div id="modifyFormPhoneNumber"><label>Contact phone number: *</label><input class='requiredForm' type="text" id='newProjectPhoneNumber' name="phone_number" maxlength="12" class="requiredForm" <?php if(isset($PData) && $PData['contact_phone'] != "") { echo "value='".$phoneNumber."'"; } ?> /></div>
      <div id="modifyFormEmail"><label>Contact email: *</label><input class='requiredForm' type="text" <?php if(isset($PData) && $PData['contact_email'] != "") { echo "value='".$PData['contact_email']."'"; } ?> name="email" id='newProjectContactEmail' maxlength="80" class="requiredForm" /></div>
      <div id="modifyFormMailingAddress"><label>Street address: *</label><input class='requiredForm' type="text" <?php if(isset($PData) && $PData['contact_address'] != "") { echo "value='".$PData['contact_address']."'"; } ?> name="contact_address" id='newProjectAddress' maxlength="160" class="requiredForm" /></div>
      <div id="modifyFormMailingAddress"><label>City: *</label><input class='requiredForm' type="text" <?php if(isset($PData) && $PData['contact_city'] != "") { echo "value='".$PData['contact_city']."'"; } ?> name="contact_city" id='newProjectContactCity' maxlength="160" class="requiredForm" /></div>
      <div id="modifyFormMailingAddress"><label>State: *</label><input class='requiredForm' type="text" <?php if(isset($PData) && $PData['contact_state'] != "") { echo "value='".$PData['contact_state']."'"; } ?> name="contact_state" id='newProjectContactState' maxlength="160" class="requiredForm" /></div>
      <div id="modifyFormMailingAddress"><label>Zip: *</label><input class='requiredForm' type="text" <?php if(isset($PData) && $PData['contact_zip'] != "") { echo "value='".$PData['contact_zip']."'"; } ?> name="contact_zip" id='newProjectZip' maxlength="160" class="requiredForm" /></div>   
      
      
      
      (where materials concerning the system are to be sent)<br /><br />
  <?php /* Fields set to auto-fill based on account user information -- removed at request of client.
  <div id="modifyFormName"><label>Primary contact person:</label><input type="text" <?php if(isset($PData) && $PData['contact_name'] != "") { echo "value='".$PData['contact_name']."'"; } else { echo "value='".$userInfo['name']."'"; } ?> name="name" maxlength="80" class="requiredForm" /></div>
  <div id="modifyFormPhoneNumber"><label>Contact phone number:</label><input type="text" name="phone_number" maxlength="80" class="requiredForm" <?php if(isset($PData) && $PData['contact_phone'] != "") { echo "value='".$PData['contact_phone']."'"; } else { echo "value='".$userInfo['phone_number']."'"; } ?> /></div>
  <div id="modifyFormEmail"><label>Contact email:</label><input type="text" <?php if(isset($PData) && $PData['contact_email'] != "") { echo "value='".$PData['contact_email']."'"; } else { echo "value='".$userInfo['email']."'"; } ?> name="email" maxlength="80" class="requiredForm" /></div>
  <div id="modifyFormMailingAddress"><label>City, state & zip:</label><input type="text" <?php if(isset($PData) && $PData['contact_address'] != "") { echo "value='".$PData['contact_address']."'"; } else { echo "value='".$userInfo['mailing_address']."'"; }?> name="contact_address" maxlength="160" class="requiredForm" /></div>(where materials concerning the system are to be sent)<br /><br />
  */ ?>
<input type="hidden" name="createProjectSubmit" value="1">
<?php if(isset($PData)) { ?><input type="hidden" name="editProjectSubmit" value="<?php echo $projectID; ?>"><?php } ?>
<?php if(isset($PData)) { ?><input type="hidden" name="defaultFile" <?php if($PData['file'] != "") { echo "value='".$PData['file']."'"; }?>><?php } ?>
<input type="hidden" name="defaultCoverFile" <?php if(!empty($PData['coverFile'])) { echo "value='".$PData['coverFile']."'"; } else {echo "DEFAULT FILE";}?>>
<input type="submit" class="form-button" value="Submit">
</form>
</br>
