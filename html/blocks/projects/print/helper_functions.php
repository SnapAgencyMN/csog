<?php

function printSection($section)
{
    global $categoriesClass, $userID, $html;

    $html .= "<h2>{$section['title']}</h2>";
    
    $categories = $categoriesClass->listCategories($section['sectionID']);
    
    foreach ($categories as $category)
    {
        switch ($category['type'])
        {
            case "normal":
                printCategory($category);
                break;
            case "spawn":
                $spawnBoxes = $categoriesClass->getNumberOfSpawnBoxesForUser($category['id'], $userID);
                foreach ($spawnBoxes as $box)
                {
                    printCategory($category, $box);
                }
                break;
        }
    }
    
}

function printCategory ($category, $spawnID = 0)
{
    require_once ('special_categories.php');
    global $questionsClass, $html;
        
    $suffix = "";
    if ($spawnID > 0)
        $suffix .= "#$spawnID";
        
    $html .= "<h3>{$category['title']} $suffix</h3>";

    if (printSpecialCategories($category))
        return true;
    
    $questions = $questionsClass->listQuestions($category['id']);
    
    foreach ($questions as $question)
    {
        switch ($question['type'])
        {
            case "title":
            case "other":
            case "question":
                printQuestion($question, $spawnID);
                break;
        }
    }
}

function printQuestion($question, $spawnID)
{
    global $answersClass, $userID, $projectID, $html;
    
    $answers = $answersClass->listParentAnswers($question['id']);

    foreach ($answers as $answer)
    {   
        $values = $answersClass->getUserAnswers($userID, $projectID, $answer['id'], $spawnID);
      
        if (!empty($values) || $answer['type'] == "static")
        {
            if ($answer['type'] == "static") // since values array is empty, triggering one print manually.
                printAnswers($answer, $spawnID, 1);
            else
                $html .= "<h4>{$question['title']}</h4>";

            for ($i=0; $i<count($values); $i++)
            {
                printAnswers($answer, $spawnID, $i);
            }
        }
        
        $childrenAnswers = $answersClass->listChildren($answer['id']);
        
        if (count($childrenAnswers > 0))
        {
            foreach ($childrenAnswers as $child)
            {
                $child_values = $answersClass->getUserAnswers($userID, $projectID, $child['id'], $spawnID);

                if (!empty($child_values) || $child['type'] == "static")
                {
                    if ($child['type'] == "static") // since values array is empty, triggering one print manually.
                        printAnswers($answer, $spawnID, 1);
                    
                    for ($i=0; $i<count($child_values); $i++)
                    {
                        printAnswers($child, $spawnID, $i);
                    }
                }
            }
        }
    }
}

function printAnswers($answer, $spawnID, $otherID)
{
    global $html, $answersClass, $userID, $projectID;
        
    $pdfOutput = $answer['pdfOutput'];

    preg_match_all("%ID=[0-9]+%", $pdfOutput, $ids);

    if (count($ids) > 0 )
    {
        foreach ($ids[0] as $id)
        {
            $id_arr = explode("=", $id);
            $answerID = $id_arr[1];
            $id_value = $answersClass->getUserAnswers($userID, $projectID, $answerID, $spawnID, $otherID);
            
            $value = $id_value[0]['value'];
            
            if (strstr($value, ".jpg") || strstr($value, ".jpeg") ||strstr($value, ".png") ||strstr($value, ".gif"))
            {
                $value = "<img src='/media/uploads/$value' />";
            }
            
            $pdfOutput = str_replace("%ID=$answerID%", $value, $pdfOutput);
        }
    }
    
    preg_match_all("%SELF%", $pdfOutput, $selfRef);

    if (count($selfRef) > 0 )
    {
        foreach ($selfRef[0] as $self)
        {
            $answerID = $answer['id'];
            $id_value = $answersClass->getUserAnswers($userID, $projectID, $answerID, $spawnID, $otherID);
            
            $value = $id_value[0]['value'];
            
            if (strstr($value, ".jpg") || strstr($value, ".jpeg") ||strstr($value, ".png") ||strstr($value, ".gif"))
            {
                $value = "<img src='/media/uploads/$value' />";
            }
            
            $pdfOutput = str_replace("%SELF%", $value, $pdfOutput);
        }
    }
    $html .= "<div class='content'>".$pdfOutput."</div>";
}

function rome($N)
{ 
    $c='IVXLCDM'; 
    for($a=5,$b=$s='';$N;$b++,$a^=7) 
            for($o=$N%$a,$N=$N/$a^0;$o--;$s=$c[$o>2?$b+$N-($N&=-2)+$o=1:$b].$s); 
    return $s; 
} 
