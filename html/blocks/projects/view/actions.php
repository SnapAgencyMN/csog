<?php


//pr_out($_POST);

$saveArray = array();
foreach ($_POST as $key => $value)
{
    $keyArr = explode("_", $key);
    if ($keyArr[0] == "other")
    {
        array_shift($keyArr);
        $otherID = array_shift($keyArr);
    }
    
    if (count($keyArr) >= 3)
    {
        $formattedValue = array();
        foreach ($keyArr as $part)
        {
            // Determine section type
            if ($part == "normal")
            {
                $type = "normal";
                $spawnID = 0;
            }
            
            if ($part == "spawn")
            {
                $type = "spawn";
                $spawnID = $keyArr[2];
            }
        }
        $inputType = $keyArr[0];
        
        if ($inputType == "radio")
        {
            
            $questionID = end($keyArr);
            $answersClass->clearUserSelection($_SESSION['USER']['ID'], $projectID, $questionID, $inputType, $spawnID);
            $answerDetails = $answersClass->getDetailsByLabel($value, $questionID);
            $formattedValue['answerID'] = $answerDetails[0]['id'];
            $formattedValue['value'] = 'on';
        }
        else
        {
            $formattedValue['answerID'] = end($keyArr);
            $formattedValue['value'] = $value;
        }
        
        // CLEAR USER CHECKBOXES FOR SECTION
        
        $formattedValue['type'] = $type;
        $formattedValue['other_seqID'] = empty($otherID) ? 0 : $otherID;
        $formattedValue['spawn_seqID'] = $spawnID;
        
        $saveArray[] = $formattedValue;
    }
}

if (!empty($saveArray))
{
    $sectionIDToSave = getParameterNumber('save_sectionID');
    
    $clear_categories = $categoriesClass->listCategories($sectionIDToSave);
    foreach ($clear_categories as $category)
    {
        $clear_questions = $questionsClass->listQuestions($category['id']);
        
        foreach ($clear_questions as $question)
        {
            $clear_answers = $answersClass->listAnswers($question['id']);
            
            foreach ($clear_answers as $answer)
            {
                $answersClass->clearAll($_SESSION['USER']['ID'], $projectID, $answer['id']);
            }
        }
    }
}

foreach ($saveArray as $saveValue)
{
    $spawnSeq = empty($saveValue['spawn_seqID']) ? 0 : $saveValue['spawn_seqID'];
    $otherSeq = empty($saveValue['other_seqID']) ? 0 : $saveValue['other_seqID'];
    
    if (!empty($saveValue['value']))
        $answersClass->saveUserAnswer($_SESSION['USER']['ID'], $projectID, $saveValue['answerID'], $saveValue['value'], $spawnSeq, $otherSeq);
}

