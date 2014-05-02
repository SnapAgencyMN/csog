<?php
require_once("helper_functions.php");

if (!isset($questionsTable))
    $questionsTable = new DbObject($db, 'questions2', false);

if (!isset($sectionsClass))
    $sectionsClass = new Sections($db);

if (!isset($categoriesClass))
    $categoriesClass = new Categories($db);

if (!isset($answersTable))
    $answersTable = new DbObject($db, 'answers2', false);

$sectionDetails = $sectionsClass->getDetails($sectionID);
$categories = $categoriesClass->listCategories($sectionID); 

require_once("actions.php");

// Print out section title
echo "<h2>{$sectionDetails['title']}</h2>";

if ($sectionDetails['type'] == "parent")
    require_once("parent_section.php");
else
{
    // Printing categories
    foreach ($categories as $category)
    {
        switch ($category['type'])
        {
            case "normal":
                echoNormalCategory($category);
                break;
            case "spawn":
                echoSpawnCategory($category);
                break;
            
        }
    }
}
