<?php
require_once("index.php");
require_once("html/blocks/projects/view/helper_functions.php");

$action = getParameterString("action");

if ($action == "save_spawn_input")
{
    $categoriesClass = new Categories($db);
    
    $categoryID = getParameterNumber("categoryID");
    $value = getParameterNumber("value");
    
    $categoriesClass->saveSpawnNumber($categoryID, $_SESSION['USER']['ID'], $value);
    
    echo "success";
}

if ($action == "load_image")
{
    $answersClass = new Answers($db);
    
    $projectID = getParameterNumber('projectID');
    $userID = getParameterNumber("userID");
    $answerID = getParameterNumber("answerID");
    $spawnID = getParameterNumber("spawnID");
    
    if ($_SESSION['USER']['Admin']==1)
    {
        $value = "defaults/$answerID";
        echo $value;
    }
    else
    {
        $value = $answersClass->getUserAnswers($userID, $projectID, $answerID, $spawnID);
        echo $value[0]['value'];
    }
}

if ($action == "load_user_image")
{
    $id = getParameterString("id");
    
    if ($id != "0")
    {
        $sql = "SELECT * FROM temp_images WHERE imageName LIKE '$id%'";
        $tempDetails = Db::query($sql); 
        $tmpArray = Db::fetch_array($tempDetails);

        echo $tmpArray['imageName'];
    }
}

if ($action == "load_other_question_row")
{
    $answersClass = new Answers($db);
    $questionsClass = new Questions($db);
    
    $questionID = getParameterNumber("questionID");
    $type = getParameterString("type");
    $otherID = getParameterNumber("otherID");
    $intent = getParameterString("intent");
    
    $question = $questionsClass->getDetails($questionID);
    
    $answers = $answersClass->listAnswers($question['id']);
    
    $hint = "";
    if (!empty($question['hint']))
    {
        $hint = "<img src='".WS_URL."/media/hint.png' alt='Hint' title=\"{$question['hint']}\">";
    }

    echo "
        <div class='question_set_row' id='other_".$otherID."_".$type."_question_row_{$question['id']}'>
            <div style='padding-left:$intent' class='question_set_row_hint'>
                $hint
            </div>
            <div class='question_set_row_title'>
                {$question['title']}
            </div>
    ";
                
    echo "<div class='question_set_row_field'>";
    foreach ($answers as $answer)
    {
        $value[0]['other_sequenceID'] = $otherID;

        $divSuffix = "";
        $divClass = "";
        if ($answer['parentID'])
        {
            $divClass = "hidden child";
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

if ($action == "save_user_section")
{
    $sectionsClass = new Sections($db);
    
    $toggle = getParameterString("toggle");
    $sectionID = getParameterNumber('sectionID');
    $parentID = getParameterNumber("parentID");
    $projectID = getParameterNumber("projectID");
    
    if ($toggle == "on")
        $sectionsClass->addUserSection ($_SESSION['USER']['ID'], $sectionID, $parentID);
    else
        $sectionsClass->deleteUserSection ($_SESSION['USER']['ID'], $sectionID, $parentID);
    
    $sections = $sectionsClass->listChlidrenSectionsForUser($parentID, $_SESSION["USER"]["ID"]);
    
    foreach ($sections as $section)
    {
        $details = $sectionsClass->getDetails($section['sectionID']);
        
        echo "
            <li>
                <a href='".WS_URL."projects/view/$projectID/{$section['sectionID']}'>{$details['title']}</a>
            </li>
        ";
    }
}
