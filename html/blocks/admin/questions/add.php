<?php 
    $categoriesTable = new DbObject($db, "question_categories", false);
    
    if (!isset($questionsClass))
        $questionsClass = new Questions($db);
    
    $sectionsTable = new DbObject($db, "sections", false);

    $sectionID = getParameterNumber("sectionID");

    require_once("singleQuestion.php");
?>
