<?php 
    $categoriesTable = new DbObject($db, "question_categories", false);
    $questionsTable = new DbObject($db, 'questions2', false);
    $sectionsTable = new DbObject($db, "sections", false);

    @$sectionID = (int)$_GET['sectionID'] > 0 ? (int)$_GET['sectionID'] : (int)$_POST['sectionID'];

    require_once("singleQuestion.php");
?>
