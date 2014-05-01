<input type="hidden" id="projIdent" value="<?php echo $projectID;?>">
<h2>Organization</h2>
<h3 class="question_header">Here is What We Know</h3>
<div class="question_set_wrapper hidden">
  <form id="f_1" class="main_form">
  <?php
//    $sql = "SELECT * FROM questions WHERE category = 1 ORDER BY priority ASC, id ASC";
//    $sql = "Select * from questions AS question LEFT OUTER JOIN answers AS answer ON question.id = answer.questions_id";
    $sql = "Select question.hint, question.questionTitle, question.template, question.question, question.id, answer.answer from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = $projectID WHERE question.category = 1 ORDER BY question.priority ASC, question.id ASC";
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
          case "pdfonly":
            PdfOnlyQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          case "UnknownTextbox":
            UnknownTextboxQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database); 
            break;
          case "ConditionalTextbox":
            ConditionalTextboxQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database);
            break;
          case "ConditionalTextboxTwo":
            ConditionalTextboxTwoQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          case "FourColumnTableHeader":
            FourColumnTableHeaderQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          case "FourColumnTableContent":
            FourColumnTableContentQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          default:
            break;
        }
      }
    }
  ?> 
  </form> 
  <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <a href="<?php echo WS_URL . 'admin/questions/edit/0/'; ?>">Add New Question</a>
  <?php } ?>
</div> 


<h3 class="question_header">Sources of Drinking Water</h3>
<div class="question_set_wrapper hidden">
  <form id="f_1" class="main_form">
  <?php
    $sql = "SELECT * FROM questions WHERE category = 2";
    $result = $database->query($sql);
    if($result->num_rows >= 1)
    {
          $questions = $result;
      while($question = $questions->fetch_assoc())
      {
        switch ($question['template'])
        {
          case "TextBox":
            TextBoxQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          case "pdfonly":
            PdfOnlyQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          case "UnknownTextbox":
            UnknownTextboxQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database); 
            break;
          case "ConditionalTextbox":
            ConditionalTextboxQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          case "ConditionalTextboxTwo":
            ConditionalTextboxTwoQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          case "FourColumnTableHeader":
            FourColumnTableHeaderQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          case "FourColumnTableContent":
            FourColumnTableContentQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          default:
            break;
        }
      }
    }
  ?> 
  </form> 
  <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <a href="<?php echo WS_URL . 'admin/questions/edit/0/'; ?>">Add New Question</a>
  <?php } ?>
</div> 




<h3 class="question_header">Additional Assistance & Disclaimer</h3>
<div class="question_set_wrapper hidden">
  <form id="f_1" class="main_form">
  <?php
    $sql = "SELECT * FROM questions WHERE category = 3";
    $result = $database->query($sql);
    if($result->num_rows >= 1)
    {
          $questions = $result;
      while($question = $questions->fetch_assoc())
      {
        switch ($question['template'])
        {
          case "TextBox":
            TextBoxQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          case "pdfonly":
            PdfOnlyQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          case "UnknownTextbox":
            UnknownTextboxQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database); 
            break;
          case "ConditionalTextbox":
            ConditionalTextboxQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          case "ConditionalTextboxTwo":
            ConditionalTextboxTwoQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          case "FourColumnTableHeader":
            FourColumnTableHeaderQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          case "FourColumnTableContent":
            FourColumnTableContentQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          default:
            break;
        }
      }
    }
  ?> 
  </form> 
  <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <a href="<?php echo WS_URL . 'admin/questions/edit/0/'; ?>">Add New Question</a>
  <?php } ?>
</div> 


