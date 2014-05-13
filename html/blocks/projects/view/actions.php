<?php


//pr_out($_POST);

$saveArray = array();
foreach ($_POST as $key => $value)
{
    $keyArr = explode("_", $key);
    
    if (count($keyArr) >= 3)
    {
        $formattedValue = array();
        foreach ($keyArr as $part)
        {
            // Determine section type
            if ($part == "normal")
                $type = "normal";
            
            if ($part == "spawn")
                $type = "spawn";
        }
        $inputType = $keyArr[0];
        
        
        if ($inputType == "radio")
        {
            $spawnID = ($type == "spawn") ? $keyArr[2] : 0;
            
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
        
        
        $formattedValue['type'] = $type;
        
        
        if (count($keyArr) == 4)
        {
            if ($type == 'normal')
                $formattedValue['other_seqID'] = $keyArr[1];
            
            if ($type == "spawn")
                $formattedValue['spawn_seqID'] = $keyArr[2];

        }
        
        if (count($keyArr) == 5)
        {
            $formattedValue['other_seqID'] = $keyArr[1];
            $formattedValue['spawn_seqID'] = $keyArr[3];
        }
        
        $saveArray[] = $formattedValue;
    }
}

//pr_out($saveArray);

foreach ($saveArray as $saveValue)
{
    $spawnSeq = empty($saveValue['spawn_seqID']) ? 0 : $saveValue['spawn_seqID'];
    $otherSeq = empty($saveValue['other_seqID']) ? 0 : $saveValue['other_seqID'];
    
    $answersClass->saveUserAnswer($_SESSION['USER']['ID'], $projectID, $saveValue['answerID'], $saveValue['value'], $spawnSeq, $otherSeq);
}

