<input type="hidden" id="projIdent" value="<?php echo $projectID;?>">
<input type="hidden" id="questionRepeat" value="true">
<h2><?php echo $sectionTitle; ?></h2>

<?php
$sql = "Select question.hint, question.questionTitle, question.template, question.question, question.id, answer.answer from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = $projectID WHERE question.category = $repeatingQCat ORDER BY question.priority ASC, question.id ASC";
$result = $database->query($sql);
if($result->num_rows >= 1)
{
  $result = $result->fetch_assoc();
  $tmp = explode(";+;+;",$result['answer']);
  $result['answer'] = $tmp[1];
//  $result['answer'] = preg_replace(";#;#;","",$result['answer']);
} 
?>

    <div class="question_set_row_repeat">
      <div class="question_set_row_hint">
        <img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="Enter the Number of <?php echo $sectionTitle;?>">
      </div>
      <div class="question_set_row_title">
        Enter the Number of <?php echo $sectionTitle;?>
      </div>
      <div class="question_set_row_field">
        <form method="post">
        <input type="text" id="q_<?php echo $result['id']; ?>" name="q_<?php echo $result['id']; ?>[1]" class="q_<?php echo $result['id']; ?> textbox form_question repeater" <?php if($result['answer'] != "") { echo 'value="' . str_replace(";#;#;","",$result['answer']) . '" '; } ?> >
        </form>
      </div>
      <?php if($_SESSION['USER']['Admin'] == true) { ?>
      <div class="question_set_row_edit">
        <a href="<?php echo WS_URL . 'admin/questions/edit/' . $result['id'] .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $result['id'] .'/'; ?>">Delete</a>
      </div>
      <?php } ?>
   </div>
    <div class="clear"></div>




<?php

$repTotal = $result['answer'];
$quesArray = array();
?>

<!--<h3 class="question_header"><?php echo $catsTitles[0]; ?></h3>
<div class="question_set_wrapper hidden"> -->
  <form id="f_1" class="main_form">
  <?php
//    $sql = "SELECT * FROM questions WHERE category = 1 ORDER BY priority ASC, id ASC";
//    $sql = "Select * from questions AS question LEFT OUTER JOIN answers AS answer ON question.id = answer.questions_id";
    $sql = "Select question.hint, question.questionTitle, question.template, question.question, question.id, answer.answer, answer.file from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = $projectID WHERE question.category = ".$catsIds[0]." ORDER BY question.priority ASC, question.id ASC";
    $result = $database->query($sql);
    if($result->num_rows >= 1)
    {
      $questions = $result;
      $ii = 0;
      while($question = $questions->fetch_assoc())
      {
        $repArray = array();
        $i = 0;
        $answerArray = explode(";#;#;",$question['answer']);
        while ($i < $repTotal)
        {
          $repArray[$i]['hint'] = $question['hint'];
          $repArray[$i]['questionTitle'] = $question['questionTitle'];
          $repArray[$i]['question'] = $question['question'];
          $repArray[$i]['id'] = $question['id'];
          $repArray[$i]['template'] = $question['template'];
          $repArray[$i]['file'] = $question['file'];
          $repArray[$i]['answer'] = $answerArray[$i];
          $i++;
        }
        $quesArray[$ii] = $repArray;
        $ii++;
      }
    }
  $tankNumber = 1;
  $repCount = 0;
  while($repCount < $repTotal)
  {
    echo "<h3 class='question_header'>$catsTitles[0] #".$tankNumber++ ."</h3>";
    echo '<div class="question_set_wrapper hidden">';
    foreach($quesArray as $ques)
    {
      //print_r($ques[$repCount]);
      switch ($ques[$repCount]['template'])
      {
        case "TextBox":
          TextBoxQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database);
          break;
        case "TextBoxNoOutput":
          TextBoxNoOutputQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database);
          break;
        case "TwoRadioRemote":
          TwoRadioRemoteQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database,$projectID,$ques[$repCount]['file']);
          break;
        case "TwoRadio":
          TwoRadioQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database,$projectID);
          break;
        case "ThreeRadio":
          ThreeRadioQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database,$projectID,$ques[$repCount]['file'],$repCount);
          break;
        case "ThreeRadioTwo":
          ThreeRadioTwoQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database,$projectID);
          break;
        case "pdfonly":
          PdfOnlyQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database);
          break;
        case "UnknownTextbox":
          UnknownTextboxQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database); 
          break;
        case "ConditionalTextbox":
          ConditionalTextboxQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database);
          break;
        case "ConditionalTextboxTwo":
          ConditionalTextboxTwoQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database);
          break;
        case "FourColumnTableHeader":
          FourColumnTableHeaderQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database);
          break;
        case "FourColumnTableContent":
          FourColumnTableContentQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database);
          break;
        case "HintOnly":
          HintOnlyQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database);
          break;
        case "Checkbox":
          CheckboxQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database);
          break;
        case "CheckboxHintOnly":
          CheckboxHintOnlyQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database);
          break;
        case "ImageWithDesc":
        case "ImageWithDescTwo":
          ImageWithDescQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database,$projectID);
          break;
        case "TwoColumnTableHeader":
          TwoColumnTableHeaderQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database);
          break;
        case "TwoColumnTableContent":
          TwoColumnTableContentQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database);
          break;
        case "TwoColumnTableContentTwo":
          TwoColumnTableContentTwoQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database);
          break;
        case "ConditionalImageWithDesc":
          ConditionalImageWithDescQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database,$projectID);
          break; 
        case "ConditionalTextboxThree":
          ConditionalTextboxThreeQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database);
          break;
        case "ThreeColumnTableHeader":
          ThreeColumnTableHeaderQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database);
          break;
        case "ThreeColumnTableContent":
          ThreeColumnTableContentQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database);
        case "TwoRemoteCheckboxesPDFOnly":
          TwoRemoteCheckboxesPDFOnlyQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database);
          break;
        case "TankAlarmYes":
          TankAlarmYesQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database);
          break;
        case "TankAlarm":
          TankAlarmQTemplate($ques[$repCount]['hint'],$ques[$repCount]['questionTitle'],$ques[$repCount]['question'],$ques[$repCount]['id'],$ques[$repCount]['answer'],$database,$projectID,$ques[$repCount]['file'],$repCount);
          break;
        default:
          break;
     }
    }
    echo '<a href="#">Return to Top</a>';
    echo "</div>";
    
 
    $repCount++;
  }
  ?> 



  </form>
  <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <a href="<?php echo WS_URL . 'admin/questions/edit/0/'; ?>">Add New Question</a>
  <?php } ?>
