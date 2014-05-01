<?php
$pID = "";
$qID = "";
$offset = -1;
$insert = true;
$image = "";
require_once("../../config.php");
$database = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_BASE);
if(isset($_POST['submited']) && $_POST['submited'] == 1)
{
  $pID = $_POST['pID'];
  $qID = $_POST['qID'];
  $offset = $_POST['offset'];
} else
{
  $pID = $_GET['pID'];
  $qID = $_GET['qID'];
  if(isset($_GET['offset']))
  {
    $offset = $_GET['offset'];
  } else
  {
    $offset = -1;
  }
}


$sql = "SELECT * FROM answers WHERE project_id = '".$pID."' && questions_id = '".$qID."'";
$result = $database->query($sql);
if ($result->num_rows > 0)
{
  $values = $result->fetch_assoc();
  $insert = false;
  $currentFile = $values['file'];
}

if(isset($_POST['submited']) && $_POST['submited'] == 1)
{

  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["file"]["name"]);
  $extension = end($temp);
  if ((($_FILES["file"]["type"] == "image/gif")
    || ($_FILES["file"]["type"] == "image/jpeg")
    || ($_FILES["file"]["type"] == "image/jpg")
    || ($_FILES["file"]["type"] == "image/pjpeg")
    || ($_FILES["file"]["type"] == "image/x-png")
    || ($_FILES["file"]["type"] == "image/png"))
    && ($_FILES["file"]["size"] < 2000000)
    && in_array($extension, $allowedExts))
  {
    if ($_FILES["file"]["error"] > 0)
    {
      echo "Error: " . $_FILES["file"]["error"] . "<br>";
    } else
    {
      $filenamesave = uniqid(time()) . "." . $extension; 
      if($insert)
      {
        $filenamesql = $filenamesave;
        if($offset >= 0)
        {
          
          $fileArray = array();
          $fileArray = explode(";#;#;",$currentFile);
          $i = 0;
          while ($i <= $offset)
          {
            if($i == $offset)
            {
              $fileArray[$i] = $filenamesql;
            } else
            {
              $fileArray[$i] = $fileArray[$i];
            }
            $i++;
          }
          $filenamesql = implode(";#;#;",$fileArray);

        }
        $sql = "INSERT INTO answers (questions_id, project_id, file) VALUES ('$qID','$pID','$filenamesql')";
        $database->query($sql);
      }
      else
      {
        $filenamesql = $filenamesave;
        if($offset >= 0)
        {
          
          $fileArray = array();
          $fileArray = explode(";#;#;",$currentFile);
          $i = 0;
          while ($i <= $offset)
          {
            if($i == $offset)
            {
              $fileArray[$i] = $filenamesql;
            } else
            {
              $fileArray[$i] = $fileArray[$i];
            }
            $i++;
          }
          $filenamesql = implode(";#;#;",$fileArray);

        }
        $sql = "UPDATE answers SET file = '$filenamesql' WHERE project_id=".$pID." && questions_id=".$qID;

        $database->query($sql);
      }

      move_uploaded_file($_FILES["file"]["tmp_name"],FS_PATH . "media/uploads/" . $filenamesave);
      $image = $filenamesave;
    }
  } else
  {
    echo "Invalid file";
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
<?php 
if($image != "")
{
  /*?>
  <a href="<?php echo WS_URL . "media/uploads/".$image; ?>" data-lightbox="image-1"><img style="max-width:25px;max-height:25px;" src="<?php echo WS_URL . "media/uploads/".$image; ?>"></a></br>
  <?php */
} else
{
  echo "<p>Image Upload:</p>";
}
?>
<input type="file" name="file" id="file-upload-form-input" onchange="document.getElementById('uploadForm').submit()">
<input type="hidden" name="pID" value="<?php echo $_GET['pID'];?>">
<input type="hidden" name="qID" value="<?php echo $_GET['qID'];?>">
<input type="hidden" name="offset" value="<?php echo $offset;?>">
<input type="hidden" name="submited" value="1">
<p>File formats accepted: jpg, gif, png</p>
</form>
</body>
</html>
