<?php

function printAnswer($answer, $type, $value=null)
{
    global $projectID;
    
    switch ($answer['type'])
    {
        case "text":
            if (!empty($value['other_sequenceID']))
            {
                echo "
                    <input div_type='$type' question_type='other' question_id='{$answer['questionID']}' onblur=\"updateRow({$answer['questionID']}, '$type', {$value['other_sequenceID']})\" type='text' name='other_{$value['other_sequenceID']}_".$type."_{$answer['id']}' id='other_{$value['other_sequenceID']}_".$type."_{$answer['id']}' value='{$value['value']}' class='form_question' />
                ";
            }
            else
            {
                if (!empty($value[0]))
                    $value = $value[0]['value'];
                else
                    $value = "";
                
                echo "
                    <input div_type='$type' onblur='updateRow({$answer['questionID']}, \"$type\")' type='text' name='text_".$type."_{$answer['id']}' id='".$type."_{$answer['id']}' value='$value' class='textbox form_question' />
                ";
            }
            break;
        case "radio":
            if (!empty($value[0]) && $value[0]['value'] == "on")
                    $value = "checked";
                else
                    $value = "";
            
            echo "
                <input div_type='$type' onclick='updateRow({$answer['questionID']}, \"$type\")' type='radio' name='radio_".$type."_{$answer['questionID']}' id='".$type."_{$answer['id']}' value='{$answer['label']}' class='form_question' $value />
                <label for='".$type."_{$answer['id']}' class='form_question'>{$answer['label']}</label>
            ";
            break;
        case "checkbox":
            if (!empty($value[0]) && $value[0]['value'] == "on")
                    $value = "checked";
                else
                    $value = "";
            
            echo "
                <input $value div_type='$type' onclick='updateRow({$answer['questionID']}, \"$type\")' type='checkbox' name='checkbox_".$type."_{$answer['id']}' id='".$type."_{$answer['id']}' class='form_question checkbox' />
                <label for='".$type."_{$answer['id']}' class='form_question'>{$answer['label']}</label>
            ";
            break;
        case "image":
            if (!empty($value[0]))
                    $value = WS_URL."media/uploads/{$value[0]['value']}";
                else
                    $value = "";
            
            echo "
                <a class='right' href='$value' data-lightbox='image-116'>
                    <img src='$value' class='imageLightboxLink'>
                </a><br />
                <iframe div_type='$type' id='iframe_$type"."_{$answer['id']}'  class='right' style='clear: both; width:60%; min-width:60%; height:100px; min-height:100px;' src='".WS_URL."html/blocks/fileupload.php?userID={$_SESSION['USER']['ID']}&answerID={$answer['id']}&amp;type=".$type."&amp;projectID=$projectID' class='upload_frame'></iframe>
            ";
            break;
        case "unknown":
            if (!empty($value[0]) && $value[0]['value'] == "on")
                    $value = "action='click'";
                else
                    $value = "";
            
            echo "
                <input $value div_type='$type' onclick='updateRow({$answer['questionID']}, \"$type\")' type='checkbox' onclick='hideOtherAnswers({$answer['questionID']})' name='unknown_".$type."_{$answer['id']}' id='".$type."_{$answer['id']}' class='form_question checkbox' />
                <label for='".$type."_{$answer['id']}' class='form_question'>{$answer['label']}</label>
            ";
            break;
    }
}

function isSelected($sectionID, $sectionsArray)
{
    foreach ($sectionsArray as $section)
    {
        if ($section['sectionID'] == $sectionID)
            return true;
    }
    return false;
}

function echoCategory($category, $type='normal')
{
    global $questionsClass, $answersClass, $projectID;
    
    echo "<h3 class='question_header'>{$category['title']}</h3>";
    
    $questions = $questionsClass->listQuestions($category['id']);

    echo "<div class='question_set_wrapper hidden'>";

    $titlePrinted = false;
    $intent = "0px";
    foreach ($questions as $question)
    {
        if ($question['type'] == "title")
        {
            $titlePrinted = true;
            $intent = "0px";
        }
        
        if($question['type'] == "question" && $titlePrinted)
            $intent = "20px";
        
        $spawnID = 0;
        if ($type != "normal"){
            $spawnArr = explode("_", $type);
            $spawnID = array_pop ($spawnArr);
        }
        
        // PRINT QUESTION OF OTHER TYPE
        if ($question['type'] == "other")
        {            
            $answers = $answersClass->listAnswers($question['id']);

            foreach ($answers as $answer)
            {
                if ($answer['type'] == 'checkbox')
                    $checkBoxID = $answer['id'];
                elseif ($answer['type'] == "text")
                    $textFieldID = $answer['id'];
            }
            
            $currentOthers = $answersClass->getUserAnswers($_SESSION['USER']['ID'], $projectID, $textFieldID, $spawnID);
            $answerDetails = $answersClass->getDetails($textFieldID);

            $i = 1;
            foreach ($currentOthers as $answer)
            {
                echo "
                    <div class='question_set_row' id='other_".$i."_".$type."_question_row_{$question['id']}'>
                        <div style='padding-left:$intent' class='question_set_row_hint'>
                            <img src='".WS_URL."/media/hint.png' alt='Hint' title=\"{$question['hint']}\">
                        </div>
                        <div class='question_set_row_title'>
                            {$question['title']}
                        </div>
                        <div class='question_set_row_field'>
                ";

                echo "<div class='question_answers {$answerDetails['type']}'  category_type='$type'>";

                printAnswer($answerDetails, $type, $answer);

                echo "</div>";
                echo "</div>
                    </div>
                    <div class='clear'></div>
                ";
                $i++;
            }
            
            echo "
                <div class='question_set_row' id='other_".$i."_".$type."_question_row_{$question['id']}'>
                    <div style='padding-left:$intent' class='question_set_row_hint'>
                        <img src='".WS_URL."/media/hint.png' alt='Hint' title=\"{$question['hint']}\">
                    </div>
                    <div class='question_set_row_title'>
                        {$question['title']}
                    </div>
                    <div class='question_set_row_field'>
            ";
                            
            echo "
                <input div_type='$type' question_type='other' question_id='{$question['id']}' onclick='addNewOtherBox({$question['id']}, \"$type\", \"$intent\", \"".WS_URL."\", \"{$question['hint']}\", \"{$question['title']}\", $checkBoxID, $textFieldID); return false;' type='checkbox' name='other_".$i."_".$type."_$checkBoxID' id='other_".$i."_".$type."_$checkBoxID' class='form_question checkbox' />
            ";
            echo "</div>
                </div>
                <div class='clear'></div>
            ";
        }
        else // PRINT ALL OTHER QUESTIONS
        {
            echo "
                <div class='question_set_row' id='$type"."_question_row_{$question['id']}'>
                    <div style='padding-left:$intent' class='question_set_row_hint'>
                        <img src='".WS_URL."/media/hint.png' alt='Hint' title=\"{$question['hint']}\">
                    </div>
                    <div class='question_set_row_title'>
                        {$question['title']}
                    </div>
            ";

            $answers = $answersClass->listAnswers($question['id']);
            echo "<div class='question_set_row_field'>";
            foreach ($answers as $answer)
            {
                $value = $answersClass->getUserAnswers($_SESSION['USER']['ID'], $projectID, $answer['id'], $spawnID);
                $divSuffix = "";
                $divClass = "";
                if ($answer['parentID'])
                {
                    $parentValue = $answersClass->getUserAnswers($_SESSION['USER']['ID'], $projectID, $answer['parentID'], $spawnID);
                    $hidden = (empty($parentValue[0])) ? "hidden" : "";
                    
                    $divClass = "$hidden child";
                    $divSuffix = "id='child_{$answer['parentID']}'";
                }

                echo "<div class='question_answers {$answer['type']} $divClass' $divSuffix category_type='$type'>";
                printAnswer($answer, $type, $value);
                echo "</div>";
            }
            
            echo "</div>
                </div>
                <div class='clear'></div>
            ";
        }
        
    }
    echo "</div>";
}

function echoSpawnCategory($category)
{
    global $categoriesClass;
    
    $selected = $categoriesClass->getNumberOfSpawnBoxesForUser($category['id'], $_SESSION['USER']['ID']);
    $img = "<img src='".WS_URL."/media/hint.png' alt='Hint' title='Please select {$category['spawn_box_label']} that you have'>";
    
    $selectBox = "<select class='right' name='spawn_{$category['id']}' id='spawn_{$category['id']}'>";
    for ($i=1; $i<=10; $i++)
    {
        $slct = "";
        if ($selected == $i)
            $slct = 'selected="selected"';
        
        $selectBox .= "<option $slct>$i</option>";
    }
    $selectBox .= "</select>";
    
    $host = WS_URL;
    echo <<<HTML_STR
        <div class='question_set_wrapper' style='display:block; float:left; width:100%;' id='cat_{$category['id']}'>
            <form method='post' id='spawn_category_{$category['id']}'>
                <input type='hidden' name='action' value='save_spawn_input'/> 
                <input type='hidden' name='categoryID' value='{$category['id']}'/> 
                <div class='question_set_row'>
                    <div class='question_set_row_hint'>
                        $img
                    </div>
                    <div class='question_set_row_title'>
                        {$category['spawn_box_label']}
                    </div>
                    <div class='question_set_row_field'>
                        <div class='question_answers'>
                            <a class='right' href='#' style='margin-left:15px;' onclick="updateSpawn('{$category['id']}', '$host');return false;" >Update</a>
                            $selectBox
                        </div>
                    </div>    
                </div>
        </div>
        <div class='clear'></div>
HTML_STR;
                    
    for ($z = 0; $z < $selected; $z++)
    {
        echoCategory($category, "spawn_$z");
    }
}