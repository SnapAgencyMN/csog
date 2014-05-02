<?php
$action = getParameterString("action");

if ($action == "save_spawn_input");
{
    $categoryID = getParameterNumber("categoryID");
    $value = getParameterNumber("spawn_$categoryID");
    
    $categoriesClass->saveSpawnNumber($categoryID, $_SESSION['USER']['ID'], $value);
}