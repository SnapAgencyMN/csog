<?php

function printAnswer($answer, $type, $value=null)
{
    global $projectID;
    $otherID = @$value[0]['other_sequenceID'] > 0 ? $value[0]['other_sequenceID'] : 0;
    
    $namePrefix = "";
    $questionType = "";
    if ($otherID > 0)
    {
        $namePrefix = "other_$otherID"."_";
        $questionType = "question_type='other'";
    }
    
    switch ($answer['type'])
    {   
        case "text":
            
            $value = empty($value[0]['value']) ? "" : $value[0]['value'];
            echo "
                <input placeholder='{$answer['label']}' "
                . "div_type='$type' "
                . "onblur='updateRow({$answer['questionID']}, \"$type\", $otherID)' "
                . "type='text' "
                . "name='$namePrefix"."text_".$type."_{$answer['id']}' "
                . "id='".$namePrefix.$type."_{$answer['id']}' "
                . "value='$value' $questionType class='textbox form_question' />";
                
            break;
        case "radio":
            if (!empty($value[0]) && $value[0]['value'] == "on")
                    $value = "checked";
                else
                    $value = "";
            
            echo "
                <input div_type='$type' onclick='updateRow({$answer['questionID']}, \"$type\", $otherID)' type='radio' name='radio_".$type."_{$answer['questionID']}' id='".$type."_{$answer['id']}' value=\"{$answer['label']}\" class='form_question' $value />
                <label for='".$type."_{$answer['id']}' class='form_question'>{$answer['label']}</label>
            ";
            break;
        case "checkbox":
            if (!empty($value[0]['value']) && $value[0]['value'] == "on")
                    $value = "checked";
                else
                    $value = "";
            
            echo "
                <input $value "
                . "div_type='$type' "
                . "onclick='updateRow({$answer['questionID']}, \"$type\", $otherID)' "
                . "type='checkbox' "
                . "name='".$namePrefix."checkbox_".$type."_{$answer['id']}' "
                . "id='$namePrefix".$type."_{$answer['id']}' "
                . "question_id='{$answer['questionID']}' "
                . "$questionType class='form_question checkbox' />
                    
                <label for='".$type."_{$answer['id']}' class='form_question'>{$answer['label']}</label>
            ";
            break;
        case "image":
            if (@$_SESSION['USER']['Admin'] == 1 && $answer['default'] == 1)
            {
                $value = WS_URL."media/uploads/defaults/{$answer['id']}";
            }
            else
            {
                if (!empty($value[0]['value']))
                    $value = WS_URL."media/uploads/{$value[0]['value']}";
                elseif ($answer['default'] == 1)
                    $value = WS_URL."media/uploads/defaults/{$answer['id']}";
                else
                    $value = WS_URL."media/site-images/noimg.jpg";
            }
            $rnd = rand(1, 1000000);
            
            echo "
                <a class='right' href='$value' data-lightbox='image-116'>
                    <img src='$value?$rnd' class='imageLightboxLink'>
                </a><br />
                <iframe div_type='$type' id='iframe_$type"."_{$answer['id']}'  class='right' style='clear: both; width:60%; min-width:100%; height:100px; min-height:100px;' src='".WS_URL."html/blocks/fileupload.php?userID={$_SESSION['USER']['ID']}&answerID={$answer['id']}&amp;type=".$type."&amp;projectID=$projectID&amp;default={$answer['default']}' class='upload_frame'></iframe>
            ";
            break;
        case "unknown":
            if (!empty($value[0]) && $value[0]['value'] == "on")
                    $value = "action='click'";
                else
                    $value = "";
            
            echo "
                <input $value div_type='$type' onclick='updateRow({$answer['questionID']}, \"$type\", $otherID)' type='checkbox' onclick='hideOtherAnswers({$answer['questionID']})' name='unknown_".$type."_{$answer['id']}' id='".$type."_{$answer['id']}' class='form_question checkbox' />
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
    $suffix = "";
    
    $spawnID = 0;
    if ($type != "normal"){
        $spawnArr = explode("_", $type);
        $spawnID = array_pop ($spawnArr);
        $suffix = "#".($spawnID+1);
    }
    
    
    echo "<h3 class='question_header'>{$category['title']} $suffix</h3>";
    
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
        
        $requiredClass = "";
        $requiredPrefix = "";
        if ($question['required'] == 1)
        {
            $requiredClass = "required";
            $requiredPrefix = "*";
        }
        
        if($question['type'] == "question" && $titlePrinted)
            $intent = "20px";
        
        // PRINT QUESTION OF OTHER TYPE
        if ($question['type'] == "other")
        {            
            $answers = $answersClass->listParentAnswers($question['id']);

            foreach ($answers as $answer)
            {
                if ($answer['type'] == 'checkbox')
                    $checkBoxID = $answer['id'];
            }
            
            $currentOthers = $answersClass->getUserAnswers($_SESSION['USER']['ID'], $projectID, $checkBoxID, $spawnID);

            for ($i = 1; $i <= count($currentOthers)+1; $i++)
            {
                $hint = "";
                if (!empty($question['hint']))
                {
                    if(!$_SESSION['USER']['Verbose'] )
                        $hint = "<img src='".WS_URL."/media/hint.png' alt='Hint' title=\"{$question['hint']}\">";
                        
                }
                
                echo "
                    <div class='question_set_row $requiredClass' id='other_".$i."_".$type."_question_row_{$question['id']}'>
                        <div style='padding-left:$intent' class='question_set_row_hint'>
                            $hint
                        </div>
                        <div class='question_set_row_title'>
                            {$question['title']} $requiredPrefix
                ";
                if($_SESSION['USER']['Verbose'] )
                {
                    if(!empty($question['hint'])) 
                    { 
                        echo "<p class='hintVerbose'>{$question['hint']}</p>"; 
                    }
                }
                echo "</div>";

           
                $answers = $answersClass->listAnswers($question['id']);
                
                echo "<div class='question_set_row_field'>";
                foreach ($answers as $answer)
                {
                    $value = $answersClass->getUserAnswers($_SESSION['USER']['ID'], $projectID, $answer['id'], $spawnID, $i);
                    
                    if (empty($value))
                        $value[0]['other_sequenceID'] = $i;
                    
                    $divSuffix = "";
                    $divClass = "";
                    if ($answer['parentID'])
                    {
                        $parentValue = $answersClass->getUserAnswers($_SESSION['USER']['ID'], $projectID, $answer['parentID'], $spawnID, $i);
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
        else // PRINT ALL OTHER QUESTIONS
        {
            $titleClass = "";
            if ($question['type'] == 'title')
                $titleClass = "title";
            
            $hint = "";
            if (!empty($question['hint']))
            {
                if(!$_SESSION['USER']['Verbose'] )
                    $hint = "<img src='".WS_URL."/media/hint.png' alt='Hint' title=\"{$question['hint']}\">";
            }
            
            echo "
                <div class='question_set_row $requiredClass' id='$type"."_question_row_{$question['id']}'>
                    <div style='padding-left:$intent' class='question_set_row_hint'>
                        $hint
                    </div>
                    <div class='question_set_row_title $titleClass'>
                        {$question['title']} $requiredPrefix
            ";
            if($_SESSION['USER']['Verbose'] )
            {
                if(!empty($question['hint'])) 
                { 
                    echo "<p class='hintVerbose'>{$question['hint']}</p>"; 
                }
            }
            echo "</div>";

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
    
    $img = "";
    $subTitle = "";
    
    /*
    if(!$_SESSION['USER']['Verbose'] )
        $img = "<img src='".WS_URL."/media/hint.png' alt='Hint' title='{$category['spawn_box_label']}'>";
    else
        $subTitle = "<p class='hintVerbose'>{$category['spawn_box_label']}</p>";
    */
        
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
                        $subTitle
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
    
    if ($selected == 0)
        $selected++;
    
    for ($z = 0; $z < $selected; $z++)
    {
        echoCategory($category, "spawn_$z");
    }
}