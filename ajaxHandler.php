<?php
require_once("index.php");

$action = getParameterString("action");

if ($action == "save_spawn_input");
{
    $categoriesClass = new Categories($db);
    
    $categoryID = getParameterNumber("categoryID");
    $value = getParameterNumber("value");
    
    $categoriesClass->saveSpawnNumber($categoryID, $_SESSION['USER']['ID'], $value);
    
    echo "success";
}