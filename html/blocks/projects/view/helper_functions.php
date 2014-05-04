<?php

function printAnswer($answer, $type)
{
    switch ($answer['type'])
    {
        case "text":
            echo "
                <input onblur='updateRow({$answer['questionID']})' type='text' name='".$type."_{$answer['id']}' id='".$type."_{$answer['id']}' class='textbox form_question' />
            ";
            break;
        case "radio":
            echo "
                <input onclick='updateRow({$answer['questionID']})' type='radio' name='radio_".$type."_{$answer['questionID']}' id='".$type."_{$answer['id']}' class='form_question' />
                <label for='".$type."_{$answer['id']}' class='form_question'>{$answer['label']}</label>
            ";
            break;
        case "checkbox":
            echo "
                <input onclick='updateRow({$answer['questionID']})' type='checkbox' name='checkbox_".$type."_{$answer['questionID']}' id='".$type."_{$answer['id']}' class='form_question checkbox' />
                <label for='".$type."_{$answer['id']}' class='form_question'>{$answer['label']}</label>
            ";
            break;
        case "image":
            echo "
                <a class='right' href='".WS_URL."media/uploads/139628533653399f98999a2.jpeg' data-lightbox='image-116'><img src='".WS_URL."media/uploads/139628533653399f98999a2.jpeg' class='imageLightboxLink'>
                    <img src='".WS_URL."media/uploads/139628533653399f98999a2.jpeg' class='imageLightboxLink'>
                </a><br />
                <iframe class='right' style='width:60%; min-width:60%; height:100px; min-height:100px;' src='".WS_URL."html/blocks/fileupload.php?id=".$type."_{$answer['id']}' class='upload_frame'></iframe>
            ";
            break;
        case "unknown":
            echo "
                <input onclick='updateRow({$answer['questionID']})' type='checkbox' onclick='hideOtherAnswers({$answer['questionID']})' name='unknown_".$type."_{$answer['questionID']}' id='".$type."_{$answer['id']}' class='form_question checkbox' />
                <label for='".$type."_{$answer['id']}' class='form_question'>{$answer['label']}</label>
            ";
            break;
            break;
        case "other":
            echo "
                <input onclick='updateRow({$answer['questionID']})' type='radio' name='other_".$type."_{$answer['questionID']}' id='".$type."_{$answer['id']}' class='form_question' />
                <label for='".$type."_{$answer['id']}' class='form_question'>{$answer['label']}</label>
            ";
                
                // ECHO input box and reveal if radio selected
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
    global $questionsClass, $answersClass;
    
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
        
        echo "
            <div class='question_set_row' id='question_row_{$question['id']}'>
                <div style='padding-left:$intent' class='question_set_row_hint'>
                    <img src='".WS_URL."/media/hint.png' alt='Hint' title='{$question['hint']}'>
                </div>
                <div class='question_set_row_title'>
                    {$question['title']}
                </div>
        ";

        $answers = $answersClass->listAnswers($question['id']);
        echo "<div class='question_set_row_field'>";
        foreach ($answers as $answer)
        {
            $divSuffix = "";
            $divClass = "";
            if ($answer['parentID'])
            {
                $divClass = "hidden child";
                $divSuffix = "id='child_{$answer['parentID']}' category_type='$type'";
            }
            
            echo "<div class='question_answers $divClass' $divSuffix>";
            printAnswer($answer, $type);
            echo "</div>";
        }
        echo "</div>
            </div>
            <div class='clear'></div>
        ";
    }
    echo "</div>";
}

function echoSpawnCategory($category)
{
    global $categoriesClass;
    
    $selected = $categoriesClass->getNumberOfSpawnBoxesForUser($category['id'], $_SESSION['USER']['ID']);
    $img = "<img src='".WS_URL."/media/hint.png' alt='Hint' title='Please select {$category['spawn_box_label']} that you have'>";
    
    $selectBox = "<select name='spawn_{$category['id']}'>";
    for ($i=1; $i<=10; $i++)
    {
        $slct = "";
        if ($selected == $i)
            $slct = 'selected="selected"';
        
        $selectBox .= "<option $slct>$i</option>";
    }
    $selectBox .= "</select>";
    
    echo <<<HTML_STR
        <div class='question_set_wrapper' style='display:block; float:left; width:100%;'>
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
                            $selectBox
                        </div>
                    </div>    
                    <a href='#' style='float:left;margin-left:15px;' onclick="submitForm('spawn_category_{$category['id']}');return false;" >Update</a>
                </div>
            </form>
        </div>
        <div class='clear'></div>
HTML_STR;
                    
    for ($z = 0; $z < $selected; $z++)
    {
        echoCategory($category, "spawn_$i");
    }
}