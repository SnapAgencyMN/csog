<?php

function printAnswer($answer)
{
    switch ($answer['type'])
    {
        case "text":
            echo "
                <input type='text' name='{$answer['fieldName']}' id='answer_{$answer['id']}' class='textbox form_question' />
            ";
            break;
        case "radio":
            echo "
                <label class='form_question'>{$answer['label']}</label>
                <input type='radio' name='{$answer['fieldName']}' id='answer_{$answer['id']}' class='form_question' />
            ";
            break;
        case "checkbox":
            echo "
                <input type='checkbox' name='{$answer['fieldName']}' id='answer_{$answer['id']}' class='form_question checkbox' />
                <label class='form_question'>{$answer['label']}</label>
            ";
            break;
        case "image":
            echo "
                <a href='".WS_URL."media/uploads/139628533653399f98999a2.jpeg' data-lightbox='image-116'><img src='".WS_URL."media/uploads/139628533653399f98999a2.jpeg' class='imageLightboxLink'>
                    <img src='".WS_URL."media/uploads/139628533653399f98999a2.jpeg' class='imageLightboxLink'>
                </a>
                <iframe src='".WS_URL."html/blocks/fileupload.php?qID={$answer['answerID']}' class='upload_frame'></iframe>
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

function echoNormalCategory($category)
{
    global $questionsTable, $answersTable;
    
    echo "<h3 class='question_header'>{$category['title']}</h3>";

    $questions = $questionsTable->fetchAll(" WHERE `categoryID` = {$category['id']} ORDER BY `order`");

    echo "<div class='question_set_wrapper hidden'>";

    foreach ($questions as $question)
    {
        echo "
            <div class='question_set_row'>
                <div class='question_set_row_hint'>
                    <img src='".WS_URL."/media/hint.png' alt='Hint' title='{$question['hint']}'>
                </div>
                <div class='question_set_row_title'>
                    {$question['title']}
                </div>
        ";

        $answers = $answersTable->fetchAll(" WHERE `questionID` = {$question['id']} ORDER BY `order`");
        echo "<div class='question_set_row_field'>";
        foreach ($answers as $answer)
        {
            echo "<br />";
            printAnswer($answer);
            echo "<br />";
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
        echoNormalCategory($category);
    }
}