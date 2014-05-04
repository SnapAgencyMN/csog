<?php  
    if(!isset($answersClass)) 
        $answersClass = new Answers($db);

    $questionID = getParameterNumber("questionID");
    $sectionID = getParameterNumber("sectionID");

    require_once ("singleAnswer.php");
?>
