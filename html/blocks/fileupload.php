<?php
ini_set("error_reporting", "E_ALL ^ E_STRICT & E_NOTICE");
ini_set("display_errors", 1);
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../libs/utils.php");
require_once(__DIR__."/../../libs/classes/answers.class.php");
require_once(__DIR__."/../../libs/classes/db.php");
require_once(__DIR__."/../../libs/classes/dbObj.php");

$dbInfo = array(
        "user" => DB_USER,
        "pass" => DB_PASS,
        "host" => DB_HOST,
        "name" => DB_BASE,
        "site" => "localhost"
    );
 
$db = new Db($dbInfo);
$answersClass = new Answers($db);

$userID = getParameterNumber("userID");    
$answerID = getParameterNumber("answerID");
$projectID = getParameterNumber('projectID');
$type = getParameterString("type");
$action = getParameterString("action", 'display_form');

if ($type != "normal")
    $spawnID = end(explode("_", $type));
else
    $spawnID = 0;
    
if ($action == "save_form")
{
    //$allowedExts = array("gif", "jpeg", "jpg", "png");
    //$temp = explode(".", $_FILES["file"]["name"]);
    //$extension = end($temp);
    if ((($_FILES["file"]["type"] == "image/gif")
      || ($_FILES["file"]["type"] == "image/jpeg")
      || ($_FILES["file"]["type"] == "image/jpg")
      || ($_FILES["file"]["type"] == "image/pjpeg")
      || ($_FILES["file"]["type"] == "image/x-png")
      || ($_FILES["file"]["type"] == "image/tiff")
      || ($_FILES["file"]["type"] == "image/tiff-fx")
      || ($_FILES["file"]["type"] == "image/png"))
      && ($_FILES["file"]["size"] < 1058576 )) //1 Megabyte max
      //&& in_array($extension, $allowedExts))
    {
        if ($_FILES["file"]["error"] > 0)
        {
          echo "Error: " . $_FILES["file"]["error"] . "<br>";
          die();
        }
        
        $filenamesave = uniqid(time()) . "." . $extension; 
        move_uploaded_file($_FILES["file"]["tmp_name"],FS_PATH . "media/uploads/" . $filenamesave);
        
        $answersClass->saveUserAnswer($userID, $projectID, $answerID, $filenamesave, $spawnID);
    }
    else
    {
        echo "Invalid file type";
    }
}

?>
<html>
<head>
<link href="<?php echo WS_URL; ?>css/formalize.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo WS_URL; ?>css/main.css" rel="stylesheet" type="text/css"/>
<link href='http://fonts.googleapis.com/css?family=Josefin+Sans:400,600' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
</head>
<body>
<form method="POST" id="uploadForm" enctype="multipart/form-data">
    <p>Image Upload:</p>
    <input type="file" name="file" id="file-upload-form-input" onchange='window.parent.uploadImage(<?php echo "$projectID, $userID, $answerID, $spawnID,\"".WS_URL.'"'?>)'>
    <input type="hidden" name="userID" value="<?php echo $userID;?>">
    <input type="hidden" name="answerID" value="<?php echo $answerID;?>">
    <input type="hidden" name="type" value="<?php echo $type;?>">
    <input type="hidden" name="action" value="save_form">
    <p>File formats accepted: jpg, gif, png</p>
</form>
</body>
</html>
