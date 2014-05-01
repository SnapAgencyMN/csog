<?php 
//print_r($_POST['question_edit_pdf_output']) . "\n\n\n";

$pdfOutput = "";
$i = 0;
foreach($_POST['question_edit_pdf_output'] as $pdf)
{
  if ($i > 0)
  {
    $pdfOutput .= ";&,&;" . $pdf;
  }
  else
  {
    $pdfOutput .= $pdf;
  }
  $i++;
}
//$pdfOutput = implode(";&,&;",$_POST['question_edit_pdf_output']);
$category = $_POST['question_edit_category'];
$hint = $_POST['question_edit_hint'];
$questionTitle = $_POST['question_edit_question_title'];
$id = $_POST['question_edit_id'];
$template = $_POST['question_edit_template'];
$priority = $_POST['question_edit_question_priority'];

if(isset($_FILES["question_edit_file"]["error"]) && $_FILES["question_edit_file"]["error"] == 0)
{
  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["question_edit_file"]["name"]);
  $extension = end($temp);
  if ((($_FILES["question_edit_file"]["type"] == "image/gif")
    || ($_FILES["question_edit_file"]["type"] == "image/jpeg")
    || ($_FILES["question_edit_file"]["type"] == "image/jpg")
    || ($_FILES["question_edit_file"]["type"] == "image/pjpeg")
    || ($_FILES["question_edit_file"]["type"] == "image/x-png")
    || ($_FILES["question_edit_file"]["type"] == "image/png"))
    && ($_FILES["question_edit_file"]["size"] < 500000)
    && in_array($extension, $allowedExts))
    {
      $filenamesave = uniqid(time()) . "." . $extension;
      move_uploaded_file($_FILES["question_edit_file"]["tmp_name"], FS_PATH . "media/uploads/" . $filenamesave );
      $pdfOutput .= ";&,&;" . $filenamesave;
    }

} elseif(isset($_FILES["question_edit_file"]["error"]) && $_FILES["question_edit_file"]["error"] != 0)
{
  $pdfOutput .= ";&,&;" . $_POST['question_edit_filedefault']; 
}

if($_POST['insert'])
{
  $sql = "INSERT INTO questions (id, category, template, hint, questionTitle, pdfOutput, priority) VALUES ( '', '$category', '$template', '$hint', '$questionTitle', '$pdfOutput', '$priority')";
  $database->query($sql);

} else 
{
  $sql = "UPDATE questions SET hint='$hint',questionTitle='$questionTitle',pdfOutput='$pdfOutput',priority='$priority' WHERE id=$id";
  $database->query($sql);
}
