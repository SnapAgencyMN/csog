<h2>Section 6</h2>
<h3 class="question_header">Expenses</h3>
<div class="question_set_wrapper hidden">
  <form id="f_1" class="main_form">
  <?php
    $sql = "SELECT * FROM questions WHERE category = 7";
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
          case "HintOnly":
            HintOnlyQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          case "Checkbox":
            CheckboxQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          case "ImageWithDesc":
            ImageWithDescQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          case "TwoColumnTableHeader":
            TwoColumnTableHeaderQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          case "TwoColumnTableContent":
            TwoColumnTableContentQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          case "TwoColumnTableContentTwo":
            TwoColumnTableContentTwoQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
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


