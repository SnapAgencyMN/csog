<?php
if (!isset($questionsClass))
    $questionsClass = new Questions($db);

if (!isset($sectionsClass))
    $sectionsClass = new Sections($db);

if (!isset($categoriesClass))
    $categoriesClass = new Categories($db);

if (!isset($answersClass))
    $answersClass = new Answers($db);

$projectID = getParameterNumber("projectID");

require_once("projects/view/actions.php");
date_default_timezone_set('Australia/Sydney');

if (isset($_POST['deleteConfirm']) && $_POST['deleteConfirm'] == 1)
{
  $sql = "SELECT * FROM projects WHERE id = ".$_POST['projectID']." AND users_id = ". $_SESSION['USER']['ID'];
//$result = $database->query($sql);
  $result = sqlsrv_query($database, $sql);
  
  if(sqlsrv_has_rows($result))
  {
    $delete = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
    $sql = "DELETE FROM projects WHERE id = ". $delete['id'];
    sqlsrv_query($database, $sql);
  }
}


if (isset($_POST['createProjectSubmit']) && $_POST['createProjectSubmit'] == 1)
{
  @$projectName = $_POST['projectName'];
  @$date = $_POST['date'];
  @$parcelIDNumber = $_POST['parcelIDNumber'];
  @$projectAddress = $_POST['projectAddress'];
  @$city = $_POST['projectCity'];
  @$state = $_POST['projectState'];
  @$zip = $_POST['projectZip'];
  @$gps = $_POST['gps'];
  @$latitude = $_POST['latitude'];
  @$longitude = $_POST['longitude'];
  @$systemStreetAddress = $_POST['systemStreetAddress'];
  @$webAddress = $_POST['webAddress'];
  @$other = $_POST['other'];
  @$mailingAddress = $_POST['mailingAddress'];
  @$userID = $_SESSION['USER']['ID'];
  @$image = "";
  @$cover = "";
  @$easement_description = $_POST['easement_description'];
  @$contact_phone = $_POST['phone_number'];
  @$contact_name = $_POST['name'];
  @$contact_address = $_POST['contact_address'];
  @$contact_city = $_POST['contact_city'];
  @$contact_state = $_POST['contact_state'];
  @$contact_zip = $_POST['contact_zip'];
  @$contact_email = $_POST['email'];
  @$easement = $_POST['easement'];

  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["projectLogo"]["name"]);
  $extension = end($temp);
  if ((($_FILES["projectLogo"]["type"] == "image/gif")
    || ($_FILES["projectLogo"]["type"] == "image/jpeg")
    || ($_FILES["projectLogo"]["type"] == "image/jpg")
    || ($_FILES["projectLogo"]["type"] == "image/pjpeg")
    || ($_FILES["projectLogo"]["type"] == "image/x-png")
    || ($_FILES["projectLogo"]["type"] == "image/png"))
    && ($_FILES["projectLogo"]["size"] < 1058576)
    && in_array($extension, $allowedExts))
  {
    if ($_FILES["projectLogo"]["error"] > 0)
    {
    } else
    {
      $filenamesave = uniqid(time()) . "." . $extension; 
      move_uploaded_file($_FILES["projectLogo"]["tmp_name"],FS_PATH . "media/uploads/" . $filenamesave);
      $image = $filenamesave;
    }
  }
  
  $temp = explode(".", $_FILES["coverImage"]["name"]);
  $extension = end($temp);
  if ((($_FILES["coverImage"]["type"] == "image/gif")
    || ($_FILES["coverImage"]["type"] == "image/jpeg")
    || ($_FILES["coverImage"]["type"] == "image/jpg")
    || ($_FILES["coverImage"]["type"] == "image/pjpeg")
    || ($_FILES["coverImage"]["type"] == "image/x-png")
    || ($_FILES["coverImage"]["type"] == "image/png"))
    && ($_FILES["coverImage"]["size"] < 1058576)
    && in_array($extension, $allowedExts))
  {
    if ($_FILES["coverImage"]["error"] > 0)
    {
    } else
    {
      $suffix = md5(time()."cover");
      $filenamesave = "$suffix." . $extension; 
      move_uploaded_file($_FILES["coverImage"]["tmp_name"],FS_PATH . "media/uploads/" . $filenamesave);
      $cover = $filenamesave;
    }
  }
  
  $currentDate = date("m/d/Y H:i:s");
  if(isset($_POST['editProjectSubmit']) && $_POST['editProjectSubmit'] > 0)
  {
    if(empty($image))
        $image = $_POST['defaultFile'];
    
    //if (empty($cover))
        $cover = $_POST['defaultCoverFile'];//"defaults/defaultCover.jpg";//
    
    $sql = "UPDATE projects SET coverFile='$cover', name='$projectName', date='$currentDate', parcelIDNumber='$parcelIDNumber', gps='$gps', latitude='$latitude', longitude='$longitude', systemStreetAddress='$systemStreetAddress', webAddress='$webAddress', other='$other', mailingAddress='$mailingAddress', [file]='$image', projectAddress='$projectAddress', city='$city', state='$state', zip='$zip', contact_name='$contact_name',contact_phone='$contact_phone',contact_address='$contact_address',contact_city='$contact_city',contact_state='$contact_state',contact_zip='$contact_zip',easement_desc='$easement_description', contact_email='$contact_email', easement='$easement' WHERE id=".$_POST['editProjectSubmit'];
  } else
  {
    $sql = "INSERT INTO projects (coverFile, name, date, parcelIDNumber, gps, latitude, longitude, systemStreetAddress, webAddress, other, mailingAddress, users_id, [file], projectAddress, city, state, zip, easement_desc, contact_phone, contact_name, contact_address, contact_city, contact_state, contact_zip, contact_email, easement) VALUES ('$cover', '$projectName','$date','$parcelIDNumber','$gps','$latitude','$longitude','$systemStreetAddress','$webAddress','$other','$mailingAddress','$userID','$image','$projectAddress','$city','$state','$zip','$easement_description','$contact_phone','$contact_name','$contact_address','$contact_city','$contact_state','$contact_zip','$contact_email','$easement')";
  }
  sqlsrv_query($database,$sql);
  
}

?>
<div id="projects_table">
  <h2>Welcome <?php echo $_SESSION['USER']['Name']; ?> from <?php echo $_SESSION['USER']['CompanyName']; ?></h2>
  <a href="<?php echo WS_URL . 'account/edit/' ?>">Edit your profile</a><br /><br /><br />
  
  <h2>Click here to create a new project.</h2>
  <button class='form-button' onclick="javascript:window.location.href='<?php echo WS_URL ?>projects/new/';">Create</button>
  <br /><br />
  <p class="projectText">
      We recommend you create generic project templates for system designs with several shared characteristics. Name it something relevant, for example, "Hillside Template".
  </p>
  <br />
  <p class="projectText">
      Enter ficticious information for project specific, required fields. Address example: 1234 Main St, Anywhere, USA 12345 
  </p>
  <br />
  <p class="projectText">
      You can duplicate a template, saving it with a new name, for a quick start on a new project.
  </p>
  <br />
<?php
$sql = "SELECT * FROM projects WHERE users_id = '".$_SESSION['USER']['ID']."' ORDER BY date DESC";
//$DBresult = $database->query($sql);
$statement = sqlsrv_query($database, $sql);

//if ($DBresult->num_rows)
if (sqlsrv_has_rows($statement)) 
{ 
  ?>
  <h2>Your Community Septic System Owner’s Guide Tool projects are:</h2>
  <ul>
  <?php 
  while ($projectData = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC))
  {
    if( $projectData['name'] != '' ){
      $projectName = $projectData['name'];
    } else {
      $projectName = 'Project '. $projectData['id'];
    }
    
    $projectDate = $projectData['date'];
    $startPage = "organization";

    if($projectDate == "")
    {
      $projectDate = "Never Edited";
    } else {
      $projectDate = date("m/d/Y", strtotime($projectDate));
    } 

    echo '<li><p><b>' . $projectName . ' (' . $projectDate . ')</b></p>' ;
    echo "<a href='" . WS_URL . 'projects/view/' . $projectData['id']."' class='projects_tableProjectName'>Edit system specifications</a>";
    echo "<br />";
    echo "<a href='".WS_URL."projects/edit/{$projectData['id']}' class='projects_tableProjectName'>Edit project description</a>";
    echo "<br />";
    echo "<a href='".WS_URL."projects/clone/{$projectData['id']}' class='projects_tableProjectName'>Duplicate this project</a>";
    echo "<br />";
    echo "<a href='".WS_URL."projects/delete/{$projectData['id']}' class='projects_tableProjectName'>Delete this project</a>";
    
    //echo $startPage;
    //echo '   | <a href="' . WS_URL . 'projects/clone/'.$projectData['id'].'/">Clone</a> | <a href="' . WS_URL . 'projects/edit/'.$projectData['id'].'/">Edit</a> | <a href="' . WS_URL . 'projects/delete/' . $projectData['id'] . '/">Delete</a></li>';
  }
  ?>
  </ul> 
  <?php
} else {
  echo '<h2>You have no projects.</h2>';
}
?>
</div>
