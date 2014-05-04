<?php
require_once("helper_functions.php");

if (!isset($questionsClass))
    $questionsClass = new Questions($db);

if (!isset($sectionsClass))
    $sectionsClass = new Sections($db);

if (!isset($categoriesClass))
    $categoriesClass = new Categories($db);

if (!isset($answersClass))
    $answersClass = new Answers($db);

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
                echoCategory($category, 'normal');
                break;
            case "spawn":
                echoSpawnCategory($category);
                break;
            
        }
    }
}
