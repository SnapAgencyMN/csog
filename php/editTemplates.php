<?php
if (isset($_GET['template']))
{
  require_once("../config.php");
} else
{
  require_once("config.php");
}
require_once(FS_PATH . "php/templates.php");
?>
<div id="template_section">
  <?php
  if($template == "")
  {
    $template = $_GET['template'];
  }
  
  switch($template)
  {
    case "Repeater":
    case "pdfonly":
      PdfOnlyETemplate($question['pdfOutput']);
      break;
    case "TwoRadioRemote":
      TwoRadioRemoteETemplate($question['pdfOutput']);
      break;
    case "TwoRadio":
      TwoRadioETemplate($question['pdfOutput']);
      break;
    case "OperationsTable":
      OperationsTableETemplate($question['pdfOutput']);
      break;
    case "ThreeRadio":
      ThreeRadioETemplate($question['pdfOutput']);
      break;
    case "ThreeRadioTwo":
      ThreeRadioTwoETemplate($question['pdfOutput']);
      break;
    case "TextBox":
      TextBoxETemplate($question['pdfOutput']);
      break;
    case "TextBoxNoOutput":
      TextBoxNoOutputETemplate($question['pdfOutput']);
      break;
    case "ConditionalTextbox":
      ConditionalTextboxETemplate($question['pdfOutput']);
      break; 
    case "UnknownTextbox":
      UnknownTextboxETemplate($question['pdfOutput']);
      break;
    case "ConditionalTextboxTwo":
      ConditionalTextboxTwoETemplate($question['pdfOutput']);
      break;
    case "FourColumnTableHeader":
      FourColumnTableHeaderETemplate($question['pdfOutput']);
      break;    
    case "FourColumnTableContent":
      FourColumnTableContentETemplate($question['pdfOutput']);
      break;
    case "Checkbox":
      CheckboxETemplate($question['pdfOutput']);
      break;
    case "CheckboxHintOnly":
      CheckboxHintOnlyETemplate($question['pdfOutput']);
      break;
    case "HintOnly":
      HintOnlyETemplate($question['pdfOutput']);
      break;
    case "ImageWithDesc":
    case "ImageWithDescTwo":
      ImageWithDescETemplate($question['pdfOutput']);
      break;
    case "TwoColumnTableHeader":
      TwoColumnTableHeaderETemplate($question['pdfOutput']);
      break;    
    case "TwoColumnTableContent":
      TwoColumnTableContentETemplate($question['pdfOutput']);
      break;
     case "TwoColumnTableContentTwo":
      TwoColumnTableContentTwoETemplate($question['pdfOutput']);
      break; 
    case "ConditionalImageWithDesc":
      ConditionalImageWithDescETemplate($question['pdfOutput']);
      break;
    case "ConditionalTextboxThree":
      ConditionalTextboxThreeETemplate($question['pdfOutput']);
      break;
    case "ThreeColumnTableHeader":
      ThreeColumnTableHeaderETemplate($question['pdfOutput']);
      break;    
    case "ThreeColumnTableContent":
      ThreeColumnTableContentETemplate($question['pdfOutput']);
      break;
    case "TwoRemoteCheckboxesPDFOnly":
      TwoRemoteCheckboxesPDFOnlyETemplate($question['pdfOutput']);
      break;
    case "TankAlarmYes":
      TankAlarmYesETemplate($question['pdfOutput']);
      break;
    case "TankAlarm":
      TankAlarmETemplate($question['pdfOutput']);
      break;
  }


  ?>
</div>
