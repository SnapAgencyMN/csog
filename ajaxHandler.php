<?php
require_once("index.php");

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
    
    $userID = getParameterNumber("userID");
    $answerID = getParameterNumber("answerID");
    $spawnID = getParameterNumber("spawnID");
    
    $value = $answersClass->getUserAnswers($userID, $answerID, $spawnID);
    
    echo $value[0]['value'];
}