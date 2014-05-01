<?php
$sql = "SELECT users_id FROM projects WHERE id = $projectID && users_id =".$_SESSION['USER']['ID'];
$result = $database->query($sql);
if($result->num_rows >= 1)
{

?>
<input type="hidden" id="projIdent" value="<?php echo $projectID;?>">
<h2><?php echo $sectionTitle; ?></h2>
<?php
$i = 0;
foreach($catsIds as $catsId)
{

?>
<h3 class="question_header"><div class="catPlus"></div><?php echo $catsTitles[$i]; ?></h3>
<div class="question_set_wrapper hidden">
  <form id="f_1" class="main_form">
  <?php
//    $sql = "SELECT * FROM questions WHERE category = 1 ORDER BY priority ASC, id ASC";
//    $sql = "Select * from questions AS question LEFT OUTER JOIN answers AS answer ON question.id = answer.questions_id";
    $sql = "Select question.hint, question.questionTitle, question.template, question.question, question.id, question.pdfOutput, answer.answer, answer.file from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = $projectID WHERE question.category = $catsId ORDER BY question.priority ASC, question.id ASC";
    $result = $database->query($sql);
    if($result->num_rows >= 1)
    {
      $questions = $result;
      while($question = $questions->fetch_assoc())
      {
        switch ($question['template'])
        {
          case "TextBox":
            TextBoxQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database);
            break;
          case "OperationsTable":
            OperationsTableQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database);
            break;
          case "FinalRadio":
            FinalRadioQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database);
            break;

          case "pdfonly":
            PdfOnlyQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database);
            break;
          case "UnknownTextbox":
            UnknownTextboxQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database); 
            break;
          case "ConditionalTextbox":
            ConditionalTextboxQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database);
            break;
          case "ConditionalTextboxTwo":
            ConditionalTextboxTwoQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database);
            break;
          case "FourColumnTableHeader":
            FourColumnTableHeaderQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database);
            break;
          case "FourColumnTableContent":
            FourColumnTableContentQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database);
            break;
          case "FourColumnTableContentOther":
            FourColumnTableContentOtherQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database);
            break;
          case "HintOnly":
            HintOnlyQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database);
            break;
          case "Checkbox":
            CheckboxQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database);
            break;
          case "ImageWithDesc":
            ImageWithDescQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database,$projectID,$question['file'],$question['pdfOutput']);
            break;
          case "TwoColumnTableHeader":
            TwoColumnTableHeaderQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database);
            break;
          case "TwoColumnTableContent":
            TwoColumnTableContentQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database);
            break;
          case "TwoColumnTableContentTwo":
            TwoColumnTableContentTwoQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database);
            break;
          case "ConditionalImageWithDesc":
            ConditionalImageWithDescQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database,$projectID,$question['file'],$question['pdfOutput']);
            break; 
          case "ConditionalTextboxThree":
            ConditionalTextboxThreeQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database);
            break;
          case "ThreeColumnTableHeader":
            ThreeColumnTableHeaderQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database);
            break;
          case "ThreeColumnTableContent":
            ThreeColumnTableContentQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database);
            break;
          case "ThreeRadio":
            ThreeRadioQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database,$projectID,$question['file']);
            break;
          case "TwoRadioRemote":
            TwoRadioRemoteQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database,$projectID,$question['file']);
            break;
          default:
            break;
        }
      }
    }
  ?> 
  </form> 
  <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <a href="<?php echo WS_URL . 'admin/questions/edit/0/'; ?>" class="add-question form-button">Add New Question</a>
  <?php } ?>
    <a href="#">Return to Top</a>
</div> 
<?php
  $i++;
}
  if($nextPage != "")
  {
    echo '<a href="'.WS_URL.'projects/view/'.$projectID.'/'.$nextPage.'/">Next Section</a>';
  }

} else
{
  echo "<h2>Invalid Project</h2><p>This project does not exist.</p>";
}
?>
