<?php

function TextBoxPTemplate($title="",$pdfOutput="",$answer="",$database = null, $file="")
{
  $answers = explode(";+;+;",$answer);
  if ($answers[1] == "null" || $answers[1] == "")
  {
    return "";
  }
  $pdfOutput = str_replace("%VAL1%",$answers[1],$pdfOutput);
  $html .= "<h4>$title</h4><div class='content'>".$pdfOutput."</div>";

  return $html;
}

function PdfOnlyPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="")
{
  $answers = explode(";+;+;",$answer);
  $html = "<h4>$title</h4><div class='content'>".$pdfOutput."</div>";

  return $html;
}

function HintOnlyPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="")
{
  $answers = explode(";+;+;",$answer);

  return $html;
}

function ConditionalTextboxPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="")
{
  $answers = explode(";+;+;",$answer);
  if($answers[0] == "Yes" && $answers[1] != "null" && $answers[1] != "")
  {
    $pdfOutput = str_replace("%VAL1%",$answers[1],$pdfOutput);
    $html = "<h4>$title</h4><div class='content'>".$pdfOutput."</div>";
    return $html;
  }
  return "";
}

function ConditionalTextboxTwoPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="")
{
  $answers = explode(";+;+;",$answer);
  if($answers[0] == "Yes")
  {
    $pdfOutput = str_replace("%VAL1%",$answers[1],$pdfOutput);
    $html = "<h4>$title</h4><div class='content'>".$pdfOutput."</div>";
    return $html;
  }
  return "";
}

function CheckboxPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="")
{
  $answers = explode(";+;+;",$answer);
  if($answers[0] == "Yes")
  {
    $pdfOutput = str_replace("%VAL1%",$answers[1],$pdfOutput);
    $html = "<h4>$title</h4><div class='content'>".$pdfOutput."</div>";
    return $html;
  }
  return "";
}

function TwoRemoteCheckboxesPDFOnlyPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="",$projectID=0)
{
  $pdfOutputs = explode(";&,&;",$pdfOutput);
  
  $checkboxOne = "";
  $checkboxTwo = "";
  
  $sql = "SELECT answer FROM answers WHERE questions_id = {$pdfOutputs[0]} && project_id = $projectID";
  $result = $database->query($sql);
  if ($result->num_rows >= 1)
  {
    $answer = $result->fetch_assoc();
    $answer = explode(";+;+;",$answer['answer']);
    $checkboxOne = $answer[0];
  }
  $sql = "SELECT answer FROM answers WHERE questions_id = {$pdfOutputs[1]} && project_id = $projectID";
  $result = $database->query($sql);
  if ($result->num_rows >= 1)
  {
    $answer = $result->fetch_assoc();
    $answer = explode(";+;+;",$answer['answer']);
    $checkboxTwo = $answer[0];
  }

  if($checkboxOne == "Yes" && $checkboxTwo == "Yes")
  {
    return "<h4>$title</h4><div class='content'>".$pdfOutputs[2]."</div>";
  }
  return "";
}

function UnknownTextboxPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="")
{
  $pdfOutputs = explode(";&,&;",$pdfOutput);
  $answers = explode(";+;+;",$answer);
  if($answers[0] != "Unknown" && $answers[1] != "null" && $answers[1] != "")
  {
    $pdfOutputs[0] = str_replace("%VAL1%",$answers[1],$pdfOutputs[0]);
    $html = "<h4>$title</h4><div class='content'>".$pdfOutputs[0]."</div>";
    return $html;
  } elseif ($answers[0] == "Unknown")
  {
    $html = "<h4>$title</h4><div class='content'>".$pdfOutputs[1]."</div>";
    return $html;
  }
  return "";
}

function FourColumnTableHeaderPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="")
{
  $pdfOutputs = explode(';&,&;',$pdfOutput);

  $html = '<table style="border-collapse:collapse;">';
  $html .= "<tr>";
  $html .= "<td  style='text-weight:bold;text-align:center;border:1px solid #000;' colspan='5'><h4>$title</h4></td>";
  $html .= "</tr>";
  $html .= '<tr style="border:1px solid #000;">';
  $html .= '<td style="font-weight:bold;text-align:center;width:175px;min-width:175px;border:1px solid #000;">'.$pdfOutputs[0]."</td>";
  $html .= '<td style="font-weight:bold;text-align:center;width:155px;min-width:155px;border:1px solid #000;">'.$pdfOutputs[1]."</td>";
  $html .= '<td style="font-weight:bold;text-align:center;width:215px;min-width:215px;border:1px solid #000;">'.$pdfOutputs[2]."</td>";
  $html .= '<td style="font-weight:bold;text-align:center;width:155px;min-width:155px;border:1px solid #000;">'.$pdfOutputs[3]."</td>";
  $html .= '<td style="font-weight:bold;text-align:center;width:155px;min-width:155px;border:1px solid #000;">'.$pdfOutputs[4]."</td>";
  $html .= '</tr>';
  $html .= '</table>';

  return $html;
}

function TwoColumnTableHeaderPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="")
{
  $pdfOutputs = explode(';&,&;',$pdfOutput);

  $html = '<table style="border-collapse:collapse;">';
  $html .= "<tr>";
  $html .= "<td style='text-weight:bold;text-align:center;border:1px solid #000;' colspan='4'><h4>$title</h4></td>";
  $html .= "</tr>";
  $html .= '<tr style="border:1px solid #000;">';
  $html .= '<td style="font-weight:bold;text-align:center;width:300px;min-width:175px;border:1px solid #000;">'.$pdfOutputs[0]."</td>";
  $html .= '<td style="font-weight:bold;text-align:center;width:400px;min-width:155px;border:1px solid #000;">'.$pdfOutputs[1]."</td>";
  $html .= '</tr>';
  $html .= '</table>';

  return $html;
}

function ThreeColumnTableHeaderPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="")
{
  $pdfOutputs = explode(';&,&;',$pdfOutput);

  $html = '<table style="border-collapse:collapse;">';
  $html .= "<tr>";
  $html .= "<td  style='text-weight:bold;text-align:center;border:1px solid #000;' colspan='4'><h4>$title</h4></td>";
  $html .= "</tr>";
  $html .= '<tr style="border:1px solid #000;">';
  $html .= '<td style="font-weight:bold;text-align:center;width:200px;min-width:175px;border:1px solid #000;">'.$pdfOutputs[0]."</td>";
  $html .= '<td style="font-weight:bold;text-align:center;width:250px;min-width:155px;border:1px solid #000;">'.$pdfOutputs[1]."</td>";
  $html .= '<td style="font-weight:bold;text-align:center;width:250px;min-width:155px;border:1px solid #000;">'.$pdfOutputs[1]."</td>";
  $html .= '</tr>';
  $html .= '</table>';

  return $html;
}

function FourColumnTableContentPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="",$odd=false)
{
  $answer = explode(";+;+;",$answer);
  $answers = explode(";&,&;",$answer[1]);
  $output = false;

  foreach($answers as $answer)
  {
    if($answer != "" && $answer != "null")
    {
      $output = true;
    }
  }


  $html = '<table style="border-collapse:collapse;">';
  if($odd)
  {
    $html .= '<tr style="border:1px solid #000;">';
  } else
  {
    $html .= '<tr style="border:1px solid #000;background-color:#ddd">';
  }
  $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">'.$pdfOutput."</td>";
  $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">'.$answers[0]."</td>";
  $html .= '<td style="width:215px;min-width:215px;border:1px solid #333;">'.$answers[1]."</td>";
  $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">'.$answers[2]."</td>";
  $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">'.$answers[3]."</td>";
  $html .= '</tr>';
  $html .= '</table>';

  if($output)
  {
    return $html;
  }
  return "";
}

function FourColumnTableContentOtherPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="",$odd=false)
{
$answer = str_replace(";#;#;","",$answer);
$delims = array(";+;+;",";&,&;",);
$answers = array_values(array_filter(array_map('trim',explode("-|-",str_replace($delims, "-|-", $answer)))));
$answers = explode("-|-",str_replace($delims, "-|-", $answer));
array_shift($answers);
$html = "";
      $i = 0;  
      while($i < $answers[0])
      {
        $i++;
        $html .= '<table style="border-collapse:collapse;">';
        if($odd)
        {
          $html .= '<tr style="border:1px solid #000;">';
        } else
        {
          $html .= '<tr style="border:1px solid #000;background-color:#ddd">';
        }

        $html .= '<td style="width:175px;min-width:175px;border:1px solid #333;">'.$pdfOutput."# $i</td>";
        $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">'.$answers[1 + (($i-1) * 4)]."</td>";
        $html .= '<td style="width:215px;min-width:215px;border:1px solid #333;">'.$answers[2 + (($i-1) * 4)]."</td>";
        $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">'.$answers[3 + (($i-1) * 4)]."</td>";
        $html .= '<td style="width:155px;min-width:155px;border:1px solid #333;">'.$answers[4 + (($i-1) * 4)]."</td>";
        $html .= '</tr>';
        $html .= '</table>';
        $odd = !$odd;

      }
  return $html;
}


function TwoColumnTableContentPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="",$odd=false)
{
  $answer = explode(";+;+;",$answer);
  if($answer[0] == "Yes")
  {

  $html = '<table style="border-collapse:collapse;">';
  if($odd)
  {
    $html .= '<tr style="border:1px solid #000;">';
  } else
  {
    $html .= '<tr style="border:1px solid #000;background-color:#ddd">';
  }
  $html .= '<td style="width:300px;min-width:300px;border:1px solid #000;">'.$pdfOutput."</td>";
  $html .= '<td style="width:400px;min-width:400px;border:1px solid #000;">';
  if ($answer[1] != "null")
  {
    $html .= $answer[1];
  }
  $html .= "</td>";
  $html .= '</tr>';
  $html .= '</table>';

  }
  return $html;
}

function ThreeColumnTableContentPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="",$odd=false)
{
  $answer = explode(";+;+;",$answer);
  $answers = explode(";&,&;",$answer[1]);

  $html = '<table style="border-collapse:collapse;">';
  if($odd)
  {
    $html .= '<tr style="border:1px solid #000;">';
  } else
  {
    $html .= '<tr style="border:1px solid #000;background-color:#ddd">';
  }
  $html .= '<td style="width:200px;min-width:200px;border:1px solid #000;">'.$pdfOutput."</td>";
  $html .= '<td style="width:250px;min-width:250px;border:1px solid #000;">';
  if ($answers[0] != "null")
  {
    $html .= $answers[0];
  }
  $html .= "</td>";
  $html .= '<td style="width:250px;min-width:250px;border:1px solid #333;">';
  if ($answers[1] != "null")
  {
    $html .= $answers[1];
  }
  $html .= "</td>";
  $html .= '</tr>';
  $html .= '</table>';

  return $html;
}

function TwoColumnTableContentTwoPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="",$odd=false)
{
  $answer = explode(";+;+;",$answer);
  $answers = explode(';&,&;',$answer[1]);
  if($answer[0] == "Yes")
  {

  $html = '<table style="border-collapse:collapse;">';
  if($odd)
  {
    $html .= '<tr style="border:1px solid #000;">';
  } else
  {
    $html .= '<tr style="border:1px solid #000;background-color:#ddd">';
  }
  $html .= '<td style="width:300px;min-width:300px;border:1px solid #333;">'.$pdfOutput."</td>";
  $html .= '<td style="width:200px;min-width:400px;border:1px solid #333;">';
  if ($answers[0] != "null")
  {
    $html .= $answers[0];
  }
  $html .= "</td>";
  $html .= '<td style="width:200px;min-width:400px;border:1px solid #333;">';
  if ($answers[1] != "null")
  {
    $html .= $answers[1];
  }
  $html .= "</td>";
  $html .= '</tr>';
  $html .= '</table>';

  }
  return $html;
}

function ImageWithDescPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="")
{
  $answers = explode(";+;+;",$answer);
  $pdfOutputs = explode(";&,&;",$pdfOutput);


  if($file == "")
  {
    $html = '<img src="'.WS_URL.'media/uploads/'.$pdfOutputs[1].'">';
    $html .= '<p>'.$pdfOutputs[0].'</p>';
  } else
  {
    $html = '<img src="'.WS_URL.'media/uploads/'.$file.'">';
    $html .= '<p>'.$answers[1].'</p>';
  }
  if ($file == "" && $pdfOutputs[1] == "")
  {
    return "";
  }

  $html = "<h4>$title</h4><div class='content'>$html</div>";
  
  return $html;

}

function ImageWithDescTwoPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="")
{
  $answers = explode(";+;+;",$answer);
  $pdfOutputs = explode(";&,&;",$pdfOutput);


  if($file == "" && $pdfOutputs[1] != "")
  {
    $html = '<img src="'.WS_URL.'media/uploads/'.$pdfOutputs[1].'">';
  } elseif($file != "")
  {
    $html = '<img src="'.WS_URL.'media/uploads/'.$file.'">';
  }
  $html .= "<p>".str_replace("%VAL1%",$answers[1],$pdfOutputs[0])."</p>";


  $html = "<h4>$title</h4><div class='content'>$html</div>";
  
  return $html;

}

function ConditionalImageWithDescPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="")
{
  $answers = explode(";+;+;",$answer);
  $pdfOutputs = explode(";&,&;",$pdfOutput);

  $img = "";

  if($answers[0] != "Yes")
  {
    return "";
  }


  if($file == "")
  {
    $img = '<img src="'.WS_URL.'media/uploads/'.$pdfOutputs[1].'">';
  } else
  {
    $img = '<img src="'.WS_URL.'media/uploads/'.$file.'">';
  }
  if($answers[1] != "null")
  {
   $pdfOutputs[0] = str_replace("%VAL1%",$answers[1],$pdfOutputs[0]);
  }

  $html = "<h4>$title</h4>$img<div class='content'>{$pdfOutputs[0]}</div>";
 
  return $html;

}

function TankAlarmPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="",$projectID = 0,$offset=0)
{
  $answers = explode(";+;+;",$answer);
  $radioAnswers = explode(";&,&;",$answers[0]);
  $pdfOutputs = explode(";&,&;",$pdfOutput);

  $img = "";
  $html = "";

  if($radioAnswers[0] == "" )
  {
    return "";
  }

  if($pdfOutputs[0] != 0)
  {
    $sql = "SELECT answer FROM answers WHERE questions_id = {$pdfOutputs[0]} && project_id = $projectID";
    $result = $database->query($sql);
    if ($result->num_rows >= 1)
    {
      $answer = $result->fetch_assoc();
      $answer = $answer['answer'];
      $answers = explode(";#;#;",$answer);
      $answers = explode(";+;+;",$answers[$offset]);
      $answer = $answers[0];
      if($answer == "No")
      {
        return "";
      }
    } else
    {
      return "";
    }
   
  }

  if($radioAnswers[0] == "Yes")
  {
    if(!$file == "")
    {
      $img = '<img src="'.WS_URL.'media/uploads/'.$file.'">';
    }
  
    if(in_array("Visual",$radioAnswers))
    {
      $html .= "<div class='content'>". str_replace("%VAL1%",$answers[1],$pdfOutputs[1]) ."</div>";
    }

    if(in_array("Audible",$radioAnswers))
    {
      $html .= "<div class='content'>". str_replace("%VAL1%",$answers[1],$pdfOutputs[2]) ."</div>";
    }
 
    if(in_array("Remote",$radioAnswers))
    {
      $html .= "<div class='content'>". str_replace("%VAL1%",$answers[1],$pdfOutputs[3]) ."</div>";
    }
  } else
  {
    $html = "<div class='content'>{$pdfOutputs[4]}</div>";
  }

  $html = "<h4>$title</h4>$img$html";
 
  return $html;

}

function TankAlarmYesPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="",$projectID=0,$repeatOffset=0)
{
  $pdfOutputs = explode(";&,&;",$pdfOutput);
  $html = "";
  
  $sql = "SELECT answer FROM answers WHERE questions_id = {$pdfOutputs[0]} && project_id = $projectID";
  $result = $database->query($sql);
  if ($result->num_rows >= 1)
  {
    $parentAnswer = $result->fetch_assoc();
    $parentAnswer = $parentAnswer['answer'];
    if($repeatOffset > 0)
    {
      $parentAnswer = explode(";#;#;",$parentAnswer);
      $parentAnswer = $parentAnswer[$repeatOffset];
    }
    $parentAnswer = explode(";+;+;",$parentAnswer);
    if($parentAnswer[0] == "Yes")
    {
      $answer = explode(";+;+;",$answer);
      $answers = explode(";&,&;",$answer[0]);
      if(in_array("Visual",$answers))
      {
        $pdfOutputs[1] = str_replace("%VAL1%",$answer[1],$pdfOutputs[1]);
        $html .= "<p>{$pdfOutputs[1]}</p>";
      }
      if(in_array("Audible",$answers))
      {
        $pdfOutputs[2] = str_replace("%VAL1%",$answer[1],$pdfOutputs[2]);
        $html .= "<p>{$pdfOutputs[2]}</p>";
      }
      if(in_array("Remote",$answers))
      {
        $pdfOutputs[3] = str_replace("%VAL1%",$answer[1],$pdfOutputs[3]);
        $html .= "<p>{$pdfOutputs[3]}</p>";
      }

    }
  }
  return "<div class='content'>$html</div>";
}

function TwoRadioRemotePTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="",$projectID=0,$repeatOffset=0)
{
  $pdfOutputs = explode(";&,&;",$pdfOutput);
  $answers = explode(";+;+;",$answer);
  $answersText = explode(";&,&;",$answers[1]);
  $html = "";

  if($answers[0] == "Below grade")
  {
    $html .= $pdfOutputs[1];
  } elseif($answers[0] = "Above grade")
  {
    $html .= $pdfOutputs[0];
  }
  if($file != "")
  {
    $html = str_replace("%IMG1%","<img src='".WS_URL."media/uploads/$file' style='margin-left:5%'>",$html);
  } else
  {
    $html = str_replace("%IMG1%","",$html);
  }
  $html = str_replace("%VAL2%",$answersText[1],$html); 
  $html = str_replace("%VAL1%",$answersText[0],$html); 


/*  
  $sql = "SELECT answer FROM answers WHERE questions_id = {$pdfOutputs[0]} && project_id = $projectID";
  $result = $database->query($sql);
  if ($result->num_rows >= 1)
  {
    $parentAnswer = $result->fetch_assoc();
    $parentAnswer = $parentAnswer['answer'];
    if($repeatOffset > 0)
    {
      $parentAnswer = explode(";#;#;",$parentAnswer);
      $parentAnswer = $parentAnswer[$repeatOffset];
    }
    $parentAnswer = explode(";+;+;",$parentAnswer);
    $answer = explode(";+;+;",$answer);
    if($answer[0] == "Below grade")
    {
      $html = str_replace("%VAL1%",$parentAnswer[1],$pdfOutputs[2]);
    } elseif($answer[0] == "Above grade")
    {
      $html = str_replace("%VAL1%",$parentAnswer[1],$pdfOutputs[1]);
    }

  }
*/
  return "<h4>$title</h4><div class='content'>$html</div>";
}

function TwoRadioPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="",$projectID=0,$repeatOffset=0)
{
  $pdfOutputs = explode(";&,&;",$pdfOutput);
  $html = "";
  
    $answer = explode(";+;+;",$answer);
    if($answer[0] == "Yes")
    {
      $html = $pdfOutputs[0];
    } elseif($answer[0] == "No")
    {
      $html = $pdfOutputs[1];
    }

  return "<h4>$title</h4>div class='content'>$html</div>";
}

function ThreeRadioPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="",$projectID=0,$repeatOffset=0)
{
  if($answer == "") {
    return "";
  }
  $pdfOutputs = explode(";&,&;",$pdfOutput);
  $answers = explode(";+;+;",$answer);
  $html = "";
    $answer = explode(";+;+;",$answer);
    if($answers[0] == "On the property")
    {
      $html .= $pdfOutputs[0];
    } elseif($answers[0] == "Off the property")
    {
      $html .= $pdfOutputs[1];
    } elseif($answers[0] == "Combination")
    {
      $html .= $pdfOutputs[2];
    } else
    {
      return "";
    }


    if($file != "")
    {
      $html = str_replace("%IMG1%","<img src='".WS_URL."media/uploads/$file' style='margin-left:5%'>",$html);
    } else
    {
      $html = str_replace("%IMG1%","",$html);
    }


    $html = str_replace("%VAL1%",$answers[1],$html);

  return "<h4>$title</h4><div class='content'>$html</div>";
}

function ThreeRadioTwoPTemplate($title="",$pdfOutput="", $answer="",$database = null, $file="",$projectID=0,$repeatOffset=0)
{
  $pdfOutputs = explode(";&,&;",$pdfOutput);
  $html = "";
  
    $answer = explode(";+;+;",$answer);
    if($answer[0] == "Yes")
    {
      $html = $pdfOutputs[3];
    } elseif($answer[0] == "No")
    {
      $html = $pdfOutputs[4];
    } elseif($answer[0] == "Unknown")
    {
      $sql = "SELECT answer FROM answers WHERE questions_id = {$pdfOutputs[0]} && project_id = $projectID";
      $result = $database->query($sql);
      if($result->num_rows >= 1)
      {
        $parentAnswer = $result->fetch_assoc();
        $parentAnswer = explode(";+;+;",$parentAnswer['answer']);
        if($parentAnswer[0] == "Yes")
        {
          $html .= $pdfOutputs[5];
        }
      }
      $stop = true;
      $sql = "SELECT answer FROM answers WHERE questions_id = {$pdfOutputs[1]} && project_id = $projectID";
      $result = $database->query($sql);
      if($result->num_rows >= 1)
      {
        $parentAnswer = $result->fetch_assoc();
        $parentAnswer = explode(";+;+;",$parentAnswer['answer']);
        if($parentAnswer[0] == "Yes")
        {
          $html .= $pdfOutputs[6];
          $stop = false;
        }
      }
      $sql = "SELECT answer FROM answers WHERE questions_id = {$pdfOutputs[2]} && project_id = $projectID";
      $result = $database->query($sql);
      if($result->num_rows >= 1 && $stop)
      {
        $parentAnswer = $result->fetch_assoc();
        $parentAnswer = explode(";+;+;",$parentAnswer['answer']);
        $stop = false;
        if($parentAnswer[0] == "Yes")
        {
          $html .= $pdfOutputs[6];
        }
      }
    }

    if ($html  == "")
    {
      return "";
    }
  return "<h4>$title</h4><div class='content'>$html</div>";
}

/*---------------------------------------------------------*/
/*-Admin Question Edit Templates---------------------------*/
/*---------------------------------------------------------*/
function TextBoxETemplate($pdfOutput = "")
{
  ?>
  <div id="question_edit_pdf_values">
    %VAL1% - Textbox Value
  </div>
  <div>
    PDF Output (HTML):
  </div>
  <div>
    <textarea id="question_edit_pdf_output" name="question_edit_pdf_output[0]"><?php echo $pdfOutput; ?></textarea>
  </div>
  <?php
}

function TextBoxNoOutputETemplate($pdfOutput = "")
{
  ?>
  <div id="question_edit_pdf_values">
    %VAL1% - Textbox Value
  </div>
  <div>
    PDF Output (HTML):
  </div>
  <div>
    <textarea id="question_edit_pdf_output" name="question_edit_pdf_output[0]"><?php echo $pdfOutput; ?></textarea>
  </div>
  <?php
}

function PdfOnlyETemplate($pdfOutput = "")
{
  ?>
  <div>
    PDF Output (HTML):
  </div>
  <div>
    <textarea id="question_edit_pdf_output" name="question_edit_pdf_output[0]"><?php echo $pdfOutput; ?></textarea>
  </div>

  <?php
}

function TwoRemoteCheckboxesPDFOnlyETemplate($pdfOutput = "")
{
 $pdfOutput = explode(';&,&;',$pdfOutput);
 ?>
  <div>
    PDF Output (HTML):
  </div>
  <div>
  <div>
    Question ID 1: <input type="textbox" id="question_edit_pdf_output" name="question_edit_pdf_output[0]" value="<?php echo $pdfOutput[0]; ?>">
  </div>
  <div>
    Question ID 2: <input type="textbox" id="question_edit_pdf_output" name="question_edit_pdf_output[1]" value="<?php echo $pdfOutput[1]; ?>">
  </div>
    <textarea id="question_edit_pdf_output" name="question_edit_pdf_output[2]"><?php echo $pdfOutput[2]; ?></textarea>
  </div>

  <?php
}

function ConditionalTextboxETemplate($pdfOutput = "")
{
  ?>
  <div id="question_edit_pdf_values">
    %VAL1% - Textbox Value
  </div>
  <div>
    PDF Output (HTML):
  </div>
  <div>
    <textarea id="question_edit_pdf_output" name="question_edit_pdf_output[0]"><?php echo $pdfOutput; ?></textarea>
  </div>

<?php
}

function UnknownTextboxETemplate($pdfOutputs = "")
{
  $pdfOutput = explode(';&,&;',$pdfOutputs);
  ?>
  <div id="question_edit_pdf_values">
    %VAL1% - Textbox Value
  </div>
  <div>
    PDF Output (HTML):
  </div>
  <div>
    <textarea id="question_edit_pdf_output" name="question_edit_pdf_output[0]"><?php echo $pdfOutput[0]; ?></textarea>
  </div>
  <div>
    Unknown PDF Output (HTML):
  </div>
  <div>
    <textarea id="question_edit_pdf_output" name="question_edit_pdf_output[1]"><?php echo $pdfOutput[1]; ?></textarea>
  </div>

<?php
}

function ConditionalTextboxTwoETemplate($pdfOutputs = "")
{
  $pdfOutput = explode(';&,&;',$pdfOutputs);
  ?>
  <div id="question_edit_pdf_values">
    %VAL1% - Textbox Value
  </div>
  <div>
    PDF Output (HTML):
  </div>
  <div>
    <textarea id="question_edit_pdf_output" name="question_edit_pdf_output[0]"><?php echo $pdfOutput[0]; ?></textarea>
  </div>

<?php
}

function FourColumnTableHeaderETemplate($pdfOutputs = "")
{
  $pdfOutput = explode(';&,&;',$pdfOutputs);
  ?>
  <div id="question_edit_pdf_values">
  </div>
  <div>
    Header 1: <input type="textbox" id="question_edit_pdf_output" name="question_edit_pdf_output[0]" value="<?php echo $pdfOutput[0]; ?>">
  </div>
  <div>
    Header 2: <input type="textbox" id="question_edit_pdf_output" name="question_edit_pdf_output[1]" value="<?php echo $pdfOutput[1]; ?>">
  </div>
  <div>
    Header 3: <input type="textbox" id="question_edit_pdf_output" name="question_edit_pdf_output[2]" value="<?php echo $pdfOutput[2]; ?>">
  </div>
  <div>
    Header 4: <input type="textbox" id="question_edit_pdf_output" name="question_edit_pdf_output[3]" value="<?php echo $pdfOutput[3]; ?>">
  </div>
  <div>
    Header 5: <input type="textbox" id="question_edit_pdf_output" name="question_edit_pdf_output[4]" value="<?php echo $pdfOutput[4]; ?>">
  </div>

<?php
}

function FourColumnTableContentETemplate($pdfOutputs = "")
{
  $pdfOutput = explode(';&,&;',$pdfOutputs);
  ?>
  <div id="question_edit_pdf_values">
  </div>
  <div>
    Title: <input type="textbox" id="question_edit_pdf_output" name="question_edit_pdf_output[0]" value="<?php echo $pdfOutput[0]; ?>">
  </div>
<?php
}

function HintOnlyETemplate($pdfOutput = "")
{
  ?>
  <div id="question_edit_pdf_values">
  </div>
  <div>
    PDF Output (HTML):
  </div>
  <div>
    <textarea id="question_edit_pdf_output" name="question_edit_pdf_output[0]"><?php echo $pdfOutput; ?></textarea>
  </div>
  <?php
}

function CheckboxETemplate($pdfOutput = "")
{
  ?>
  <div>
    PDF Output (HTML):
  </div>
  <div>
    <textarea id="question_edit_pdf_output" name="question_edit_pdf_output[0]"><?php echo $pdfOutput; ?></textarea>
  </div>
  <?php
}

function CheckboxHintOnlyETemplate($pdfOutput = "")
{
  ?>
  <?php
}

function ImageWithDescETemplate($pdfOutputs = "")
{
  $pdfOutput = explode(';&,&;',$pdfOutputs);
  ?>
  <div id="question_edit_pdf_values">
    <!--%IMG1% - Image Path</br>
    %VAL1% - Textbox Value-->
  </div>
  <div>
    PDF Output (HTML):
  </div>
  <div>
    <textarea id="question_edit_pdf_output" name="question_edit_pdf_output[0]"><?php echo $pdfOutput[0]; ?></textarea>
  </div>
  <div>
  <?php
  if($pdfOutput[1] != "")
  {
    echo '<img src="' . WS_URL . 'media/uploads/' . $pdfOutput[1] . '" class="question_edit_image">';
  }
  ?>
    <input type="file" name="question_edit_file"/>
    <input type="hidden" name="question_edit_filedefault" value="<?php echo $pdfOutput[1]; ?>"/>
  </div>
<?php
}

function TwoColumnTableHeaderETemplate($pdfOutputs = "")
{
  $pdfOutput = explode(';&,&;',$pdfOutputs);
  ?>
  <div id="question_edit_pdf_values">
  </div>
  <div>
    Header 1: <input type="textbox" id="question_edit_pdf_output" name="question_edit_pdf_output[0]" value="<?php echo $pdfOutput[0]; ?>">
  </div>
  <div>
    Header 2: <input type="textbox" id="question_edit_pdf_output" name="question_edit_pdf_output[1]" value="<?php echo $pdfOutput[1]; ?>">
  </div>
<?php
}

function TwoColumnTableContentETemplate($pdfOutputs = "")
{
  $pdfOutput = explode(';&,&;',$pdfOutputs);
  ?>
  <div id="question_edit_pdf_values">
  </div>
  <div>
    Title: <input type="textbox" id="question_edit_pdf_output" name="question_edit_pdf_output[0]" value="<?php echo $pdfOutput[0]; ?>">
  </div>
<?php
}

function TwoColumnTableContentTwoETemplate($pdfOutputs = "")
{
  $pdfOutput = explode(';&,&;',$pdfOutputs);
  ?>
  <div id="question_edit_pdf_values">
  </div>
  <div>
    Title: <input type="textbox" id="question_edit_pdf_output" name="question_edit_pdf_output[0]" value="<?php echo $pdfOutput[0]; ?>">
  </div>
<?php
}

function ConditionalImageWithDescETemplate($pdfOutputs = "")
{
  $pdfOutput = explode(';&,&;',$pdfOutputs);
  ?>
  <div>
    PDF Output (HTML):
  </div>
  <div>
    <textarea id="question_edit_pdf_output" name="question_edit_pdf_output[0]"><?php echo $pdfOutput[0]; ?></textarea>
  </div>
  <div>
  <?php
  if($pdfOutput[1] != "")
  {
    echo '<img src="' . WS_URL . 'media/uploads/' . $pdfOutput[1] . '">';
  }
  ?>
    <input type="file" name="question_edit_file"/>
    <input type="hidden" name="question_edit_filedefault" value="<?php echo $pdfOutput[1]; ?>"/>
  </div>
<?php
}

function ConditionalTextboxThreeETemplate($pdfOutputs = "")
{
  $pdfOutput = explode(';&,&;',$pdfOutputs);
  ?>
  <div id="question_edit_pdf_values">
    %VAL1% - Textbox Value
  </div>
  <div>
    PDF Output (HTML):
  </div>
  <div>
    <textarea id="question_edit_pdf_output" name="question_edit_pdf_output[0]"><?php echo $pdfOutput[0]; ?></textarea>
  </div>
  <div>
    No PDF Output (HTML):
  </div>
  <div>
    <textarea id="question_edit_pdf_output" name="question_edit_pdf_output[1]"><?php echo $pdfOutput[1]; ?></textarea>
  </div>
<?php
}

function ThreeColumnTableHeaderETemplate($pdfOutputs = "")
{
  $pdfOutput = explode(';&,&;',$pdfOutputs);
  ?>
  <div id="question_edit_pdf_values">
  </div>
  <div>
    Header 1: <input type="textbox" id="question_edit_pdf_output" name="question_edit_pdf_output[0]" value="<?php echo $pdfOutput[0]; ?>">
  </div>
  <div>
    Header 2: <input type="textbox" id="question_edit_pdf_output" name="question_edit_pdf_output[1]" value="<?php echo $pdfOutput[1]; ?>">
  </div>
  <div>
    Header 3: <input type="textbox" id="question_edit_pdf_output" name="question_edit_pdf_output[2]" value="<?php echo $pdfOutput[2]; ?>">
  </div>
<?php
}

function ThreeColumnTableContentETemplate($pdfOutputs = "")
{
  $pdfOutput = explode(';&,&;',$pdfOutputs);
  ?>
  <div id="question_edit_pdf_values">
  </div>
  <div>
    Title: <input type="textbox" id="question_edit_pdf_output" name="question_edit_pdf_output[0]" value="<?php echo $pdfOutput[0]; ?>">
  </div>
<?php
}

function OperationsTableETemplate($pdfOutputs = "")
{
  $pdfOutput = explode(';&,&;',$pdfOutputs);
  ?>
  <div id="question_edit_pdf_values">
  </div>
  <div>
    Title: <input type="textbox" id="question_edit_pdf_output" name="question_edit_pdf_output[0]" value="<?php echo $pdfOutput[0]; ?>">
  </div>
<?php
}

function TankAlarmYesETemplate($pdfOutputs = "")
{
  $pdfOutput = explode(';&,&;',$pdfOutputs);
  ?>
  <div>
    Parent ID: <input type="textbox" name="question_edit_pdf_output[0]" value="<?php echo $pdfOutput[0]; ?>">
  </div>
  <div id="question_edit_pdf_values">
    %VAL1% - Textbox Value
  </div>
  <div>
    Visual PDF Output (HTML):
  </div>
  <div class="textarea_edit">
    <textarea name="question_edit_pdf_output[1]"><?php echo $pdfOutput[1]; ?></textarea>
  </div>
  <div>
    Audible PDF Output (HTML):
  </div>
  <div class="textarea_edit">
    <textarea name="question_edit_pdf_output[2]"><?php echo $pdfOutput[2]; ?></textarea>
  </div>
  <div>
    Remote PDF Output (HTML):
  </div>
  <div class="textarea_edit">
    <textarea name="question_edit_pdf_output[3]"><?php echo $pdfOutput[3]; ?></textarea>
  </div>
<?php
}

function TankAlarmETemplate($pdfOutputs = "")
{
  $pdfOutput = explode(';&,&;',$pdfOutputs);
  ?>
   <div>
    Parent ID: <input type="textbox" name="question_edit_pdf_output[0]" value="<?php echo $pdfOutput[0]; ?>">
  </div>
  <div id="question_edit_pdf_values">
    %IMG1% - Uploaded Image<br />
    %VAL1% - Textbox Value
  </div>
  <div>
    Visual PDF Output (HTML):
  </div>
  <div class="textarea_edit">
    <textarea name="question_edit_pdf_output[1]"><?php echo $pdfOutput[1]; ?></textarea>
  </div>
  <div>
    Audible PDF Output (HTML):
  </div>
  <div class="textarea_edit">
    <textarea name="question_edit_pdf_output[2]"><?php echo $pdfOutput[2]; ?></textarea>
  </div>
  <div>
    Remote PDF Output (HTML):
  </div>
  <div class="textarea_edit">
    <textarea name="question_edit_pdf_output[3]"><?php echo $pdfOutput[3]; ?></textarea>
  </div>
  <div>
    No PDF Output (HTML):
  </div>
  <div class="textarea_edit">
    <textarea name="question_edit_pdf_output[4]"><?php echo $pdfOutput[4]; ?></textarea>
  </div>
<?php
}

function TwoRadioRemoteETemplate($pdfOutputs = "")
{
  $pdfOutput = explode(';&,&;',$pdfOutputs);
  ?>
  <div id="question_edit_pdf_values">
  </div>
  <div id="question_edit_pdf_values">
    %VAL1% - Textbox Value 1<br />
    %VAL2% - Textbox Value 2
  </div>
  <div>
    Above Grade PDF Output (HTML):
  </div>
  <div class="textarea_edit">
    <textarea name="question_edit_pdf_output[0]"><?php echo $pdfOutput[0]; ?></textarea>
  </div>
  <div>
    Below PDF Output (HTML):
  </div>
  <div class="textarea_edit">
    <textarea name="question_edit_pdf_output[1]"><?php echo $pdfOutput[1]; ?></textarea>
  </div>
<?php
}

function TwoRadioETemplate($pdfOutputs = "")
{
  $pdfOutput = explode(';&,&;',$pdfOutputs);
  ?>
  <div id="question_edit_pdf_values">
  </div>
  <div>
    Yes PDF Output (HTML):
  </div>
  <div class="textarea_edit">
    <textarea name="question_edit_pdf_output[0]"><?php echo $pdfOutput[0]; ?></textarea>
  </div>
  <div>
    No Output (HTML):
  </div>
  <div class="textarea_edit">
    <textarea name="question_edit_pdf_output[1]"><?php echo $pdfOutput[1]; ?></textarea>
  </div>
<?php
}

function ThreeRadioETemplate($pdfOutputs = "")
{
  $pdfOutput = explode(';&,&;',$pdfOutputs);
  ?>
  <div id="question_edit_pdf_values">
  </div>
  <div id="question_edit_pdf_values">
    %VAL1% - Textbox Value<br />
    %IMG1% - Uploaded Image
  </div>
  <div>
    On Property PDF Output (HTML):
  </div>
  <div class="textarea_edit">
    <textarea name="question_edit_pdf_output[0]"><?php echo $pdfOutput[0]; ?></textarea>
  </div>
  <div>
    Off Property Output (HTML):
  </div>
  <div class="textarea_edit">
    <textarea name="question_edit_pdf_output[1]"><?php echo $pdfOutput[1]; ?></textarea>
  </div>
  <div>
    Combination Output (HTML):
  </div>
  <div class="textarea_edit">
    <textarea name="question_edit_pdf_output[2]"><?php echo $pdfOutput[2]; ?></textarea>
  </div>
<?php
}

function ThreeRadioTwoETemplate($pdfOutputs = "")
{
  $pdfOutput = explode(';&,&;',$pdfOutputs);
  ?>
  <div id="question_edit_pdf_values">
  </div>
  <div>
    Parent ID (Unknown 1): <input type="textbox" name="question_edit_pdf_output[0]" value="<?php echo $pdfOutput[0]; ?>">
  </div>
  <div>
    Parent ID (Unknown 2): <input type="textbox" name="question_edit_pdf_output[1]" value="<?php echo $pdfOutput[1]; ?>">
  </div>
  <div>
    Parent ID (Unknown 3): <input type="textbox" name="question_edit_pdf_output[2]" value="<?php echo $pdfOutput[2]; ?>">
  </div>
  <div>
    Yes PDF Output (HTML):
  </div>
  <div class="textarea_edit">
    <textarea name="question_edit_pdf_output[3]"><?php echo $pdfOutput[3]; ?></textarea>
  </div>
  <div>
    No PDF Output (HTML):
  </div>
  <div class="textarea_edit">
    <textarea name="question_edit_pdf_output[4]"><?php echo $pdfOutput[4]; ?></textarea>
  </div>
  <div>
    Unknown 1 Output (HTML):
  </div>
  <div class="textarea_edit">
    <textarea name="question_edit_pdf_output[5]"><?php echo $pdfOutput[5]; ?></textarea>
  </div>
  <div>
    Unknown 2 Output (HTML):
  </div>
  <div class="textarea_edit">
    <textarea name="question_edit_pdf_output[6]"><?php echo $pdfOutput[6]; ?></textarea>
  </div>
<?php
}

/*---------------------------------------------------------*/
/*-User Visible Question Templates-------------------------*/
/*---------------------------------------------------------*/
function PdfOnlyQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null)
{
?>
  <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <div class="question_set_row">

    <div class="question_set_row_hint">
      <?php
        if(!$_SESSION['USER']['Verbose'] )
        {
          ?>
            <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
          <?php
        }
      ?>
    </div>
    <div class="question_set_row_title">
      <?php echo $questionTitle; ?>
      <?php if($_SESSION['USER']['Verbose'] )
      {
        if($hint != "") 
        { 
          echo "<p class='hintVerbose'>$hint</p>"; 
        }
      }
      ?>
    </div>



      <div class="question_set_row_field">
      </div>
      <div class="question_set_row_edit">
        <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
      </div>
    </div>
    <div class="clear"></div>
  <?php } ?>

<?
  return 1;
}

function TwoRadioRemoteQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null,$pID="",$file="")
{
    $answers = explode(";+;+;",$answer);
    $answersText= explode(";&,&;",$answers[1]);
?>
    <form>
    <div class="question_set_row">

    <div class="question_set_row_hint">
      <?php
        if(!$_SESSION['USER']['Verbose'] )
        {
          ?>
            <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
          <?php
        }
      ?>
    </div>
    <div class="question_set_row_title">
      <?php echo $questionTitle; ?>
      <?php if($_SESSION['USER']['Verbose'] )
      {
        if($hint != "") 
        { 
          echo "<p class='hintVerbose'>$hint</p>"; 
        }
      }
      ?>
    </div>

      <div class="question_set_row_field">
        <input type="text" id="q_<?php echo $id; ?>" name="q_<?php echo $id; ?>[3]" class="q_<?php echo $id; ?> textbox form_question" placeholder="Type" <?php if($answersText[0] != "" && $answersText[0]!= "null" ) { echo 'value="' . $answersText[0] . '" '; } ?>><br />
        <label>Above grade<input type="radio" value="Above grade" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_aboveGrade" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "Above grade") { echo "checked"; }?>></label>
        <label>Below grade<input type="radio" value="Below grade" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_belowGrade" class="q_<?php echo $id; ?> form_question"  <?php if($answers[0] == "Below grade") { echo "checked"; }?>></label><br />
        <?php if($file != "") { ?><a href="<?php echo WS_URL; ?>media/uploads/<?php echo $file; ?>" data-lightbox="image-<?php echo $id;?>"><img src="<?php echo WS_URL; ?>media/uploads/<?php echo $file; ?>"  class="imageLightboxLink"></a><br /> <?php } ?>
        <iframe src="<?php echo WS_URL; ?>html/blocks/fileupload.php?<?php echo "qID=$id&pID=$pID";?>" class="upload_frame"></iframe><br />
        <input type="text" id="q_<?php echo $id; ?>" name="q_<?php echo $id; ?>[1]" class="q_<?php echo $id; ?> textbox form_question" placeholder="Location" <?php if($answersText[1] != "") { echo 'value="' . $answersText[1] . '" '; } ?>></br><br />

      </div>
      <?php if($_SESSION['USER']['Admin'] == true) { ?>
      <div class="question_set_row_edit">
        <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
      </div>
      <?php } ?>
    </div>
    <div class="clear"></div>
    </form>
<?
  return 1;
}

function TwoRadioQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null,$pID="")
{
    $answers = explode(";+;+;",$answer);
?>
    <form>
    <div class="question_set_row">

    <div class="question_set_row_hint">
      <?php
        if(!$_SESSION['USER']['Verbose'] )
        {
          ?>
            <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
          <?php
        }
      ?>
    </div>
    <div class="question_set_row_title">
      <?php echo $questionTitle; ?>
      <?php if($_SESSION['USER']['Verbose'] )
      {
        if($hint != "") 
        { 
          echo "<p class='hintVerbose'>$hint</p>"; 
        }
      }
      ?>
    </div>

      <div class="question_set_row_field">
        <label>Yes<input type="radio" value="Yes" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_yes" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "Yes") { echo "checked"; }?>></label></br>
        <label>No<input type="radio" value="No" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_no" class="q_<?php echo $id; ?> form_question"  <?php if($answers[0] == "No") { echo "checked"; }?>></br></label></br>
      </div>
      <?php if($_SESSION['USER']['Admin'] == true) { ?>
      <div class="question_set_row_edit">
        <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
      </div>
      <?php } ?>
    </div>
    <div class="clear"></div>
    </form>
<?
  return 1;
}

function ThreeRadioQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null,$pID="",$file="",$offset=-1)
{
    $answers = explode(";+;+;",$answer);

    if($offset >= 0)
    {
      $fileArray = array();
      $fileArray = explode(";#;#;",$file);
      $file = $fileArray[$offset];
    }

?>
    <form>
    <div class="question_set_row">

    <div class="question_set_row_hint">
      <?php
        if(!$_SESSION['USER']['Verbose'] )
        {
          ?>
            <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
          <?php
        }
      ?>
    </div>
    <div class="question_set_row_title">
      <?php echo $questionTitle; ?>
      <?php if($_SESSION['USER']['Verbose'] )
      {
        if($hint != "") 
        { 
          echo "<p class='hintVerbose'>$hint</p>"; 
        }
      }
      ?>
    </div>

      <div class="question_set_row_field">
        <input type="text" id="q_<?php echo $id; ?>" name="q_<?php echo $id; ?>[1]" class="q_<?php echo $id; ?> textbox form_question" placeholder="Location" <?php if($answers[1] != "") { echo 'value="' . $answers[1] . '" '; } ?>></br><br />
        <?php if($file !="") { ?><a href="<?php echo WS_URL; ?>media/uploads/<?php echo $file; ?>" data-lightbox="image-<?php echo $id;?>"><img src="<?php echo WS_URL; ?>media/uploads/<?php echo $file; ?>"  class="imageLightboxLink"></a><br /> <?php } ?>
        <iframe src="<?php echo WS_URL; ?>html/blocks/fileupload.php?<?php echo "qID=$id&pID=$pID&offset=$offset";?>" class="upload_frame"></iframe><br />
        <label>On the property<input type="radio" value="On the property" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_onTheProperty" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "On the property") { echo "checked"; }?>></label></br>
        <label>Off the property<input type="radio" value="Off the property" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_offTheProperty" class="q_<?php echo $id; ?> form_question"  <?php if($answers[0] == "Off the property") { echo "checked"; }?>></br></label></br>
        <label>Combination<input type="radio" value="Combination" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_combination" class="q_<?php echo $id; ?> form_question"  <?php if($answers[0] == "Combination") { echo "checked"; }?>></br></label>
      </div>
      <?php if($_SESSION['USER']['Admin'] == true) { ?>
      <div class="question_set_row_edit">
        <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
      </div>
      <?php } ?>
    </div>
    <div class="clear"></div>
    </form>
<?
  return 1;
}

function ThreeRadioTwoQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null,$pID="")
{
    $answers = explode(";+;+;",$answer);
?>
    <form>
    <div class="question_set_row">

    <div class="question_set_row_hint">
      <?php
        if(!$_SESSION['USER']['Verbose'] )
        {
          ?>
            <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
          <?php
        }
      ?>
    </div>
    <div class="question_set_row_title">
      <?php echo $questionTitle; ?>
      <?php if($_SESSION['USER']['Verbose'] )
      {
        if($hint != "") 
        { 
          echo "<p class='hintVerbose'>$hint</p>"; 
        }
      }
      ?>
    </div>

      <div class="question_set_row_field">
        <label>Yes<input type="radio" value="Yes" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_yes" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "Yes") { echo "checked"; }?>></label>
        <label>No<input type="radio" value="No" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_no" class="q_<?php echo $id; ?> form_question"  <?php if($answers[0] == "No") { echo "checked"; }?>></br></label>
        <label>Unknown<input type="radio" value="Unknown" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_unknown" class="q_<?php echo $id; ?> form_question"  <?php if($answers[0] == "Unknown") { echo "checked"; }?>></br></label>
      </div>
      <?php if($_SESSION['USER']['Admin'] == true) { ?>
      <div class="question_set_row_edit">
        <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
      </div>
      <?php } ?>
    </div>
    <div class="clear"></div>
    </form>
<?
  return 1;
}


function TankAlarmQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null,$pID="",$file="",$offset=-1)
{
    $answers = explode(";+;+;",$answer);
    $checkedAnswers = explode(";&,&;",$answers[0]);

    if($offset >= 0)
    {
      $fileArray = array();
      $fileArray = explode(";#;#;",$file);
      $file = $fileArray[$offset];
    }
?>
    <form>
    <div class="question_set_row">
    <div class="question_set_row_hint">
      <?php
        if(!$_SESSION['USER']['Verbose'] )
        {
          ?>
            <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
          <?php
        }
      ?>
    </div>
    <div class="question_set_row_title">
      <?php echo $questionTitle; ?>
      <?php if($_SESSION['USER']['Verbose'] )
      {
        if($hint != "") 
        { 
          echo "<p class='hintVerbose'>$hint</p>"; 
        }
      }
      ?>
    </div>
      <div class="question_set_row_field">
        <label>No<input type="radio" value="No" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_no" class="q_<?php echo $id; ?> form_question" <?php if($checkedAnswers[0] == "No") { echo "checked"; }?>></label>
        <label>Yes<input type="radio" value="Yes" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_yes" class="q_<?php echo $id; ?> form_question"  <?php if($checkedAnswers[0] == "Yes") { echo "checked"; }?>></label></br>
        <?php if($file != "") { ?><a href="<?php echo WS_URL; ?>media/uploads/<?php echo $file; ?>" data-lightbox="image-<?php echo $id;?>"><img src="<?php echo WS_URL; ?>media/uploads/<?php echo $file; ?>"  class="imageLightboxLink"></a><br /><?php } ?>
        <iframe src="<?php echo WS_URL; ?>html/blocks/fileupload.php?<?php echo "qID=$id&pID=$pID&offset=$offset";?>" class="upload_frame"></iframe></br>
        <label><input type="checkbox" class="q_<?php echo $id; ?> form_question checkbox" id="checkbox_q_visual" value="Visual" name="q_<?php echo $id; ?>[0]"  <?php if(in_array("Visual",$checkedAnswers)) { echo "checked"; }?>>Visual</label> 
        <label><input type="checkbox" class="q_<?php echo $id; ?> form_question checkbox" id="checkbox_q_audible" value="Audible" name="q_<?php echo $id; ?>[1]"  <?php if(in_array("Audible",$checkedAnswers)) { echo "checked"; }?>>Audible</label> 
        <label><input type="checkbox" class="q_<?php echo $id; ?> form_question checkbox" id="checkbox_q_remote" value="Remote" name="q_<?php echo $id; ?>[2]"  <?php if(in_array("Remote",$checkedAnswers)) { echo "checked"; }?>>Remote</label><br /> 
        <input type="text" id="q_<?php echo $id; ?>" name="q_<?php echo $id; ?>[3]" class="q_<?php echo $id; ?> textbox form_question" placeholder="Location" <?php if($answers[1] != "" && $answers[1]!= "null" ) { echo 'value="' . $answers[1] . '" '; } ?>>
      </div>
      <?php if($_SESSION['USER']['Admin'] == true) { ?>
      <div class="question_set_row_edit">
        <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
      </div>
      <?php } ?>
    </div>
    <div class="clear"></div>
    </form>
<?
  return 1;
}

function TankAlarmYesQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null)
{
  $answer = explode(";+;+;",$answer);
  $answers = explode(";&,&;",$answer[0]);
?>
    <div class="question_set_row">
      <div class="question_set_row_hint">
        <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="hint" title="<?php echo $hint; ?>"> <?php } ?>
      </div>
      <div class="question_set_row_title">
        <?php echo $questionTitle; ?>
      </div>
      <div class="question_set_row_field">
        <input type="checkbox" class="q_<?php echo $id; ?> form_question checkbox" id="checkbox_q_visual" value="Visual" name="q_<?php echo $id; ?>[0]"  <?php if(in_array("Visual",$answers)) { echo "checked"; }?>><label for="checkbox_q_visual">Visual</label> 
        <input type="checkbox" class="q_<?php echo $id; ?> form_question checkbox" id="checkbox_q_audible" value="Audible" name="q_<?php echo $id; ?>[1]"  <?php if(in_array("Audible",$answers)) { echo "checked"; }?>><label for="checkbox_q_audible">Audible</label> 
        <input type="checkbox" class="q_<?php echo $id; ?> form_question checkbox" id="checkbox_q_remote" value="Remote" name="q_<?php echo $id; ?>[2]"  <?php if(in_array("Remote",$answers)) { echo "checked"; }?>><label for="checkbox_q_remote">Remote</label><br /> 
        <input type="text" id="q_<?php echo $id; ?>" name="q_<?php echo $id; ?>[3]" class="q_<?php echo $id; ?> textbox form_question" <?php if($answer[1] != "" && $answer[1]!= "null" ) { echo 'value="' . $answer[1] . '" '; } ?>>
      </div>
      <?php if($_SESSION['USER']['Admin'] == true) { ?>
      <div class="question_set_row_edit">
        <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
      </div>
      <?php } ?>
    </div>
    <div class="clear"></div>

<?
  return 1;
}

function TwoRemoteCheckboxesPDFOnlyQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null)
{
?>
  <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <div class="question_set_row">
      <div class="question_set_row_hint">
        <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="hint" title="<?php echo $hint; ?>"> <?php } ?>
      </div>
      <div class="question_set_row_title">
        <?php echo $questionTitle; ?>
      </div>
      <div class="question_set_row_field">
      </div>
      <?php if($_SESSION['USER']['Admin'] == true) { ?>
      <div class="question_set_row_edit">
        <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
      </div>
      <?php } ?>
    </div>
    <div class="clear"></div>
  <?php } ?>

<?
  return 1;
}

function UnknownTextboxQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null)
{
  $answers = explode(";+;+;",$answer);
?>
    <div class="question_set_row">
    <div class="question_set_row_hint">
      <?php
        if(!$_SESSION['USER']['Verbose'] )
        {
          ?>
            <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
          <?php
        }
      ?>
    </div>
    <div class="question_set_row_title">
      <?php echo $questionTitle; ?>
      <?php if($_SESSION['USER']['Verbose'] )
      {
        if($hint != "") 
        { 
          echo "<p class='hintVerbose'>$hint</p>"; 
        }
      }
      ?>
    </div>

      <div class="question_set_row_field">
        <input type="checkbox" class="q_<?php echo $id; ?> form_question checkbox" id="checkbox_q_<?php echo $id; ?>" value="Unknown" name="q_<?php echo $id; ?>[0]"  <?php if($answers[0] == "Unknown") { echo "checked"; }?>><label for="checkbox_q_<?php echo $id; ?>">Unknown</label></br>
        <input type="text" id="q_<?php echo $id; ?>" name="q_<?php echo $id; ?>[1]" class="q_<?php echo $id; ?> textbox form_question" <?php if($answers[1] != "" && $answers[1]!= "null" ) { echo 'value="' . $answers[1] . '" '; } ?>>
      </div>
      <?php if($_SESSION['USER']['Admin'] == true) { ?>
      <div class="question_set_row_edit">
        <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
      </div>
      <?php } ?>
    </div>
    <div class="clear"></div>
<?php
}

function ConditionalTextboxQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null)
{
  $answers = explode(";+;+;",$answer);
?>
    <div class="question_set_row">
    <div class="question_set_row_hint">
      <?php
        if(!$_SESSION['USER']['Verbose'] )
        {
          ?>
            <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
          <?php
        }
      ?>
    </div>
    <div class="question_set_row_title">
      <?php echo $questionTitle; ?>
      <?php if($_SESSION['USER']['Verbose'] )
      {
        if($hint != "") 
        { 
          echo "<p class='hintVerbose'>$hint</p>"; 
        }
      }
      ?>
    </div>
      <div class="question_set_row_field">
        <label for="radio_q_<?php echo $id; ?>_no">No</label><input type="radio" value="No" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_no" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "No") { echo "checked"; }?>>
        <label for="radio_q_<?php echo $id; ?>_yes">Yes</label><input type="radio" value="Yes" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_yes" class="q_<?php echo $id; ?> form_question"  <?php if($answers[0] == "Yes") { echo "checked"; }?>></br>
        <input type="text" id="q_<?php echo $id; ?>" name="q_<?php echo $id; ?>[1]" class="q_<?php echo $id; ?> textbox form_question" <?php if($answers[1] != "" && $answers[1] != "null") { echo 'value="' . $answers[1] . '" '; } ?>>
      </div>
      <?php if($_SESSION['USER']['Admin'] == true) { ?>
      <div class="question_set_row_edit">
        <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
      </div>
      <?php } ?>
    </div>
    <div class="clear"></div>
<?php
}

function FinalRadioQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null)
{
  $answers = explode(";+;+;",$answer);
?>
    <div class="question_set_row">
      <div class="question_set_row_hint">
        <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
      </div>
      <div class="question_set_row_title">
        <?php echo $questionTitle; ?>
      </div>
      <div class="question_set_row_field">
        <label for="radio_q_<?php echo $id; ?>_trenches">Trenches</label><input type="radio" value="Trenches" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_trenches" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "Trenches") { echo "checked"; }?>><br />
        <label for="radio_q_<?php echo $id; ?>_beds">Beds</label><input type="radio" value="Beds" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_beds" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "Beds") { echo "checked"; }?>><br />
        <label for="radio_q_<?php echo $id; ?>_drip">Drip</label><input type="radio" value="Drip" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_drip" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "Drip") { echo "checked"; }?>><br />
        <label for="radio_q_<?php echo $id; ?>_mound">Mound</label><input type="radio" value="Mound" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_mound" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "Mound") { echo "checked"; }?>><br />
        <label for="radio_q_<?php echo $id; ?>_atgrade">At-Grade</label><input type="radio" value="At-Grade" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_atgrade" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "At-Grade") { echo "checked"; }?>><br />
        <label for="radio_q_<?php echo $id; ?>_spray">Spray</label><input type="radio" value="Spray" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_spray" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "Spray") { echo "checked"; }?>><br />
        <label for="radio_q_<?php echo $id; ?>_areaFill">Area fill</label><input type="radio" value="Area fill" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_areaFill" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "Area fill") { echo "checked"; }?>><br />
        <label for="radio_q_<?php echo $id; ?>_other">Other</label><input type="radio" value="Other" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_other" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "Other") { echo "checked"; }?>><br />
        <label for="radio_q_<?php echo $id; ?>_seepagePits">Seepage pits</label><input type="radio" value="Seepage pits" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_seepagePits" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "Seepage pits") { echo "checked"; }?>><br />
        <label for="radio_q_<?php echo $id; ?>_drywells">Drywells</label><input type="radio" value="Drywells" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_drywells" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "Drywells") { echo "checked"; }?>><br />
        <label for="radio_q_<?php echo $id; ?>_cesspool">Cesspool</label><input type="radio" value="Cesspool" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_cesspool" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "Cesspool") { echo "checked"; }?>><br />
        <label for="radio_q_<?php echo $id; ?>_lagoon">Lagoon</label><input type="radio" value="Lagoon" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_lagoon" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "Lagoon") { echo "checked"; }?>><br />
        <label for="radio_q_<?php echo $id; ?>_etBed">ET bed</label><input type="radio" value="ET bed" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_etBed" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "ET bed") { echo "checked"; }?>><br />
        <label for="radio_q_<?php echo $id; ?>_outfallSurfaceDischarge">Outfall/Surface discharge</label><input type="radio" value="Outfall/Surface discharge" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_outfallSurfaceDischarge" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "Outfall/Surface discharge") { echo "checked"; }?>><br />
        <label for="radio_q_<?php echo $id; ?>_other">Other</label><input type="radio" value="Other" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_other" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "Other") { echo "checked"; }?>><br />
        <input type="text" id="q_<?php echo $id; ?>" name="q_<?php echo $id; ?>[1]" class="q_<?php echo $id; ?> textbox form_question" <?php if($answers[1] != "" && $answers[1] != "null") { echo 'value="' . $answers[1] . '" '; } ?>>

      </div>
      <?php if($_SESSION['USER']['Admin'] == true) { ?>
      <div class="question_set_row_edit">
        <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
      </div>
      <?php } ?>
    </div>
    <div class="clear"></div>
<?php
}

function TextBoxQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null)
{
  $answers = explode(";+;+;",$answer);
?>
  <div class="question_set_row">
    <div class="question_set_row_hint">
      <?php
        if(!$_SESSION['USER']['Verbose'] )
        {
          ?>
            <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
          <?php
        }
      ?>
    </div>
    <div class="question_set_row_title">
      <?php echo $questionTitle; ?>
      <?php if($_SESSION['USER']['Verbose'] )
      {
        if($hint != "") 
        { 
          echo "<p class='hintVerbose'>$hint</p>"; 
        }
      }
      ?>
    </div>
    <div class="question_set_row_field">
      <input type="text"  name="q_<?php echo $id; ?>[0]" class="q_<?php echo $id; ?> textbox form_question" <?php if($answers[1] != "" && $answers[1] != "null") { echo 'value="' . $answers[1] . '" '; } ?>>
    </div>
    <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <div class="question_set_row_edit">
      <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
    </div>
    <?php } ?>
  </div>
  <div class="clear"></div>
<?
  return 1;
}

function OperationsTableQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null)
{
$answer = str_replace(";#;#;","",$answer);
$delims = array(";+;+;",";&,&;",);
$answers = array_values(array_filter(array_map('trim',explode("-|-",str_replace($delims, "-|-", $answer)))));
$answers = explode("-|-",str_replace($delims, "-|-", $answer));
array_shift($answers);

if($answers[0] == 0)
{
  $answers[0] = 1;
}

?>
  <div class="question_set_row">
    <div class="question_set_row_hint">
      <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
    </div>
    <div class="question_set_row_title">
      <?php echo $questionTitle; ?>
    </div>
    <div class="question_set_row_field">
      <input type="hidden"  name="q_<?php echo $id; ?>[0]" placeholder="Number" class="q_<?php echo $id; ?> textbox form_question reload counterInput_<?php echo $id; ?>" <?php if($answers[0] != "" && $answers[0] != "null") { echo 'value="' . $answers[0] . '" '; } ?>><br />
      <?php 
        
      $i = 0;  
      while($i < $answers[0])
      {
      $i++;
      ?>
      Activity #<?php echo $i; ?><br />
        <input type="text"  name="q_<?php echo $id . "[".strval(1 + (($i-1) * 4))."]"; ?>" placeholder="Activity" class="q_<?php echo $id; ?> textbox form_question" <?php if($answers[1 + (($i-1) * 4)] != "" && $answers[1 + (($i-1) * 4)] != "null") { echo 'value="' . $answers[1 + (($i-1) * 4)] . '" '; } ?>><br />

        <input type="text"  name="q_<?php echo $id . "[".strval(2 + (($i-1) * 4))."]"; ?>" placeholder="Frequency" class="q_<?php echo $id; ?> textbox form_question" <?php if($answers[2 + (($i-1) * 4)] != "" && $answers[2 + (($i-1) * 4)] != "null") { echo 'value="' . $answers[2 + (($i-1) * 4)] . '" '; } ?>><br />

        <input type="text"  name="q_<?php echo $id . "[".strval(3 + (($i-1) * 4))."]"; ?>" placeholder="Proffesional activities" class="q_<?php echo $id; ?> textbox form_question" <?php if($answers[3 + (($i-1) * 4)] != "" && $answers[3 + (($i-1) * 4)] != "null") { echo 'value="' . $answers[3 + (($i-1) * 4)] . '" '; } ?>><br />

        <input type="text"  name="q_<?php echo $id . "[".strval(4 + (($i-1) * 4))."]"; ?>" placeholder="Homeowner activity" class="q_<?php echo $id; ?> textbox form_question" <?php if($answers[4 + (($i-1) * 4)] != "" && $answers[4 + (($i-1) * 4)] != "null") { echo 'value="' . $answers[4 + (($i-1) * 4)] . '" '; } ?>><br />
      
      <?php
      }
      ?>
      <span class="addMore" value="<?php echo $id; ?>">Add</span> | <span class="removeOne" value="<?php echo $id; ?>">Remove</span>
    </div>
    <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <div class="question_set_row_edit">
      <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
    </div>
    <?php } ?>
  </div>
  <div class="clear"></div>
<?
  return 1;
}

function TextBoxNoOutputQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null)
{
  $answers = explode(";+;+;",$answer);
?>
  <div class="question_set_row">
    <div class="question_set_row_hint">
      <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
    </div>
    <div class="question_set_row_title">
      <?php echo $questionTitle; ?>
    </div>
    <div class="question_set_row_field">
      <input type="text"  name="q_<?php echo $id; ?>[0]" class="q_<?php echo $id; ?> textbox form_question" <?php if($answers[1] != "" && $answers[1] != "null") { echo 'value="' . $answers[1] . '" '; } ?>>
    </div>
    <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <div class="question_set_row_edit">
      <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
    </div>
    <?php } ?>
  </div>
  <div class="clear"></div>
<?
  return 1;
}

function ConditionalTextboxTwoQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null)
{
  $answers = explode(";+;+;",$answer);
?>
    <div class="question_set_row">
    <div class="question_set_row_hint">
      <?php
        if(!$_SESSION['USER']['Verbose'] )
        {
          ?>
            <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
          <?php
        }
      ?>
    </div>
    <div class="question_set_row_title">
      <?php echo $questionTitle; ?>
      <?php if($_SESSION['USER']['Verbose'] )
      {
        if($hint != "") 
        { 
          echo "<p class='hintVerbose'>$hint</p>"; 
        }
      }
      ?>
    </div>
      <div class="question_set_row_field">
        <label for="radio_q_<?php echo $id; ?>_no">No</label><input type="radio" value="No" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_no" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "No") { echo "checked"; }?>>
        <label for="radio_q_<?php echo $id; ?>_yes">Yes</label><input type="radio" value="Yes" name="q_<?php echo $id; ?>[0]" id="radio_q_<?php echo $id; ?>_yes" class="q_<?php echo $id; ?> form_question"  <?php if($answers[0] == "Yes") { echo "checked"; }?>></br>
        <br/><input type="text" id="q_<?php echo $id; ?>" name="q_<?php echo $id; ?>[1]" class="q_<?php echo $id; ?> textbox form_question" <?php if($answers[1] != "" && $answers[1] != "null") { echo 'value="' . $answers[1] . '" '; } ?>>
      </div>
      <?php if($_SESSION['USER']['Admin'] == true) { ?>
      <div class="question_set_row_edit">
        <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
      </div>
      <?php } ?>
    </div>
    <div class="clear"></div>
<?php
}

function FourColumnTableHeaderQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null)
{
?>
  <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <div class="question_set_row">
    <div class="question_set_row_hint">
      <?php
        if(!$_SESSION['USER']['Verbose'] )
        {
          ?>
            <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
          <?php
        }
      ?>
    </div>
    <div class="question_set_row_title">
      <?php echo $questionTitle; ?>
      <?php if($_SESSION['USER']['Verbose'] )
      {
        if($hint != "") 
        { 
          echo "<p class='hintVerbose'>$hint</p>"; 
        }
      }
      ?>
    </div>
      <div class="question_set_row_field">
      </div>
      <div class="question_set_row_edit">
        <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
      </div>
    </div>
    <div class="clear"></div>
  <?php } ?>

<?
  return 1;
}


function FourColumnTableContentQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null)
{
  $answers = explode(";+;+;",$answer);
  $answers = explode(";&,&;",$answers[1]);
?>
  <div class="question_set_row">
    <div class="question_set_row_hint">
      <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
    </div>
    <div class="question_set_row_title">
      <?php echo $questionTitle; ?>
    </div>
    <div class="question_set_row_field">
      <input type="text" id="q_<?php echo $id; ?>" name="q_<?php echo $id; ?>[1]" class="q_<?php echo $id; ?> textbox form_question" placeholder="Name" <?php if($answers[0] != "") { echo 'value="' . $answers[0] . '" '; } ?>></br>
      <input type="text" id="q_<?php echo $id; ?>" name="q_<?php echo $id; ?>[1]" class="q_<?php echo $id; ?> textbox form_question" placeholder="Website" <?php if($answers[1] != "") { echo 'value="' . $answers[1] . '" '; } ?>></br>
      <input type="text" id="q_<?php echo $id; ?>" name="q_<?php echo $id; ?>[1]" class="q_<?php echo $id; ?> textbox form_question" placeholder="Phone Number" <?php if($answers[2] != "") { echo 'value="' . $answers[2] . '" '; } ?>><br />
      <input type="text" id="q_<?php echo $id; ?>" name="q_<?php echo $id; ?>[1]" class="q_<?php echo $id; ?> textbox form_question" placeholder="Email" <?php if($answers[3] != "") { echo 'value="' . $answers[3] . '" '; } ?>>

    </div>
    <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <div class="question_set_row_edit">
      <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
    </div>
    <?php } ?>
  </div>
  <div class="clear"></div>
<?
  return 1;
}

function FourColumnTableContentOtherQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null)
{
$answer = str_replace(";#;#;","",$answer);
$delims = array(";+;+;",";&,&;",);
$answers = array_values(array_filter(array_map('trim',explode("-|-",str_replace($delims, "-|-", $answer)))));
$answers = explode("-|-",str_replace($delims, "-|-", $answer));
array_shift($answers);

if($answers[0] == 0)
{
  $answers[0] = 1;
}

?>
  <div class="question_set_row">
    <div class="question_set_row_hint">
      <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
    </div>
    <div class="question_set_row_title">
      <?php echo $questionTitle; ?>
    </div>
    <div class="question_set_row_field">
      <input type="hidden" id="q_<?php echo $id;?>"  name="q_<?php echo $id; ?>[0]" placeholder="Number" class="q_<?php echo $id; ?> textbox form_question reload counterInput_<?php echo $id; ?>" <?php if($answers[0] != "" && $answers[0] != "null") { echo 'value="' . $answers[0] . '" '; } ?>><br />
      <?php 
        
      $i = 0;  
      while($i < $answers[0])
      {
      $i++;
      ?>
      Other #<?php echo $i; ?><br />
        <input type="text" id="q_<?php echo $id;?>" name="q_<?php echo $id . "[".strval(1 + (($i-1) * 4))."]"; ?>" placeholder="Name" class="q_<?php echo $id; ?> textbox form_question" <?php if($answers[1 + (($i-1) * 4)] != "" && $answers[1 + (($i-1) * 4)] != "null") { echo 'value="' . $answers[1 + (($i-1) * 4)] . '" '; } ?>><br />

        <input type="text" id="q_<?php echo $id;?>"  name="q_<?php echo $id . "[".strval(2 + (($i-1) * 4))."]"; ?>" placeholder="Website" class="q_<?php echo $id; ?> textbox form_question" <?php if($answers[2 + (($i-1) * 4)] != "" && $answers[2 + (($i-1) * 4)] != "null") { echo 'value="' . $answers[2 + (($i-1) * 4)] . '" '; } ?>><br />

        <input type="text" id="q_<?php echo $id;?>"  name="q_<?php echo $id . "[".strval(3 + (($i-1) * 4))."]"; ?>" placeholder="Phone Number" class="q_<?php echo $id; ?> textbox form_question" <?php if($answers[3 + (($i-1) * 4)] != "" && $answers[3 + (($i-1) * 4)] != "null") { echo 'value="' . $answers[3 + (($i-1) * 4)] . '" '; } ?>><br />

        <input type="text" id="q_<?php echo $id;?>"  name="q_<?php echo $id . "[".strval(4 + (($i-1) * 4))."]"; ?>" placeholder="Email" class="q_<?php echo $id; ?> textbox form_question" <?php if($answers[4 + (($i-1) * 4)] != "" && $answers[4 + (($i-1) * 4)] != "null") { echo 'value="' . $answers[4 + (($i-1) * 4)] . '" '; } ?>><br />
      
      <?php
      }
      ?>
      <span class="addMore" value="<?php echo $id; ?>">Add</span> | <span class="removeOne" value="<?php echo $id; ?>">Remove</span>
    </div>
    <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <div class="question_set_row_edit">
      <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
    </div>
    <?php } ?>
  </div>
  <div class="clear"></div>
<?
  return 1;
}

function CheckboxQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null)
{
  $answers = explode(";+;+;",$answer);
?>
  <div class="question_set_row">
    <div class="question_set_row_hint">
      <?php
        if(!$_SESSION['USER']['Verbose'] )
        {
          ?>
          <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
          <?php
        }
       ?>
    </div>
    <div class="question_set_row_title">
      <?php echo $questionTitle; ?>
      <?php if($_SESSION['USER']['Verbose'] )
      {
        if($hint != "") 
        { 
          echo "<p class='hintVerbose'>$hint</p>"; 
        }
      }
      ?>
    </div>
    <div class="question_set_row_field">
        <label for="checkbox_q_<?php echo $id; ?>"></label><input type="checkbox" value="Yes" name="q_<?php echo $id; ?>[0]" id="checkbox_q_<?php echo $id; ?>" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "Yes") { echo "checked"; }?>>
    </div>
    <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <div class="question_set_row_edit">
      <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
    </div>
    <?php } ?>
  </div>
  <div class="clear"></div>
<?
  return 1;
}

function CheckboxHintOnlyQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null)
{
  $answers = explode(";+;+;",$answer);
?>
  <div class="question_set_row">
    <div class="question_set_row_hint">
      <?php
        if(!$_SESSION['USER']['Verbose'] )
        {
          ?>
            <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
          <?php
        }
      ?>
    </div>
    <div class="question_set_row_title">
      <?php echo $questionTitle; ?>
      <?php if($_SESSION['USER']['Verbose'] )
      {
        if($hint != "") 
        { 
          echo "<p class='hintVerbose'>$hint</p>"; 
        }
      }
      ?>
    </div>
    <div class="question_set_row_field">
        <label for="checkbox_q_<?php echo $id; ?>"></label><input type="checkbox" value="Yes" name="q_<?php echo $id; ?>[0]" id="checkbox_q_<?php echo $id; ?>" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "Yes") { echo "checked"; }?>>
    </div>
    <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <div class="question_set_row_edit">
      <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
    </div>
    <?php } ?>
  </div>
  <div class="clear"></div>
<?
  return 1;
}

function HintOnlyQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null)
{
?>
    <div class="question_set_row">
      <div class="question_set_row_hint">
      <?php
        if(!$_SESSION['USER']['Verbose'] )
        {
          ?>
            <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
          <?php
        }
      ?>
      </div>
      <div class="question_set_row_title">
        <?php echo $questionTitle; ?>
      <?php if($_SESSION['USER']['Verbose'] )
      {
        if($hint != "") 
        { 
          echo "<p class='hintVerbose'>$hint</p>"; 
        }
      }
      ?>

      </div>
      <div class="question_set_row_field">
      </div>
    <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <div class="question_set_row_edit">
      <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
    </div>
    <?php } ?>
    </div>
    <div class="clear"></div>

<?
  return 1;
}

function ImageWithDescQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null,$pID="",$file="",$pdfOutput="")
{
  $answers = explode(";+;+;",$answer);
  $pdfOutputs = explode(";&,&;",$pdfOutput);
?>
    <div class="question_set_row">
    <div class="question_set_row_hint">
      <?php
        if(!$_SESSION['USER']['Verbose'] )
        {
          ?>
            <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
          <?php
        }
      ?>
    </div>
    <div class="question_set_row_title">
      <?php echo $questionTitle; ?>
      <?php if($_SESSION['USER']['Verbose'] )
      {
        if($hint != "") 
        { 
          echo "<p class='hintVerbose'>$hint</p>"; 
        }
      }
      ?>
    </div>

      <div class="question_set_row_field">
        <input type="text" id="q_<?php echo $id; ?>" name="q_<?php echo $id; ?>[1]" class="q_<?php echo $id; ?> textbox form_question" placeholder="Description" <?php if($answers[1] != "") { echo 'value="' . $answers[1] . '" '; } ?>></br><br />
        <?php if($file != "") 
        { 
          ?><a href="<?php echo WS_URL; ?>media/uploads/<?php echo $file; ?>" data-lightbox="image-<?php echo $id;?>"><img src="<?php echo WS_URL; ?>media/uploads/<?php echo $file; ?>"  class="imageLightboxLink"></a><br /> <?php 
        } elseif($pdfOutputs[1] != "")
        { 
          ?><a href="<?php echo WS_URL; ?>media/uploads/<?php echo $pdfOutputs[1]; ?>" data-lightbox="image-<?php echo $id;?>"><img src="<?php echo WS_URL; ?>media/uploads/<?php echo $pdfOutputs[1]; ?>"  class="imageLightboxLink"></a><br /> <?php 
        } ?>
        <iframe src="<?php echo WS_URL; ?>html/blocks/fileupload.php?<?php echo "qID=$id&pID=$pID";?>" class="upload_frame"></iframe>
      </div>
    <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <div class="question_set_row_edit">
      <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
    </div>
    <?php } ?>
    </div>
    <div class="clear"></div>

<?
  return 1;
}

function TwoColumnTableHeaderQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null)
{
?>
  <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <div class="question_set_row">
      <div class="question_set_row_hint">
        <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
      </div>
      <div class="question_set_row_title">
        <?php echo $questionTitle; ?>
      </div>
      <div class="question_set_row_field">
      </div>
    <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <div class="question_set_row_edit">
      <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
    </div>
    <?php } ?>
    </div>
    <div class="clear"></div>
  <?php } ?>

<?
  return 1;
}


function TwoColumnTableContentQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null)
{
  $answers = explode(";+;+;",$answer);
?>
  <div class="question_set_row">
    <div class="question_set_row_hint">
      <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
    </div>
    <div class="question_set_row_title">
      <?php echo $questionTitle; ?>
    </div>
    <div class="question_set_row_field">
      <label for="checkbox_q_<?php echo $id; ?>"></label><input type="checkbox" value="Yes" name="q_<?php echo $id; ?>[0]" id="checkbox_q_<?php echo $id; ?>" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "Yes") { echo "checked"; }?>></br>
      <input type="text" id="q_<?php echo $id; ?>" name="q_<?php echo $id; ?>[1]" class="q_<?php echo $id; ?> textbox form_question" placeholder="Setback in feet" <?php if($answers[1] != "" && $answers[1] != "null") { echo 'value="' . $answers[1] . '" '; } ?>>
    </div>
    <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <div class="question_set_row_edit">
      <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
    </div>
    <?php } ?>
  </div>
  <div class="clear"></div>
<?
  return 1;
}

function TwoColumnTableContentTwoQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null)
{
    $answers = explode(";+;+;",$answer);
    $answer = explode(";&,&;",$answers[1]);
?>
  <div class="question_set_row">
    <div class="question_set_row_hint">
      <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
    </div>
    <div class="question_set_row_title">
      <?php echo $questionTitle; ?>
    </div>
    <div class="question_set_row_field">
      <label for="checkbox_q_<?php echo $id; ?>"></label><input type="checkbox" value="Yes" name="q_<?php echo $id; ?>[0]" id="checkbox_q_<?php echo $id; ?>" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "Yes") { echo "checked"; }?>></br>
      <input type="text" id="q_<?php echo $id; ?>" name="q_<?php echo $id; ?>[1]" class="q_<?php echo $id; ?> textbox form_question" placeholder="Name" <?php if($answer[0] != "") { echo 'value="' . $answer[0] . '" '; } ?>><br />
      <input type="text" id="q_<?php echo $id; ?>" name="q_<?php echo $id; ?>[2]" class="q_<?php echo $id; ?> textbox form_question" placeholder="Setback in feet" <?php if($answer[1] != "") { echo 'value="' . $answer[1] . '" '; } ?>>
    </div>
    <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <div class="question_set_row_edit">
      <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
    </div>
    <?php } ?>
  </div>
  <div class="clear"></div>
<?
  return 1;
}

function ConditionalImageWithDescQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null,$pID="",$file,$pdfOutput)
{
  $answers = explode(";+;+;",$answer);
  $pdfOutputs = explode(";&,&;",$pdfOutput);

?>
    <div class="question_set_row">
    <div class="question_set_rowThint">
      <?php
        if(!$_SESSION['USER']['Verbose'] )
        {
          ?>
            <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
          <?php
        }
      ?>
    </div>
    <div class="question_set_row_title">
      <?php echo $questionTitle; ?>
      <?php if($_SESSION['USER']['Verbose'] )
      {
        if($hint != "") 
        { 
          echo "<p class='hintVerbose'>$hint</p>"; 
        }
      }
      ?>
    </div>
      <div class="question_set_row_field">

        <label for="checkbox_q_<?php echo $id; ?>_yes">Yes</label><input type="checkbox" value="Yes" name="q_<?php echo $id; ?>[0]" id="checkbox_q_<?php echo $id; ?>_yes" class="q_<?php echo $id; ?> form_question" <?php if($answers[0] == "Yes") { echo "checked"; }?>></br>
        <?php if($file != "") 
        { 
          ?><a href="<?php echo WS_URL; ?>media/uploads/<?php echo $file; ?>" data-lightbox="image-<?php echo $id;?>"><img src="<?php echo WS_URL; ?>media/uploads/<?php echo $file; ?>"  class="imageLightboxLink"></a><br /> <?php 
        } elseif($pdfOutputs[1] != "")
        { 
          ?><a href="<?php echo WS_URL; ?>media/uploads/<?php echo $pdfOutputs[1]; ?>" data-lightbox="image-<?php echo $id;?>"><img src="<?php echo WS_URL; ?>media/uploads/<?php echo $pdfOutputs[1]; ?>"  class="imageLightboxLink"></a><br /> <?php 
        } ?>
        <iframe src="<?php echo WS_URL; ?>html/blocks/fileupload.php?<?php echo "qID=$id&pID=$pID";?>" class="upload_frame"></iframe></br>
        <input type="text" id="q_<?php echo $id; ?>" name="q_<?php echo $id; ?>[1]" class="q_<?php echo $id; ?> textbox form_question" <?php if($answers[1] != "" && $answers[1] != "null") { echo 'value="' . $answers[1] . '" '; } ?>>
      </div>
      <?php if($_SESSION['USER']['Admin'] == true) { ?>
      <div class="question_set_row_edit">
        <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
      </div>
      <?php } ?>
    </div>
    <div class="clear"></div>

<?
  return 1;
}

function ConditionalTextboxThreeQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null)
{
?>
    <div class="question_set_row">
      <div class="question_set_row_hint">
        <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
      </div>
      <div class="question_set_row_title">
        <?php echo $questionTitle; ?>
      </div>
      <div class="question_set_row_field">
        <input type="radio">Yes<input type="radio">No
        <br/><input type="text" id="q_<?php echo $id; ?>" name="q_<?php echo $id; ?>" class="textbox" <?php if($answer != "") { echo 'value="' . $answer . '" '; } ?>>
      </div>
      <?php if($_SESSION['USER']['Admin'] == true) { ?>
      <div class="question_set_row_edit">
        <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
      </div>
      <?php } ?>
    </div>
    <div class="clear"></div>
<?php
}

function ThreeColumnTableHeaderQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null)
{
?>
  <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <div class="question_set_row">
      <div class="question_set_row_hint">
        <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
      </div>
      <div class="question_set_row_title">
        <?php echo $questionTitle; ?>
      </div>
      <div class="question_set_row_field">
      </div>
      <div class="question_set_row_edit">
        <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
      </div>
    </div>
    <div class="clear"></div>
  <?php } ?>

<?
  return 1;
}


function ThreeColumnTableContentQTemplate($hint="", $questionTitle="", $question="", $id="", $answer="",$database = null)
{
  $answers = explode(";+;+;",$answer);
  $answers = explode(";&,&;",$answers[1]);
?>
  <div class="question_set_row">
    <div class="question_set_row_hint">
      <?php if($hint != "") { ?><img src="<?php echo WS_URL; ?>media/hint.png" alt="Hint" title="<?php echo $hint; ?>"><?php } ?>
    </div>
    <div class="question_set_row_title">
      <?php echo $questionTitle; ?>
    </div>
    <div class="question_set_row_field">
      <input type="text" id="q_<?php echo $id; ?>" name="q_<?php echo $id; ?>[1]" class="q_<?php echo $id; ?> textbox form_question" <?php if($answers[0] != "") { echo 'value="' . $answers[0] . '" '; } ?>></br>
      <input type="text" id="q_<?php echo $id; ?>" name="q_<?php echo $id; ?>[1]" class="q_<?php echo $id; ?> textbox form_question" <?php if($answers[1] != "") { echo 'value="' . $answers[1] . '" '; } ?>></br>
    </div>
    <?php if($_SESSION['USER']['Admin'] == true) { ?>
    <div class="question_set_row_edit">
      <a href="<?php echo WS_URL . 'admin/questions/edit/' . $id .'/'; ?>">Edit</a> | <a href="<?php echo WS_URL . 'admin/questions/delete/' . $id .'/'; ?>">Delete</a>
    </div>
    <?php } ?>
  </div>
  <div class="clear"></div>
<?
  return 1;
}


