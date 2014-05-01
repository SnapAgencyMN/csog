<?php
    if (!isset($questionsTable))
        $questionsTable = new DbObject($db, 'questions2', false);
    
    if(!isset($answersTable)) 
        $answersTable = new DbObject($db, 'answers2', false);

    @$questionID = (int)$_GET['questionID'] > 0 ? (int)$_GET['questionID'] : (int)$_POST['questionID'];
    @$sectionID = (int)$_GET['sectionID'] > 0 ? (int)$_GET['sectionID'] : (int)$_POST['sectionID'];

    require_once ("singleAnswer.php");
?>
