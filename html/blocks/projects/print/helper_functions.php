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
                for ($y=1; $y<=$spawnBoxes; $y++)
                {
                    printCategory($category, ($y-1)); // A hack to retrieve answer for the first spawn (which has a spawn value of 0)
                }
                break;
        }
    }

}

function printCategory ($category, $spawnID = -1)
{
    require_once ('special_categories.php');
    global $questionsClass, $html;

    if ($category['title'] == "Operation & Maintenance") // TODO: Add a case to print static PDF for Wastewater
        return;

    $suffix = "";
    if ($spawnID >= 0)
    {
        $sID = $spawnID+1;
        $suffix .= "#$sID";
    }
    else
        $spawnID = 0;

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
    debug("Printing out question = {$question['id']}");

    global $answersClass, $userID, $projectID, $html;
    
    $answers = $answersClass->listParentAnswers($question['id']);

    $currentQID = "";   
    debug("Answers are ".print_r($answers,true));
    foreach ($answers as $answer)
    {   
        $values = $answersClass->getUserAnswers($userID, $projectID, $answer['id'], $spawnID);
        if (!empty($values) || ($answer['type'] == "static" && $spawnID < 1))
        {
            if ($answer['type'] == "static")
            { // since values array is empty, triggering one print manually.
                switch ($question['title'])
                {
                    //Hack to enable print of certaing titles
                    case "O&M expense":
                        $html .= "<h4>{$question['title']}</h4>";
                        break;
                    default:
                        break;
                }
                debug ("Option 1");
                printAnswers($answer, $spawnID, 1);
            }
            else
            {
                if (empty($currentQID))
                {
                    $currentQID = $question['id'];
                    $html .= "<h4>{$question['title']}</h4>";
                }
            }
/*
            if (count($values) > 1)
            {
                debug("COUNT OF VALUES IS ".count($values));
                debug("VALUES FOR THIS ANSWER ARE ".print_r($values,true));
                die();
            }
*/            
            for ($i=0; $i<count($values); $i++)
            {
                debug ("Option 2");
                printAnswers($answer, $spawnID, $i);
            }
        }
	elseif ($answer['default'] == 1)
        {
            // check if answers on the same level exist
            foreach ($answers as $a)
            {
                $v = $answersClass->getUserAnswers($userID, $projectID, $a['id']);
                if (!empty($v))
                {
                    printAnswers($answer, $spawnID, 0);
                    debug ("Option 3");
                }
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
                    {
                        printAnswers($answer, $spawnID, 1);
                        debug ("Option 4");
                    }
                    for ($i=0; $i<count($child_values); $i++)
                    {
                        printAnswers($child, $spawnID, $i);
                        debug ("Option 5");
                    }
                }
		elseif ($child['default'] == 1)
                {
                    // Verify that parent answer is checked
                    $parentAnswer = $answersClass->getUserAnswers($userID, $projectID, $answer['id'], $spawnID, 0);

                    if (!empty($parentAnswer))
                    {
                        printAnswers($child, $spawnID, 0);
                        debug ("Option 6");
                    }
                }
            }
        } 
    }
}

function printAnswers($answer, $spawnID, $otherID)
{
    ini_set("display_errors", 1);
    debug("Printing out answer = {$answer['id']}");

    global $html, $answersClass, $userID, $projectID;
    @session_start();
    $pdfOutput = $answer['pdfOutput'];
    $value = "";
    $imageAssigned = false;
      
    preg_match_all("/%ID=[0-9]+%/", $pdfOutput, $ids);
      
    if (count($ids[0]) > 0 )
    { 
        foreach ($ids[0] as $id)
        {
            $id_arr = explode("=", $id);
            $answerID = trim($id_arr[1], "%");
            $id_value = $answersClass->getUserAnswers($userID, $projectID, $answerID, $spawnID, $otherID);

            if ($answerID == $answer['id'])
            {
                $pdfOutput = str_replace($id, "%SELF%", $pdfOutput);
                continue;
            }
            
            $value = $id_value[0]['value'];

            if (strstr($value, ".jpg") || strstr($value, ".jpeg") ||strstr($value, ".png") ||strstr($value, ".gif") ||strstr($value, ".tiff"))
            {
                $value = "<img style='border-style: solid; border-width: 1px;' src='/media/uploads/$value' /><br />";
		$imageAssigned = true;
            }

            $pdfOutput = str_replace("%ID=$answerID%", $value, $pdfOutput);
        }
    }

    preg_match_all("/%SELF%/", $pdfOutput, $selfRef);

    if (count($selfRef[0]) > 0 )
    {
        foreach ($selfRef[0] as $self)
        {
            $answerID = $answer['id'];
            $id_value = $answersClass->getUserAnswers($userID, $projectID, $answerID, $spawnID, $otherID);

            $value = $id_value[0]['value'];

	    if ($answer['type'] == 'image' && $answer['default'] == 1)
	    {
		if ($_SESSION['USER']['Admin'] == 1)
		{
		    $value = "<img style='border-style: solid; border-width: 1px;' src='/media/uploads/defaults/{$answer['id']}' /><br />";
		}
		elseif (!empty($value))
		{
			if (strstr($value, ".jpg") || strstr($value, ".jpeg") ||strstr($value, ".png") ||strstr($value, ".gif"))
			{
			    $value = "<img style='border-style: solid; border-width: 1px;' src='/media/uploads/$value' /><br />";
            		}
		}
  		else
		{
		    $value = "<img style='border-style: solid; border-width: 1px;' src='/media/uploads/defaults/{$answer['id']}' /><br />";
		}
		$imageAssigned = true;
            }
	    else
	    {
		if (strstr($value, ".jpg") || strstr($value, ".jpeg") ||strstr($value, ".png") ||strstr($value, ".gif"))
            	{
                    $value = "<img style='border-style: solid; border-width: 1px;' src='/media/uploads/$value' /><br />";
		    $imageAssigned = true;
            	}
            }

            $pdfOutput = str_replace("%SELF%", $value, $pdfOutput);
        }
    }

    /*
    preg_match_all("/@<.*>@/", $pdfOutput, $defaultImages);
    if(count($defaultImages[0]) > 0)
    {
        if ($imageAssigned == false )
        {
            foreach($defaultImages[0] as $image)
            {
                $pdfOutput = str_replace("@", "", $pdfOutput)."<br />";
            }
        }
        else
        {
            $pdfOutput = str_replace($defaultImages[0][0], "", $pdfOutput);
        }
    }
    */

    $html .= "<div class='content'>".$pdfOutput."</div>";
}

function rome($N)
{
    $c='IVXLCDM';
    for($a=5,$b=$s='';$N;$b++,$a^=7)
            for($o=$N%$a,$N=$N/$a^0;$o--;$s=$c[$o>2?$b+$N-($N&=-2)+$o=1:$b].$s);
    return $s;
}

function debug($m)
{
    return false;
    $date = date("Y-m-d H:i:s");
    $message = "[$date] $m";
    echo "$message<br />";
    error_log("$message\n");
}