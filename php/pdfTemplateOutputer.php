<?php

require_once(FS_PATH . "php/templates.php");
switch ($answer['template'])
{
  case "TextBox":
    $html .= TextBoxPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], null, $answer['file']);
    break;
  case "pdfonly":
    $html .= PdfOnlyPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], null, $answer['file']);
    break;
  case "HintOnly":
    $html .= HintOnlyPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], null, $answer['file']);
    break;
  case "ConditionalTextbox":
    $html .= ConditionalTextboxPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], null, $answer['file']);
    break;
  case "ConditionalTextboxTwo":
    $html .= ConditionalTextboxTwoPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], null, $answer['file']);
    break;
  case "UnknownTextbox":
    $html .= UnknownTextboxPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], null, $answer['file']);
    break;
  case "FourColumnTableHeader":
    $tableTracker = 0;
    $html .= FourColumnTableHeaderPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], null, $answer['file']);
    break;
  case "TwoColumnTableHeader":
    $tableTracker = 0;
    $html .= TwoColumnTableHeaderPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], null, $answer['file']);
    break;
  case "ThreeColumnTableHeader":
    $tableTracker = 0;
    $html .= ThreeColumnTableHeaderPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], null, $answer['file']);
    break;
  case "FourColumnTableContent":
    $odd = false;
    if($tableTracker % 2 == 1)
    {
      $odd = true;
    }
    $htmlTemp = FourColumnTableContentPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], null, $answer['file'],$odd);
    if($htmlTemp != "")
    {
      $html .= $htmlTemp;
      $tableTracker++;
    }
    break;
  case "FourColumnTableContentOther":
    $odd = false;
    if($tableTracker % 2 == 1)
    {
      $odd = true;
    }
    $htmlTemp = FourColumnTableContentOtherPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], null, $answer['file'],$odd);
    if($htmlTemp != "")
    {
      $html .= $htmlTemp;
      $tableTracker++;
    }
    break;


  case "TwoColumnTableContent":
    $odd = false;
    if($tableTracker % 2 == 1)
    {
      $odd = true;
    }
    $html .= TwoColumnTableContentPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], null, $answer['file'],$odd);
    $tableTracker++;
    break;
  case "TwoColumnTableContentTwo":
    $odd = false;
    if($tableTracker % 2 == 1)
    {
      $odd = true;
    }
    $html .= TwoColumnTableContentTwoPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], null, $answer['file'],$odd);
    $tableTracker++;
   break;
  case "ThreeColumnTableContent":
    $odd = false;
    if($tableTracker % 2 == 1)
    {
      $odd = true;
    }
    $html .= ThreeColumnTableContentPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], null, $answer['file'],$odd);
    $tableTracker++;
   break;
  case "Checkbox":
    $html .= CheckboxPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], null, $answer['file']);
    break;
  case "ImageWithDesc":
    $html .= ImageWithDescPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], null, $answer['file']);
    break;
  case "ImageWithDescTwo":
    $html .= ImageWithDescTwoPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], null, $answer['file']);
    break;
  case "ConditionalImageWithDesc":
    $html .= ConditionalImageWithDescPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], null, $answer['file']);
    break;
  case "TwoRemoteCheckboxesPDFOnly":
    $html .= TwoRemoteCheckboxesPDFOnlyPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], $database, $answer['file'],$projectID);
    break;
  case "TankAlarm":
    $html .= TankAlarmPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], $database, $answer['file'],$projectID,$repCount);
    break;
  case "TankAlarmYes":
    $html .= TankAlarmYesPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], $database, $answer['file'],$projectID,$repCount);
    break;
  case "TwoRadioRemote":
    $html .= TwoRadioRemotePTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], $database, $answer['file'],$projectID,$repCount);
    break;
  case "ThreeRadio":
    $html .= ThreeRadioPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], $database, $answer['file'],$projectID,$repCount);
    break;
  case "ThreeRadioTwo":
    $html .= ThreeRadioTwoPTemplate($answer['questionTitle'],$answer['pdfOutput'], $answer['answer'], $database, $answer['file'],$projectID,$repCount);
    break;
  default:
    break;
}
