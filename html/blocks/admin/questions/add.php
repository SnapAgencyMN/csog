<?php 
    if (!isset($categoriesClass))
        $categoriesClass = new Categories ($db);
    
    if (!isset($questionsClass))
        $questionsClass = new Questions($db);
    
    $sectionID = getParameterNumber("sectionID");

    require_once("singleQuestion.php");
?>
