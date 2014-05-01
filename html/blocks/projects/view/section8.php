<h2>Section 8</h2>
<h3 class="question_header">Collection Types</h3>
<div class="question_set_wrapper hidden">
  <form id="f_1" class="main_form">
  <?php
    $sql = "SELECT * FROM questions WHERE category = 13 ORDER BY priority ASC, id ASC";
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
          case "ConditionalImageWithDesc":
            ConditionalImageWithDescQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
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

<h3 class="question_header">Location</h3>
<div class="question_set_wrapper hidden">
  <form id="f_1" class="main_form">
  <?php
    $sql = "SELECT * FROM questions WHERE category = 14 ORDER BY priority ASC, id ASC";
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
          case "ConditionalImageWithDesc":
            ConditionalImageWithDescQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break; 
          case "ConditionalTextboxThree":
            ConditionalTextboxThreeQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
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

<h3 class="question_header">Operation & Maintenance</h3>
<div class="question_set_wrapper hidden">
  <form id="f_1" class="main_form">
  <?php
    $sql = "SELECT * FROM questions WHERE category = 15 ORDER BY priority ASC, id ASC";
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
          case "ConditionalImageWithDesc":
            ConditionalImageWithDescQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break; 
          case "ConditionalTextboxThree":
            ConditionalTextboxThreeQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          case "ThreeColumnTableHeader":
            ThreeColumnTableHeaderQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
            break;
          case "ThreeColumnTableContent":
            ThreeColumnTableContentQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],"",$database);
 
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


